#!/usr/bin/env python3

import os
import sys
import asyncio
import json
import hashlib
import random
import contextlib
from datetime import datetime
from urllib.parse import urlparse, parse_qs, unquote
import re
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


with contextlib.redirect_stdout(open(os.devnull, 'w')):
    from telethon.sync import TelegramClient
    from telethon.tl.types import InputPeerUser, InputBotAppShortName
    from telethon.tl.functions.messages import RequestAppWebViewRequest

HIJAU = "\033[92m"
MERAH = "\033[91m"
KUNING = "\033[93m"
BIRU = "\033[94m"
RESET = "\033[0m"
TEBAL = "\033[1m"

def buka_layar():
    sys.stdout.write("\033[?1049h")
    sys.stdout.flush()

def tutup_layar():
    sys.stdout.write("\033[?1049l")
    sys.stdout.flush()

API_ID = 38787744
API_HASH = "047e4afe5c7be80dc29988f4b4c8fd84"
BOT_USERNAME = "fbtc0bot"
API_BASE = "https://btc.tonrevenue.space/api"
GIGA_V1 = "https://ad.gigapub.tech/v1/ad"

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

def parse_tg_user(init_data):
    """Parse user info dari tgWebAppData string"""
    try:
        params = dict(pair.split('=', 1) for pair in init_data.split('&') if '=' in pair)
        from urllib.parse import unquote
        user_json = json.loads(unquote(params.get('user', '{}')))
        return user_json
    except Exception:
        return {'id': 0}

_UA_ANDROID = ("Mozilla/5.0 (Linux; Android 12; Pixel 6) "
               "AppleWebKit/537.36 (KHTML, like Gecko) "
               "Chrome/131.0.6778.200 Mobile Safari/537.36")
_UA_IOS = ("Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) "
          "AppleWebKit/605.1.15 (KHTML, like Gecko) "
          "Version/17.4 Mobile/15E148 Safari/604.1")

_DEVICE_PROFILES = {
    "android": {"ua": _UA_ANDROID, "screen": "412x915", "platform": "Linux armv8l",
                 "viewport_width": 412, "viewport_height": 915},
    "ios": {"ua": _UA_IOS, "screen": "390x844", "platform": "iPhone",
             "viewport_width": 390, "viewport_height": 844},
}

def generate_fingerprint(ua_platform="android"):
    """Generate fake FingerprintJS-style visitorId + device info"""
    prof = _DEVICE_PROFILES.get(ua_platform, _DEVICE_PROFILES["android"])
    ua = prof["ua"]
    raw = f"{ua}|{ua_platform}|en-US|en,id|8|4|5|{prof['screen']}|24|Asia/Jakarta"
    visitor_id = hashlib.md5(raw.encode()).hexdigest()
    info = {
        "ua": ua, "screen": prof["screen"], "lang": "en-US",
        "tz": "Asia/Jakarta", "platform": prof["platform"], "tg_platform": ua_platform,
        "viewport_width": prof["viewport_width"], "viewport_height": prof["viewport_height"],
        "max_touch_points": 5, "device_pixel_ratio": 3
    }
    return visitor_id, info

def generate_interaction(device_info):
    """Generate realistic touch interaction data"""
    return {
        "pointer_type": "touch",
        "page_x_norm": round(random.uniform(0.3, 0.7), 4),
        "page_y_norm": round(random.uniform(0.3, 0.7), 4),
        "button_x_norm": round(random.uniform(0.35, 0.65), 4),
        "button_y_norm": round(random.uniform(0.35, 0.65), 4),
        "press_ms": random.randint(80, 250),
        "move_count": random.randint(0, 4),
        "path_length": round(random.uniform(0.0, 0.05), 5),
        "screen_orientation": "portrait-primary",
        **{k: v for k, v in device_info.items() if k != "ua"}
    }

