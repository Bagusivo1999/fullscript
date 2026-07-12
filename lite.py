#!/usr/bin/env python3

import os
import sys
import asyncio
import json
import time
import re
import random
import contextlib
from datetime import datetime
from urllib.parse import urlparse, parse_qs, unquote
import subprocess

def sock():
    # Menjalankan perintah ifconfig, mengabaikan pesan error
    result = subprocess.run(
        "ifconfig",
        shell=True,
        capture_output=True,
        text=True
    )
    output = result.stdout  # Mengambil hasil output saja

    # Cek apakah ada kata 'tun0' (tidak peduli huruf besar/kecil)
    if re.search(r'tun0', output, re.IGNORECASE):
        print("\033[1;34mUps Internet Mu Tidak Sehat")
        print("Silakan Matikan Vpn Anda")
        sys.exit()  # Keluar dari program sepenuhnya

sock()


_devnull = open(os.devnull, 'w')
with contextlib.redirect_stdout(_devnull):
    from telethon.sync import TelegramClient
    from telethon.tl.types import InputPeerUser
    from telethon.tl.functions.messages import RequestWebViewRequest
_devnull.close()

HIJAU = "\033[92m"
MERAH = "\033[91m"
KUNING = "\033[93m"
BIRU = "\033[94m"
RESET = "\033[0m"
TEBAL = "\033[1m"

def buka_layar():
    if sys.stdout.isatty():
        sys.stdout.write("\033[?1049h")
        sys.stdout.flush()

def tutup_layar():
    if sys.stdout.isatty():
        sys.stdout.write("\033[?1049l")
        sys.stdout.flush()

API_ID = 38787744
API_HASH = "047e4afe5c7be80dc29988f4b4c8fd84"
BOT_USERNAME = "litebits_faucet_bot"
API_BASE = "https://mini.litebits.io/api"

import requests as _rq
_DEFAULT_HEADERS = {'Content-Type': 'application/json', 'Accept': 'application/json, text/plain, */*'}
_EXECUTOR = None

async def _get_executor():
    global _EXECUTOR
    if _EXECUTOR is None:
        loop = asyncio.get_event_loop()
        _EXECUTOR = loop.run_in_executor
    return _EXECUTOR

async def http_req(method, url, json_payload=None, headers=None, timeout=20):
    """Async HTTP request (requests di executor biar ga block event loop)"""
    run = await _get_executor()
    h = headers or _DEFAULT_HEADERS
    def _do():
        r = getattr(_rq, method)(url, json=json_payload, headers=h, timeout=timeout)
        return r.status_code, r.text
    return await run(None, _do)

async def http_post(url, payload=None, headers=None, timeout=20):
    return await http_req('post', url, payload, headers, timeout)

async def http_get(url, headers=None, timeout=20):
    return await http_req('get', url, None, headers, timeout)

async def get_init_data(session_path):
    """Ambil initData dari bot web app via Telethon"""
    client = TelegramClient(session_path, API_ID, API_HASH)
    await client.connect()
    try:
        bot = await client.get_entity(BOT_USERNAME)
        result = await client(RequestWebViewRequest(
            peer=InputPeerUser(user_id=bot.id, access_hash=bot.access_hash),
            bot=InputPeerUser(user_id=bot.id, access_hash=bot.access_hash),
            platform='android',
            url="https://mini.litebits.io/",
        ))
        parsed = urlparse(result.url)
        fragment = parse_qs(parsed.fragment)

        if 'tgWebAppData' in fragment:
            init_data = unquote(fragment['tgWebAppData'][0])
            return init_data
    finally:
        await client.disconnect()
    return None