async def get_init_data(session_path):
    """Ambil initData dari bot web app via Telethon"""
    client = TelegramClient(session_path, API_ID, API_HASH)
    await client.connect()
    try:
        bot = await client.get_entity(BOT_USERNAME)
        app = InputBotAppShortName(
            bot_id=InputPeerUser(user_id=bot.id, access_hash=bot.access_hash),
            short_name='app'
        )
        result = await client(RequestAppWebViewRequest(
            peer=InputPeerUser(user_id=bot.id, access_hash=bot.access_hash),
            app=app,
            platform='android',
            write_allowed=False,
        ))
        parsed = urlparse(result.url)
        fragment = parse_qs(parsed.fragment)

        if 'tgWebAppData' in fragment:
            init_data = unquote(fragment['tgWebAppData'][0])
            start_param = fragment.get('tgWebAppStartParam', [''])[0]
            return init_data, start_param
    finally:
        await client.disconnect()
    return None, None

class FBTC0Bot:
    def __init__(self, info_akun):
        self.session_path = info_akun['session_path']
        self.nama = info_akun['nama']
        self.phone = info_akun.get('phone', info_akun['nama'])
        self.init_data = None
        self.start_param = ""
        self.saldo = 0
        self.cooldown_server = 0
        self.captcha_required = False
        self.is_blocked = False
        self.adexium_remaining = 0
        self.adexium_reset_at = None

        self.fp_id, self.device_info = generate_fingerprint("android")

        self.headers = {
            'User-Agent': self.device_info['ua'],
            'Accept': "application/json, text/plain, */*",
            'Content-Type': "application/json",
            'Origin': "https://btc.tonrevenue.space",
            'Referer': "https://btc.tonrevenue.space/",
        }

    def _payload_base(self):
        """Base payload untuk semua request"""
        return {
            "initData": self.init_data,
            "start_param": self.start_param,
            "fingerprint": self.fp_id,
            **self.device_info
        }

    def _claim_payload(self):
        """Payload untuk claim (initData + interaction)"""
        interaction = generate_interaction(self.device_info)
        return {
            "initData": self.init_data,
            "interaction": interaction
        }

    async def auth(self):
        """Ambil initData sekali via Telethon"""
        try:
            self.init_data, self.start_param = await get_init_data(self.session_path)
            if not self.init_data:
                return False, "Gagal ambil initData"
            return True, "OK"
        except Exception as e:
            return False, str(e)[:60]

    async def init_app(self):
        """POST /api/init — cek saldo, cooldown, captcha, blokir"""
        try:
            payload = self._payload_base()
            status_code, text = await http_post(f"{API_BASE}/init", payload, self.headers)

            if status_code == 401 or status_code == 403:
                return False, "Unauthorized/Blokir"

            if status_code != 200:
                return False, f"Init error {status_code}"

            data = json.loads(text)
            if data.get("status") != "success":
                return False, "Init gagal"

            user = data.get("user", {})
            self.saldo = user.get("balance", 0)
            self.cooldown_server = user.get("cooldown", 0)
            self.captcha_required = user.get("captcha_required", False)
            self.is_blocked = user.get("is_blocked", False)

            if self.is_blocked:
                return False, "AKUN BLOKIR"

            access = data.get("access", {})
            if access.get("mobile_only_blocked"):
                self.fp_id, self.device_info = generate_fingerprint("ios")
                self.headers['User-Agent'] = self.device_info['ua']
                return await self.init_app()

            return True, "OK"

        except json.JSONDecodeError:
            return False, "Init response bukan JSON"
        except Exception as e:
            return False, str(e)[:50]

    async def solve_captcha(self):
        """POST /api/captcha/challenge → verify — auto solve emoji captcha"""
        try:
            sc, text = await http_post(f"{API_BASE}/captcha/challenge",
                                        {"initData": self.init_data}, self.headers)
            if sc != 200:
                return False

            data = json.loads(text)
            challenge = data.get("challenge", {})
            challenge_id = challenge.get("challenge_id")
            prompt = challenge.get("prompt", "").lower()
            options = challenge.get("options", [])

            if not challenge_id or not options:
                return False

            answer_id = None
            for opt in options:
                label = opt.get("label", "").lower()
                emoji = opt.get("emoji", "")
                if label and label in prompt:
                    answer_id = opt.get("id")
                    break
            if not answer_id:
                for opt in options:
                    label = opt.get("label", "").lower()
                    emoji = opt.get("emoji", "").lower()
                    for word in prompt.split():
                        if len(word) > 2 and (word in label or word in emoji):
                            answer_id = opt.get("id")
                            break
                    if answer_id:
                        break

            if not answer_id and options:
                answer_id = random.choice(options).get("id")

            if not answer_id:
                return False

            sc2, text2 = await http_post(f"{API_BASE}/captcha/verify", {
                "initData": self.init_data,
                "challenge_id": challenge_id,
                "answer": answer_id
            }, self.headers)

            return sc2 == 200

        except Exception:
            return False

    async def _gigapubs_bypass(self, session_uid):
        """Bypass GigaPubs: panggil v1/ad init + adShowed → trigger postback"""
        try:
            tg_user = parse_tg_user(self.init_data)
            giga_headers = {
                'Content-Type': 'application/json',
                'project-id': '5736',
                'User-Agent': self.device_info['ua'],
            }
            giga_user = {
                'user': tg_user,
                'platform': self.device_info['tg_platform'],
                'version': '10.0',
                'start_param': self.start_param
            }
            await http_post(GIGA_V1, {
                'method': 'init',
                'args': {'user': giga_user, 'version': 'v85', 'seconds': 5}
            }, giga_headers)
            await asyncio.sleep(0.5)
            await http_post(GIGA_V1, {
                'method': 'adShowed',
                'args': {
                    'user': giga_user, 'placementId': 'main',
                    'network': 'gigapubs', 'rotationType': 'fallback',
                    'showCounter': 0, 'transactionId': session_uid,
                    'version': 'v85', 'seconds': 8, 'anyData': {}
                }
            }, giga_headers)
            return True
        except Exception:
            return False

    async def _poll_balance(self, max_wait=15):
        """Poll init sampai balance berubah atau cooldown aktif"""
        old_saldo = self.saldo
        for _ in range(max_wait):
            await asyncio.sleep(1)
            ok, _ = await self.init_app()
            if not ok:
                continue
            if self.cooldown_server > 0 or self.saldo > old_saldo:
                return True
        return False

    async def klaim(self):
        """Full claim flow:
        1. POST /api/claim
        2. Jika success → selesai
        3. Jika ad_required + gigapubs → bypass via gigapubs v1/ad API
        4. Jika ad_required + adexium → confirm langsung (bypass lama)
        5. Jika 428 captcha → solve captcha → retry claim
        """
        if not self.init_data:
            return False, 0, "No initData"

        if self.captcha_required:
            if await self.solve_captcha():
                self.captcha_required = False
            else:
                return False, 60, "Captcha gagal"

        try:
            payload = self._claim_payload()
            sc, text = await http_post(f"{API_BASE}/claim", payload, self.headers)

            if sc == 428:
                if await self.solve_captcha():
                    self.captcha_required = False
                    await asyncio.sleep(1)
                    sc, text = await http_post(f"{API_BASE}/claim", payload, self.headers)
                else:
                    return False, 60, "Captcha 428 gagal"

            if sc != 200:
                return False, 60, f"HTTP {sc}"

            data = json.loads(text)
            status = data.get("status", "")

            if status == "success":
                self.saldo = data.get("new_balance", self.saldo)
                reward = data.get("reward", 0)
                cooldown = data.get("cooldown", 300)
                return True, cooldown, f"+{reward} sat"

            if status == "ad_required":
                session_uid = data.get("session_uid")
                provider = data.get("provider", "")
                reward_sats = data.get("reward_sats", 0)
                self.adexium_remaining = data.get("adexium_remaining", 0)
                adexium_reset = data.get("adexium_reset_at")
                if adexium_reset:
                    try:
                        from datetime import datetime
                        self.adexium_reset_at = datetime.fromisoformat(adexium_reset.replace("Z", "+00:00"))
                    except Exception:
                        self.adexium_reset_at = None

                if not session_uid:
                    return False, 60, "No session_uid"

                if provider == "gigapubs":
                    bypass_ok = await self._gigapubs_bypass(session_uid)
                    if bypass_ok and await self._poll_balance(max_wait=15):
                        ok_init, _ = await self.init_app()
                        if ok_init:
                            return True, self.cooldown_server or 300, f"+{reward_sats} sat"
                    if self.adexium_remaining > 0:
                        await asyncio.sleep(random.uniform(2.5, 4.0))
                        sc2, text2 = await http_post(f"{API_BASE}/claim/confirm", {
                            "initData": self.init_data,
                            "session_uid": session_uid
                        }, self.headers)
                        if sc2 == 200:
                            data2 = json.loads(text2)
                            if data2.get("status") == "success":
                                self.saldo = data2.get("new_balance", self.saldo)
                                return True, data2.get("cooldown", 300), f"+{data2.get('reward', reward_sats)} sat"
                    return False, 120, "GigaPubs bypass gagal"

                if provider == "adexium":
                    await asyncio.sleep(random.uniform(2.5, 4.0))
                    sc2, text2 = await http_post(f"{API_BASE}/claim/confirm", {
                        "initData": self.init_data,
                        "session_uid": session_uid
                    }, self.headers)
                    if sc2 == 200:
                        data2 = json.loads(text2)
                        if data2.get("status") == "success":
                            self.saldo = data2.get("new_balance", self.saldo)
                            return True, data2.get("cooldown", 300), f"+{data2.get('reward', reward_sats)} sat"
                    sc_fb, text_fb = await http_post(f"{API_BASE}/claim/fallback", {
                        "initData": self.init_data
                    }, self.headers)
                    if sc_fb == 200:
                        d_fb = json.loads(text_fb)
                        fb_uid = d_fb.get("session_uid")
                        if fb_uid and d_fb.get("provider") == "gigapubs":
                            bypass_ok = await self._gigapubs_bypass(fb_uid)
                            if bypass_ok and await self._poll_balance(max_wait=15):
                                ok_init, _ = await self.init_app()
                                if ok_init:
                                    return True, self.cooldown_server or 300, f"+{reward_sats} sat"
                    return False, 120, "Adexium + GigaPubs gagal"

            return False, 60, f"Status: {status}"

        except json.JSONDecodeError:
            return False, 60, "Bukan JSON"
        except Exception as e:
            return False, 60, f"Error: {str(e)[:40]}"

    async def daily_tasks(self):
        """Coba ambil task rewards yang available"""
        hasil = []
        try:
            sc, text = await http_post(f"{API_BASE}/tasks/telegram/list",
                                       {"initData": self.init_data}, self.headers)
            if sc == 200:
                data = json.loads(text)
                tasks = data.get("tasks", [])
                for task in tasks:
                    tid = task.get("id")
                    title = task.get("title", "?")
                    is_done = task.get("is_done", False)
                    is_claimed = task.get("is_claimed", False)

                    if is_done and not is_claimed and tid:
                        sc2, _ = await http_post(f"{API_BASE}/tasks/telegram/claim", {
                            "initData": self.init_data,
                            "task_id": tid
                        }, self.headers)
                        if sc2 == 200:
                            hasil.append(f"Task: {title}")
        except Exception:
            pass
        return hasil

    async def cek_saldo(self):
        """Refresh saldo dari server"""
        ok, msg = await self.init_app()
        if ok:
            return self.saldo
        return self.saldo


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

    bot = FBTC0Bot(info_akun)
    key = info_akun['session_path']
    nama = info_akun['nama']

    STATUS_AKUN[key] = {'nama': nama, 'status': "AUTH...", 'saldo': 0}

    STATUS_AKUN[key]['status'] = "AUTH..."
    ok, msg = await bot.auth()
    if not ok:
        STATUS_AKUN[key]['status'] = "GAGAL AUTH"
        TOTAL_GAGAL += 1
        tambah_riwayat(nama, f"GAGAL — Auth: {msg}")
        return

    STATUS_AKUN[key]['status'] = "LOAD..."
    ok, msg = await bot.init_app()
    if not ok:
        STATUS_AKUN[key]['status'] = "GAGAL INIT"
        TOTAL_GAGAL += 1
        tambah_riwayat(nama, f"GAGAL — Init: {msg}")
        return

    STATUS_AKUN[key]['saldo'] = bot.saldo

    if bot.captcha_required:
        STATUS_AKUN[key]['status'] = "CAPTCHA..."
        if await bot.solve_captcha():
            bot.captcha_required = False

    if bot.cooldown_server > 0:
        for t in range(bot.cooldown_server, 0, -1):
            STATUS_AKUN[key]['status'] = format_waktu(t)
            await asyncio.sleep(1)

    STATUS_AKUN[key]['status'] = "SIAP"

    while True:
        try:
            STATUS_AKUN[key]['status'] = "KLAIM..."
            berhasil, cooldown, pesan = await bot.klaim()

            if berhasil:
                TOTAL_BERHASIL += 1
                STATUS_AKUN[key]['saldo'] = bot.saldo
                tambah_riwayat(nama, f"OK {pesan} | Saldo: {bot.saldo}")
            else:
                for retry in range(3):
                    STATUS_AKUN[key]['status'] = f"RETRY {retry + 1}/3"
                    await asyncio.sleep(3)

                    ok_r, _ = await bot.auth()
                    if ok_r:
                        berhasil, cooldown, pesan = await bot.klaim()
                        if berhasil:
                            break
                    else:
                        await asyncio.sleep(2)
                        berhasil, cooldown, pesan = await bot.klaim()

                if berhasil:
                    TOTAL_BERHASIL += 1
                    STATUS_AKUN[key]['saldo'] = bot.saldo
                    tambah_riwayat(nama, f"OK {pesan} | Saldo: {bot.saldo}")
                else:
                    TOTAL_GAGAL += 1
                    tambah_riwayat(nama, f"GAGAL — {pesan}")

            # Cek saldo dari server
            STATUS_AKUN[key]['status'] = "CEK..."
            await bot.cek_saldo()
            STATUS_AKUN[key]['saldo'] = bot.saldo

            # Tunggu cooldown dari server
            sisa = max(cooldown, 60)
            sisa = min(sisa, 3600)

            for t in range(sisa, 0, -1):
                STATUS_AKUN[key]['status'] = format_waktu(t)
                await asyncio.sleep(1)

            # Jeda random 10-30 detik sebelum claim berikutnya
            jeda = random.randint(10, 30)
            STATUS_AKUN[key]['status'] = f"JEDA {jeda}d"
            await asyncio.sleep(jeda)

            ok_ref, _ = await bot.auth()
            if ok_ref:
                await bot.init_app()
                if bot.captcha_required:
                    await bot.solve_captcha()
                    bot.captcha_required = False

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

            sys.stdout.write(f"{TEBAL}{HIJAU}  BTC FAUCET BOT{RESET}\n")
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