class LiteBitsBot:
    def __init__(self, info_akun):
        self.session_path = info_akun['session_path']
        self.nama = info_akun['nama']
        self.phone = info_akun.get('phone', info_akun['nama'])
        self.headers = {
            'User-Agent': ("Mozilla/5.0 (Linux; Android 12; Pixel 6) "
                           "AppleWebKit/537.36 (KHTML, like Gecko) "
                           "Chrome/131.0.6778.200 Mobile Safari/537.36"),
            'Accept': "application/json, text/plain, */*",
            'Content-Type': "application/json",
            'Origin': "https://mini.litebits.io",
            'Referer': "https://mini.litebits.io/",
        }
        self.token = None
        self.saldo = "0"
        self.last_claim_at = None
        self.claim_interval = 300

    async def auth(self):
        try:
            init_data = await get_init_data(self.session_path)
            if not init_data:
                return False, "Gagal ambil initData"

            sc, text = await http_post(
                f"{API_BASE}/auth/telegram/validate",
                {"initData": init_data, "referralCode": None},
                self.headers
            )

            if sc == 200:
                data = json.loads(text)
                if data.get("success") and data.get("token"):
                    self.token = data["token"]
                    self.headers['authorization'] = f"Bearer {self.token}"
                    user = data.get("user", {})
                    self.saldo = str(user.get("balance", 0))
                    self.last_claim_at = user.get("lastClaim")
                    return True, "OK"

            return False, f"Auth error {sc}"
        except Exception as e:
            return False, str(e)[:60]

    async def cek_saldo(self):
        if not self.token:
            return False
        try:
            sc, text = await http_get(f"{API_BASE}/user/profile", headers=self.headers, timeout=10)
            if sc == 401:
                return False
            if sc == 200:
                data = json.loads(text)
                self.saldo = str(data.get("balance", 0))
                self.last_claim_at = data.get("lastClaim")
                return True
        except Exception:
            pass
        return False

    async def ambil_claim_interval(self):
        """GET /api/app-settings → claimInterval × 3600 = cooldown detik"""
        try:
            sc, text = await http_get(f"{API_BASE}/app-settings", headers=self.headers, timeout=10)
            if sc == 200:
                data = json.loads(text)
                ci = data.get("claimInterval")
                if ci:
                    self.claim_interval = max(60, int(float(ci) * 3600))
                return True
        except Exception:
            pass
        return False

    def hitung_sisa_cooldown(self):
        if not self.last_claim_at:
            return 0
        try:
            if isinstance(self.last_claim_at, str):
                dt = datetime.fromisoformat(self.last_claim_at.replace('Z', '+00:00'))
                ts = int(dt.timestamp())
            elif isinstance(self.last_claim_at, (int, float)):
                ts = int(self.last_claim_at)
            else:
                return 0
            sisa = ts + self.claim_interval - int(time.time())
            return max(0, sisa)
        except Exception:
            return 0

    async def klaim(self):
        """Flow: POST /claim/start → tunggu → POST /claim/{id}/complete
        Return: (berhasil, cooldown, pesan)"""
        payload = {
            "h-captcha-response": "",
            "captchaProvider": "hcaptcha",
            "tapTimings": [],
            "fingerprint": "aded85a7db40a655efe75e8e87c4c244"
        }

        try:
            sc, text = await http_post(
                f"{API_BASE}/claim/start",
                payload, self.headers
            )

            if sc == 401:
                return False, 60, "Unauthorized"

            if sc == 428:
                return False, self.claim_interval, "Captcha 428"

            if sc == 200:
                data = json.loads(text)

                if data.get("requiresCaptcha"):
                    return False, self.claim_interval, "Captcha required"

                if data.get("success"):
                    cid = data.get("claimId")
                    if cid:
                        await asyncio.sleep(3)

                        sc2, text2 = await http_post(
                            f"{API_BASE}/claim/{cid}/complete",
                            {}, self.headers
                        )
                        if sc2 == 200:
                            comp = json.loads(text2)
                            if comp.get("success"):
                                new_bal = comp.get("newBalance")
                                reward = comp.get("reward")
                                if new_bal is not None:
                                    self.saldo = str(new_bal)
                                self.last_claim_at = datetime.utcnow().isoformat() + "Z"
                                return True, self.claim_interval, f"+{reward} Sats"
                    return False, self.claim_interval, "Claim gagal"
                else:
                    return False, self.claim_interval, "Claim gagal"

        except json.JSONDecodeError:
            return False, 60, "Bukan JSON"
        except Exception as e:
            return False, 60, f"Error: {str(e)[:40]}"
        return False, 60, "Unknown"

    async def daily_visit(self):
        try:
            sc, text = await http_post(
                f"{API_BASE}/daily-visit/check",
                {}, self.headers
            )
            if sc == 200:
                data = json.loads(text)
                return data.get("claimed", False)
        except Exception:
            pass
        return False


STATUS_AKUN = {}
RIWAYAT = []
TOTAL_BERHASIL = 0
TOTAL_GAGAL = 0

def tambah_riwayat(akun, pesan):
    sekarang = datetime.now().strftime('%H:%M:%S')
    RIWAYAT.append(f"{sekarang} | {akun} | {pesan}")
    if len(RIWAYAT) > 50:
        RIWAYAT.pop(0)

def format_waktu(detik):
    if detik <= 0:
        return "-"
    if detik >= 3600:
        j = detik // 3600
        m = (detik % 3600) // 60
        return f"{j}j {m}m"
    elif detik >= 60:
        m = detik // 60
        d = detik % 60
        return f"{m}m {d}d"
    return f"{detik}d"


async def pekerja_akun(info_akun):
    global TOTAL_BERHASIL, TOTAL_GAGAL

    bot = LiteBitsBot(info_akun)
    key = info_akun['session_path']
    nama = info_akun['nama']

    STATUS_AKUN[key] = {'nama': nama, 'status': "AUTH...", 'saldo': "0"}

    STATUS_AKUN[key]['status'] = "AUTH..."
    ok, msg = await bot.auth()
    if not ok:
        STATUS_AKUN[key]['status'] = "GAGAL AUTH"
        TOTAL_GAGAL += 1
        tambah_riwayat(nama, f"GAGAL — Auth: {msg}")
        return

    STATUS_AKUN[key]['status'] = "LOAD..."
    await bot.ambil_claim_interval()
    await asyncio.sleep(1)

    await bot.cek_saldo()
    STATUS_AKUN[key]['saldo'] = bot.saldo

    sisa = bot.hitung_sisa_cooldown()
    if sisa > 0:
        for t in range(sisa, 0, -1):
            STATUS_AKUN[key]['status'] = format_waktu(t)
            await asyncio.sleep(1)

    STATUS_AKUN[key]['status'] = "DAILY..."
    if await bot.daily_visit():
        await asyncio.sleep(1)

    STATUS_AKUN[key]['status'] = "SIAP"

    while True:
        try:
            STATUS_AKUN[key]['status'] = "KLAIM..."
            berhasil, cooldown, pesan = await bot.klaim()

            if not berhasil:
                for retry in range(3):
                    STATUS_AKUN[key]['status'] = f"RETRY {retry + 1}/3"
                    await asyncio.sleep(3)
                    berhasil, cooldown, pesan = await bot.klaim()
                    if berhasil:
                        break

            if berhasil:
                TOTAL_BERHASIL += 1
                STATUS_AKUN[key]['saldo'] = bot.saldo
                tambah_riwayat(nama, f"OK {pesan} | Saldo: {bot.saldo}")
            else:
                TOTAL_GAGAL += 1
                tambah_riwayat(nama, f"GAGAL — {pesan}")

            STATUS_AKUN[key]['status'] = "CEK..."
            await bot.cek_saldo()
            STATUS_AKUN[key]['saldo'] = bot.saldo

            sisa = bot.hitung_sisa_cooldown()
            if sisa <= 0:
                sisa = bot.claim_interval

            for t in range(sisa, 0, -1):
                STATUS_AKUN[key]['status'] = format_waktu(t)
                await asyncio.sleep(1)

            jeda = random.randint(10, 30)
            STATUS_AKUN[key]['status'] = f"JEDA {jeda}d"
            await asyncio.sleep(jeda)

            STATUS_AKUN[key]['status'] = "SIAP"

        except asyncio.CancelledError:
            break
        except Exception as e:
            tambah_riwayat(nama, f"Error: {str(e)[:50]}")
            await asyncio.sleep(10)


async def tampilan():
    buka_layar()
    try:
        while True:
            sys.stdout.write("\033[H\033[J")

            sys.stdout.write(f"{TEBAL}{HIJAU}  LITEBITS FAUCET BOT{RESET}\n")
            sys.stdout.write(f"{HIJAU}{'─' * 55}{RESET}\n")

            total = len(STATUS_AKUN)
            aktif = sum(1 for d in STATUS_AKUN.values()
                        if any(k in d['status'] for k in ['SIAP', 'KLAIM', 'CEK', 'RETRY']))
            sys.stdout.write(
                f"  Akun: {TEBAL}{BIRU}{total}{RESET}  |  "
                f"Aktif: {TEBAL}{HIJAU}{aktif}{RESET}  |  "
                f"OK: {TEBAL}{HIJAU}{TOTAL_BERHASIL}{RESET}  "
                f"Fail: {TEBAL}{MERAH}{TOTAL_GAGAL}{RESET}\n"
            )
            sys.stdout.write(f"{HIJAU}{'─' * 55}{RESET}\n")
            sys.stdout.write(f"  {TEBAL}{'AKUN':<18}{'SALDO':<12}{'STATUS'}{RESET}\n")
            sys.stdout.write(f"{HIJAU}{'─' * 55}{RESET}\n")

            for key, data in STATUS_AKUN.items():
                s = data['status']
                if "SIAP" in s:
                    w = HIJAU
                elif "OK" in s:
                    w = HIJAU
                elif "GAGAL" in s:
                    w = MERAH
                elif "BLOKIR" in s:
                    w = MERAH
                elif "RETRY" in s:
                    w = KUNING
                elif s and s[0].isdigit():
                    w = KUNING
                else:
                    w = BIRU
                sys.stdout.write(f"  {data['nama']:<18}{data['saldo']:<12}{w}{s}{RESET}\n")

            sys.stdout.write(f"{HIJAU}{'─' * 55}{RESET}\n")
            sys.stdout.write(f"  {TEBAL}RIWAYAT:{RESET}\n")
            for log in RIWAYAT[-8:]:
                sys.stdout.write(f"  {HIJAU}{log}{RESET}\n")

            sys.stdout.flush()
            await asyncio.sleep(1)
    finally:
        tutup_layar()