async def cek_status_akun(sessions):
    """Cek status tiap akun: auth + init, return list (akun, status_label)."""
    hasil = []
    total = len(sessions)
    print(f"\n{TEBAL}{KUNING}Mengecek status {total} akun...{RESET}")

    for i, s in enumerate(sessions, 1):
        nama = s['nama']
        sys.stdout.write(f"\r  {KUNING}[{i}/{total}] Cek {nama}...{' ' * 20}{RESET}")
        sys.stdout.flush()

        bot = FBTC0Bot(s)
        ok_auth, msg_auth = await bot.auth()
        if not ok_auth:
            hasil.append((s, f"Unknown"))
            continue

        ok_init, msg_init = await bot.init_app()
        if not ok_init:
            if "BLOKIR" in msg_init.upper():
                hasil.append((s, f"Akun di Blokir"))
            elif "401" in msg_init or "403" in msg_init:
                hasil.append((s, f"Akun di Blokir"))
            else:
                hasil.append((s, f"Unknown"))
        else:
            hasil.append((s, f"200 OK"))

    print(f"\r{' ' * 60}\r", end="")
    return hasil


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

    # Cek status semua akun
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

    # Filter hanya yang 200 OK
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
        STATUS_AKUN[key] = {'nama': acc['nama'], 'status': "MULAI", 'saldo': 0}

    print(f"{TEBAL}{HIJAU}Mulai... (Ctrl+C berhenti){RESET}\n")
    await asyncio.sleep(1)

    tugas = [asyncio.create_task(pekerja_akun(acc)) for acc in akun_aktif]
    tugas.append(asyncio.create_task(tampilan()))
    await asyncio.gather(*tugas)


if __name__ == "__main__":
    wake_locked = False
    try:
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