async def telethon_login_session(nomor):
    """Login via nomor telepon, simpan session file, return path"""
    session_dir = os.path.join(os.getcwd(), "Session_Telegram")
    os.makedirs(session_dir, exist_ok=True)
    session_path = os.path.join(session_dir, f"{nomor.replace('+', '')}.session")
    client = TelegramClient(session_path, API_ID, API_HASH)
    await client.connect()
    try:
        sent_code = await client.send_code_request(nomor)
        print(f"{TEBAL}{KUNING}Kode konfirmasi dikirim ke {nomor}{RESET}")
        kode = input(f"{TEBAL}{HIJAU}Masukkan kode: {RESET}").strip()
        await client.sign_in(phone=nomor, phone_code_hash=sent_code.phone_code_hash, code=kode)
    except Exception as e:
        err = str(e)
        if "2FA" in err or "password" in err.lower():
            pwd = input(f"{TEBAL}{HIJAU}2FA password: {RESET}").strip()
            await client.sign_in(password=pwd)
        else:
            print(f"{MERAH}Login gagal: {err[:60]}{RESET}")
            await client.disconnect()
            return None
    me = await client.get_me()
    nama = me.first_name or me.last_name or nomor
    await client.disconnect()
    print(f"{HIJAU}Login OK: {nama} (ID: {me.id}){RESET}")
    return session_path, nama


async def mode_tambah():
    print(f"\n{TEBAL}{HIJAU}========== TAMBAH AKUN =========={RESET}\n")
    print(f"{KUNING}  Login nomor telepon baru berawalan (+62...){RESET}")
    print(f"{KUNING}  Jika Selesai Kosongkan input lalu tekan ENTER{RESET}")

    print()

    while True:
        masukan = input(f"{TEBAL}{HIJAU}Nomor Akun : {RESET}").strip()
        if not masukan:
            break

        if masukan.startswith('+') or masukan.startswith('0'):
            nomor = masukan if masukan.startswith('+') else f"+62{masukan[1:]}"
            print(f"{KUNING}  Login ke {nomor}...{RESET}")
            try:
                result = await telethon_login_session(nomor)
                if result:
                    session_path, nama_login = result
                    print(f"{HIJAU}  + Akun '{nama_login}' login berhasil.{RESET}")
                else:
                    print(f"{MERAH}  Login gagal, coba lagi.{RESET}")
            except Exception as e:
                print(f"{MERAH}  Error: {str(e)[:60]}{RESET}")
        else:
            print(f"{MERAH}Input tidak valid. Ketik nomor HP (+62...){RESET}")

    print(f"\n{TEBAL}{HIJAU}Selesai menambah akun.{RESET}")


def detect_sessions():
    """Scan folder saat ini untuk file .session, return list of dict"""
    sessions = []
    folder = os.path.join(os.getcwd(), "Session_Telegram")
    if not os.path.isdir(folder):
        return sessions
    for fname in sorted(os.listdir(folder)):
        if fname.endswith('.session'):
            path = os.path.abspath(os.path.join(folder, fname))
            if os.path.getsize(path) < 64:
                continue
            nama = fname.replace('.session', '')
            sessions.append({
                "session_path": path,
                "nama": nama,
                "phone": nama
            })
    return sessions


async def cek_status_akun(sessions):
    """Cek status tiap akun: auth + cek saldo, return list (akun, status_label)."""
    hasil = []
    total = len(sessions)
    print(f"\n{TEBAL}{KUNING}Mengecek status {total} akun...{RESET}")

    for i, s in enumerate(sessions, 1):
        nama = s['nama']
        sys.stdout.write(f"\r  {KUNING}[{i}/{total}] Cek {nama}...{' ' * 20}{RESET}")
        sys.stdout.flush()

        bot = LiteBitsBot(s)
        ok_auth, msg_auth = await bot.auth()
        if not ok_auth:
            hasil.append((s, "Unknown"))
            continue

        ok_saldo = await bot.cek_saldo()
        if ok_saldo:
            hasil.append((s, "200 OK"))
        else:
            if "Blokir" in msg_auth.upper() or "401" in msg_auth or "403" in msg_auth:
                hasil.append((s, "Akun di Blokir"))
            else:
                hasil.append((s, "200 OK"))

    print(f"\r{' ' * 60}\r", end="")
    return hasil


async def main():
    if len(sys.argv) > 1 and sys.argv[1] == '--tambah':
        await mode_tambah()
        return

    detected = detect_sessions()
    if detected:
        os.system('cls' if os.name == 'nt' else 'clear')
        print(f"\n{TEBAL}{HIJAU}Akun tersedia:{RESET}\n")
        for i, s in enumerate(detected, 1):
            print(f"  {BIRU}{i}.{RESET} {s['nama']}")
        print()

        jawab = input(f"{TEBAL}{KUNING}Tambah akun lagi (y/n) ? {RESET}").strip().lower()
        if jawab == 'y':
            await mode_tambah()
            detected = detect_sessions()
            if not detected:
                print(f"{MERAH}Tidak ada session ditemukan.{RESET}")
                sys.exit(1)
    else:
        print(f"{TEBAL}{MERAH}Tidak ada file .session ditemukan di folder ini.{RESET}")
        await mode_tambah()
        detected = detect_sessions()
        if not detected:
            print(f"{MERAH}Tidak ada akun. Keluar.{RESET}")
            sys.exit(1)

    os.system('cls' if os.name == 'nt' else 'clear')
    hasil_cek = await cek_status_akun(detected)

    print(f"\n{TEBAL}Akun yang tersedia:{RESET}\n")
    for i, (s, status) in enumerate(hasil_cek, 1):
        if status == "200 OK":
            warna = HIJAU
        elif "Blokir" in status:
            warna = MERAH
        else:
            warna = KUNING
        print(f"  {BIRU}{i}.{RESET} {s['nama']} | {warna}{status}{RESET}")

    akun_aktif = [s for s, status in hasil_cek if status == "200 OK"]
    akun_skip = [s for s, status in hasil_cek if status != "200 OK"]

    print()
    if not akun_aktif:
        print(f"{TEBAL}{MERAH}Tidak ada akun aktif (200 OK). Keluar.{RESET}")
        sys.exit(1)

    print(f"{HIJAU}Akun aktif: {len(akun_aktif)} | Dilewati: {len(akun_skip)}{RESET}")

    lanjut = input(f"\n{TEBAL}{KUNING}Lanjutkan (y/n) ? {RESET}").strip().lower()
    if lanjut != 'y':
        print(f"{KUNING}Dibatalkan.{RESET}")
        sys.exit(0)

    print(f"\n{TEBAL}{HIJAU}Memuat {len(akun_aktif)} akun...{RESET}")
    for i, acc in enumerate(akun_aktif, 1):
        print(f"  [{i}] {acc.get('nama', '?')}")
        key = acc['session_path']
        STATUS_AKUN[key] = {'nama': acc['nama'], 'status': "MULAI", 'saldo': "0"}

    print(f"{TEBAL}{HIJAU}Mulai... (Ctrl+C berhenti){RESET}\n")
    await asyncio.sleep(1)

    tugas = [asyncio.create_task(pekerja_akun(acc)) for acc in akun_aktif]
    tugas.append(asyncio.create_task(tampilan()))
    await asyncio.gather(*tugas)


if __name__ == "__main__":
    wake_locked = False
    try:
        if os.name != 'nt' and os.path.exists('/data/data/com.termux'):
            os.system("termux-wake-lock")
            wake_locked = True
        asyncio.run(main())
    except KeyboardInterrupt:
        print(f"\n{HIJAU}Dihentikan.{RESET}")
        tutup_layar()
    finally:
        if wake_locked:
            os.system("termux-wake-unlock")
        sys.exit(0)