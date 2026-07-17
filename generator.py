import subprocess
import re
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


import asyncio, glob, json, re, sys, time, traceback, warnings, random, os
from urllib.parse import urlparse, parse_qs, unquote
import httpx
from telethon import TelegramClient
from telethon.tl.functions.messages import RequestWebViewRequest, StartBotRequest
from rich.console import Console
from rich.prompt import Prompt
warnings.filterwarnings("ignore", message="Unverified HTTPS request")
console = Console()

import os
import sys
from rich.console import Console

console = Console()

# ============ FUNGSI SETUP CONFIG ============
def setup_config():
    """Setup API credentials and save to config.py"""
    console.clear()
    console.print("\n[bold #88C0D0]══════════════════════════════════════════════════[/bold #88C0D0]")
    console.print("[bold #88C0D0]⚙️  SETUP TELEGRAM API CONFIGURATION[/bold #88C0D0]")
    console.print("[bold #88C0D0]══════════════════════════════════════════════════[/bold #88C0D0]")
    console.print("[bold #81A1C1]\n📌 Dapatkan API dari: https://my.telegram.org/apps[/bold #81A1C1]")
    console.print("[bold #81A1C1]📌 Login ke Telegram, buat aplikasi baru[/bold #81A1C1]\n")
    
    # Input API ID
    console.print("[bold #D8DEE9]Masukkan kredensial API Telegram Anda:[/bold #D8DEE9]")
    api_id = input("  API ID: ").strip()
    
    # Input API Hash
    api_hash = input("  API Hash: ").strip()
    
    if not api_id or not api_hash:
        console.print("[bold #BF616A]❌ API ID dan API Hash tidak boleh kosong![/bold #BF616A]")
        input("\nTekan Enter untuk keluar...")
        sys.exit(1)
    
    # Validasi API ID harus angka
    try:
        int(api_id)
    except ValueError:
        console.print("[bold #BF616A]❌ API ID harus berupa angka![/bold #BF616A]")
        input("\nTekan Enter untuk keluar...")
        sys.exit(1)
    
    # ========= PERBAIKAN PENTING DI SINI =========
    # Menulis config.py dengan tanda petik ganda agar terbaca dengan benar
    config_content = f'''# Telegram API Configuration
API_ID = "{api_id}"
API_HASH = "{api_hash}"
'''
    # ==============================================
    
    # Ambil folder tempat script ini dieksekusi
    config_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), "config.py")

    try:
        with open(config_path, 'w', encoding='utf-8') as f:
            f.write(config_content)
        console.print(f"\n[bold #A3BE8C]✅ Config berhasil disimpan ke {config_path}[/bold #A3BE8C]")
        console.print(f"[bold #88C0D0]📋 API_ID = {api_id}[/bold #88C0D0]")
        console.print(f"[bold #88C0D0]📋 API_HASH = {api_hash[:10]}...[/bold #88C0D0]")
        
    except Exception as e:
        console.print(f"[bold #BF616A]❌ Gagal menyimpan config: {e}[/bold #BF616A]")
        input("\nTekan Enter untuk keluar...")
        sys.exit(1)

# ============ FUNGSI LOAD CONFIG ============
def load_config():
    """Load API credentials from config.py"""
    try:
        import config
        if hasattr(config, 'API_ID') and hasattr(config, 'API_HASH'):
            return config.API_ID, config.API_HASH
        else:
            console.print("[bold #BF616A]⚠️  config.py tidak memiliki API_ID atau API_HASH[/bold #BF616A]")
            return None, None
    except ImportError:
        return None, None

# ============ CEK & LOAD CONFIG UTAMA ============
# Ambil folder tempat script ini berada
current_dir = os.path.dirname(os.path.abspath(__file__))
config_full_path = os.path.join(current_dir, "config.py")

# Cek apakah config.py ada di folder yang sama
if not os.path.exists(config_full_path):
    console.print("[bold #D8DEE9]🔑 Config tidak ditemukan. Silakan setup terlebih dahulu.[/bold #D8DEE9]")
    setup_config()

# Load API credentials (Setelah config dipastikan ada)
API_ID, API_HASH = load_config()

# Jika gagal load (misal file corrupt), minta setup ulang 1x lagi
if API_ID is None or API_HASH is None:
    console.print(f"[bold #BF616A]❌ Gagal memuat konfigurasi API. Setup ulang...[/bold #BF616A]")
    setup_config()
    API_ID, API_HASH = load_config()

# Jika setelah setup ulang masih gagal, baru berhenti
if API_ID is None or API_HASH is None:
    console.print(f"[bold #BF616A]❌ Gagal memuat konfigurasi. Script berhenti.[/bold #BF616A]")
    sys.exit(1)

# ==========================================
# LANJUTKAN KODE GENERATOR / BOT ANDA DI SINI
# ==========================================
console.print(f"\n[bold #88C0D0]✅ API Loaded! Silakan masukkan nomor telepon.[/bold #88C0D0]")


# ... (sisa kode generator Anda yang asli di bawah ini)

# ... (sisa kode generator Anda di bawah ini)
#https://t.me/dogecoingeneratorbot?start=89856
#https://t.me/digibytegeneratorbot?start=14433
CLAIM_INTERVAL_HOURS = 0.5
BOTS = [
    {"name": "LTC", "bot": "litecoingeneratorbot", "url": "https://claimltc.net", "api": "https://claimltc.net/api", "referral": "7157"},
    {"name": "DOGE", "bot": "dogecoingeneratorbot", "url": "https://claimdoge.net", "api": "https://claimdoge.net/api", "referral": "89856"},
    {"name": "DGB", "bot": "digibytegeneratorbot", "url": "https://claimdgb.net", "api": "https://claimdgb.net/api", "referral": "14433"},
]
HEADERS = {
    "Content-Type": "application/json",
    "X-Requested-With": "TelegramWebApp",
    "User-Agent": "Mozilla/5.0 (Linux; Android 13; SM-G998B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.7827.159 Mobile Safari/537.36 Telegram-Android/12.8.3 (Samsung SM-G998B; Android 13; SDK 33; AVERAGE)",
    "Accept-Language": "id,id-ID;q=0.9,en-US;q=0.8,en;q=0.7",
}
COOKIES = {"user_lang": "en"}
C = {"ltc": "#A3BE8C", "doge": "#D08770", "dgb": "#5E81AC"}
def _rid():
    return f"{int(time.time()*1000)}-{''.join(random.choices('abcdefghijklmnopqrstuvwxyz0123456789', k=9))}"
def _att(sid=None):
    return {
        "session_id": sid or "".join(random.choices("abcdef0123456789", k=32)),
        "telegram": {"available": True, "platform": "android", "version": "9.6", "color_scheme": "dark", "user_present": True},
        "navigator": {"webdriver": False, "languages_count": 3, "max_touch_points": 5, "hardware_concurrency": 8, "device_memory": 4, "platform": "Linux aarch64", "vendor": "Google Inc.", "cookie_enabled": True},
        "screen": {"width": 400, "height": 889, "avail_width": 400, "avail_height": 889, "pixel_ratio": 2.700000047683716, "color_depth": 24},
        "user_agent_data": {"mobile": True, "platform": "Android"},
        "timezone": "Asia/Jakarta",
    }
def _pl(action, init_data, extra=None, sid=None):
    p = {"action": action, "initData": init_data, "timestamp": int(time.time()*1000), "requestId": _rid(), "client_attestation": _att(sid)}
    if extra:
        p.update(extra)
    return p
ICONS = {"ok": "✓", "err": "✗", "info": "›", "wait": "◷", "money": "💰", "bomb": "💥", "shield": "🛡", "jack": "🎉"}
COLORS = {"ok": "#A3BE8C", "err": "#BF616A", "info": "#88C0D0", "wait": "#81A1C1", "money": "#B48EAD", "bomb": "#BF616A", "shield": "#81A1C1", "jack": "#A3BE8C"}
def log(coin, action, style, detail=""):
    c = C.get(coin, "#D8DEE9")
    console.print(f"  [bold {c}]{coin.upper():<4}[/bold {c}]  [bold #81A1C1]{action:<13}[/bold #81A1C1]  [bold {COLORS[style]}]{ICONS[style]}[/bold {COLORS[style]}]  {detail}")
def banner():
    console.clear()
    art = [
        ".,-:::::/ .,:::::::::.    :::..,:::::: :::::::..    :::. ::::::::::::   ...    :::::::..   ",
        ",;;-'````'  ;;;;' ;;;;``;;;;   ;;`;;;;;;;;;;''''.;;;;;;;. ;;;;``;;;;  ",
        "[[[   [[[[[[/[[cccc   [[[[[. '[[ [[cccc   [[[,/[[['  ,[[ '[[,   [[    ,[[     \\[[,[[[,/[[['  ",
        "\"$$c.    \"$$ $$\"\"\"\"   $$$ \"Y$c$$ $$\"\"\"\"   $$$$$$c   c$$$cc$$$c  $$    $$$,     $$$$$$$$$c    ",
        " `Y8bo,,,o88o888oo,__ 888    Y88 888oo,__ 888b \"88bo,888   888  88,   \"888,_ _,88P888b \"88bo,",
        "   `\\'YMUP\"YMM\"\"\"\"YUMMMMMM     YM \"\"\"\"YUMMMMMMM   \"W\" YMM   \"\"`MMM     \"YMMMMMP\" MMMM   \"W\" ",
    ]
    for line in art:
        console.print(f"[bold #5E81AC]{line}[/bold #5E81AC]")
        time.sleep(0.03)
    console.print("\n          [bold #D8DEE9]◆[/bold #D8DEE9]  [bold #5E81AC]Generator[/bold #5E81AC]  [bold #D8DEE9]·[/bold #D8DEE9]  [bold #81A1C1]DEV: Dongo[/bold #81A1C1]  [bold #D8DEE9]·[/bold #D8DEE9]  [bold #81A1C1]TG: @PlerBerdebu[/bold #81A1C1]  [bold #D8DEE9]◆[/bold #D8DEE9]\n")
async def get_init_data(client, cfg):
    bot = await client.get_entity(cfg["bot"])
    try:
        await client(StartBotRequest(bot=bot, peer=bot, start_param=cfg["referral"]))
        await asyncio.sleep(2)
    except Exception:
        pass
    res = await client(RequestWebViewRequest(peer=bot, bot=bot, platform="android", url=cfg["url"], from_bot_menu=False))
    init_data = unquote(parse_qs(urlparse(res.url).fragment).get("tgWebAppData", [""])[0])
    if not init_data:
        raise ValueError("initData kosong")
    return init_data
async def api(session, cfg, action, init_data, extra=None, sid=None, retries=3):
    url = cfg["api"]
    hdr = {**HEADERS, "Origin": cfg["url"], "Referer": cfg["url"] + "/"}
    for attempt in range(retries):
        try:
            r = (await session.post(url, json=_pl(action, init_data, extra, sid), headers=hdr, cookies=COOKIES, timeout=httpx.Timeout(45.0))).json()
            if r.get("risk_level") == "high" or r.get("recaptcha_required"):
                return {"status": "error", "message": "reCAPTCHA blocked", "code": "recaptcha_blocked"}
            return r
        except (httpx.TimeoutException, httpx.RequestError):
            if attempt < retries - 1:
                await asyncio.sleep(5 * (attempt + 1))
    return {"status": "error", "message": "Network error"}
async def get_user_data(session, cfg, init_data):
    return await api(session, cfg, "get_user_data", init_data)
def _slide_xy(svg):
    m = re.search(r"translate\(([0-9.]+),([0-9.]+)\)", svg)
    return (float(m.group(1)), float(m.group(2))) if m else (160.0, 0.0)
def _traj(tx, max_w=280, piece_w=48):
    sx = random.randint(80, 100)
    now = int(time.time()*1000) - random.randint(2000, 3000)
    max_x = max_w - piece_w - 2
    ox = min(tx + random.uniform(2, 6), max_x)
    pts = []
    n1 = random.randint(18, 25)
    for i in range(n1):
        t = i / n1
        e = t * t * (3 - 2 * t)
        now += random.randint(35, 90)
        x = min(sx + (ox - sx) * e, max_x)
        pts.append({"x": round(x, 2), "t": now})
    n2 = random.randint(5, 9)
    for i in range(n2):
        t = (i + 1) / n2
        now += random.randint(40, 80)
        x = min(ox + (tx - ox) * t, max_x)
        pts.append({"x": round(x, 2), "t": now})
    return pts
async def solve_captcha(session, cfg, init_data, sid, context="faucet"):
    r = await api(session, cfg, "captcha_init", init_data, {"context": context}, sid)
    if r.get("status") != "success":
        return None
    sess = r["session"]
    cid, s1, s2 = sess["sessionId"], sess["step1"], sess["step2"]
    tx, _ = _slide_xy(s1["puzzleSvg"])
    await asyncio.sleep(random.uniform(3.5, 6.0))
    r2 = await api(session, cfg, "captcha_verify_slide", init_data, {"sessionId": cid, "x": round(tx + random.uniform(-1.5, 1.5), 8), "trajectory": _traj(tx)}, sid)
    if not r2.get("success"):
        return None
    ids = {i["icon"]: i["id"] for i in s2["grid"]}
    sel = [ids[t] for t in s2["targets"] if t in ids]
    await asyncio.sleep(random.uniform(2.0, 4.0))
    r3 = await api(session, cfg, "captcha_verify_pattern", init_data, {"sessionId": cid, "selectedIds": sel}, sid)
    if not r3.get("success"):
        return None
    return r3["token"]
async def get_proof(session, cfg, init_data, action, sid, cap_token=None, fields=None):
    ce = {"captcha": cap_token, "captcha_provider": "internal"} if cap_token else {}
    r = await api(session, cfg, "action_proof_init", init_data, {"targetAction": action, **(fields or {}), **ce}, sid)
    if r.get("status") != "success":
        return None
    cid, wait = r["challenge_id"], r.get("min_wait_seconds", 2)
    await asyncio.sleep(wait + 0.5)
    r2 = await api(session, cfg, "action_proof_complete", init_data, {"targetAction": action, "challengeId": cid, **(fields or {}), **ce}, sid)
    if r2.get("status") != "success":
        return None
    return r2["proof_token"]
async def _claim_with_captcha(session, cfg, init_data, action, extra):
    pf = extra
    sid = "".join(random.choices("abcdef0123456789", k=32))
    proof = await get_proof(session, cfg, init_data, action, sid, fields=pf)
    if not proof:
        await asyncio.sleep(2)
        sid = "".join(random.choices("abcdef0123456789", k=32))
        proof = await get_proof(session, cfg, init_data, action, sid, fields=pf)
        if not proof:
            return {"status": "error", "message": "proof fail", "code": "no_proof"}
    r = await api(session, cfg, action, init_data, {**extra, "action_proof": proof}, sid)
    msg = str(r.get("message", "")).lower()
    code = r.get("code", "")
    if code not in ("invalid_captcha", "captcha_required", "action_proof_invalid", "action_proof_required", "recaptcha_blocked") and "captcha" not in msg and "verification" not in msg:
        return r
    sid2 = "".join(random.choices("abcdef0123456789", k=32))
    ctx = "faucet" if "faucet" in action else "task"
    ct = await solve_captcha(session, cfg, init_data, sid2, ctx)
    if not ct:
        return {"status": "error", "message": "Captcha failed"}
    p2 = await get_proof(session, cfg, init_data, action, sid2, cap_token=ct, fields=pf)
    if not p2:
        return {"status": "error", "message": "Proof after captcha failed"}
    return await api(session, cfg, action, init_data, {**extra, "action_proof": p2, "captcha": ct, "captcha_provider": "internal"}, sid2)
async def do_claim(session, cfg, init_data):
    await simulate_ad_watch(cfg, init_data)
    return await _claim_with_captcha(session, cfg, init_data, "claim_faucet", {"doubled": True})
async def claim_daily_bonus(session, cfg, init_data):
    return await _claim_with_captcha(session, cfg, init_data, "claim_daily_bonus", {"doubled": True})
async def simulate_ad_watch(cfg, init_data):
    params = parse_qs(init_data)
    user = json.loads(unquote(params.get("user", ["{}"])[0]))
    base = {
        "publisher_id": "986733", "user_agent": HEADERS["User-Agent"],
        "language_code": user.get("language_code", "id"), "premium": user.get("is_premium", False),
        "last_name": user.get("last_name", ""), "first_name": user.get("first_name", ""),
        "telegram_id": str(user.get("id", "")), "version": "9.6", "platform": "android",
        "ip": "", "width": None, "height": None,
    }
    ah = {"User-Agent": HEADERS["User-Agent"], "Referer": cfg["url"] + "/"}
    sec = random.randint(15, 25)
    coin = cfg["name"].lower()
    log(coin, "ad_watch", "wait", f"{sec}s")
    async with httpx.AsyncClient(verify=False, timeout=8.0) as ads:
        for m in (False, False, True):
            try:
                await ads.post("https://14657.xml.4armn.com/telegram-bid", json={**base, "motivated": m, "number_of_bids": 1, "bid_floor": 0.2, "widget_id": 390232}, headers=ah)
            except Exception:
                pass
            await asyncio.sleep(random.uniform(0.5, 1.5))
        try:
            await ads.post("https://13988.xml.4armn.com/telegram-bid", json={**base, "motivated": False, "number_of_bids": 3, "bid_floor": 0.0001, "widget_id": 390230}, headers=ah)
        except Exception:
            pass
        await asyncio.sleep(random.uniform(0.5, 1.0))
        try:
            await ads.get("https://e8ys.com/401/10987172", params={"oo": "1", "tgp": "android", "var_3": str(user.get("id", ""))}, headers=ah)
        except Exception:
            pass
    await asyncio.sleep(sec)
    log(coin, "ad_watch", "ok", "done")
async def claim_rewarded_video(session, cfg, init_data):
    sid = "".join(random.choices("abcdef0123456789", k=32))
    p = await get_proof(session, cfg, init_data, "claim_rewarded_video_task", sid)
    return await api(session, cfg, "claim_rewarded_video_task", init_data, {"action_proof": p}, sid) if p else {"status": "error", "message": "No proof"}
async def claim_share_reward(session, cfg, init_data, network):
    return await _claim_with_captcha(session, cfg, init_data, "claim_share_reward", {"network": network})
async def claim_task_reward(session, cfg, init_data, task_type):
    if task_type == "double_claimer":
        return await _claim_with_captcha(session, cfg, init_data, "claim_double_reward_task", {"doubled": True})
    return await _claim_with_captcha(session, cfg, init_data, "claim_task_reward", {"task": task_type})
async def claim_mines_reward_task(session, cfg, init_data):
    sid = "".join(random.choices("abcdef0123456789", k=32))
    r = await api(session, cfg, "action_proof_init", init_data, {"targetAction": "claim_mines_reward_task", "doubled": True}, sid)
    if r.get("status") != "success":
        return r
    await asyncio.sleep(r.get("min_wait_seconds", 3) + 0.5)
    r2 = await api(session, cfg, "action_proof_complete", init_data, {"targetAction": "claim_mines_reward_task", "challengeId": r["challenge_id"], "doubled": True}, sid)
    if r2.get("status") != "success":
        return r2
    return await api(session, cfg, "claim_mines_reward_task", init_data, {"doubled": True, "action_proof": r2["proof_token"]}, sid)
async def mines_refill(session, cfg, init_data):
    sid = "".join(random.choices("abcdef0123456789", k=32))
    p = await get_proof(session, cfg, init_data, "mines_watch_ad_continues", sid)
    if not p:
        return False
    r = await api(session, cfg, "mines_watch_ad_continues", init_data, {"action_proof": p}, sid)
    if r.get("status") != "success":
        return False
    await asyncio.sleep(random.uniform(2, 4))
    u = await api(session, cfg, "mines_use_continue", init_data)
    return u.get("status") == "success"
async def play_one_game(session, cfg, init_data, retry=0):
    coin = cfg["name"].lower()
    if retry >= 2:
        log(coin, "mines", "err", "retry limit")
        return False
    await api(session, cfg, "mines_forfeit", init_data)
    await asyncio.sleep(random.uniform(5, 8))
    r = await api(session, cfg, "mines_start_game", init_data, {"difficulty": "expert"})
    msg = str(r.get("message", "")).lower()
    if r.get("status") != "success":
        log(coin, "mines", "err", f"start: {r.get('message','fail')}")
        return False
    game = r["game"]
    shields = int(game.get('continues_remaining', 0) or 0)
    log(coin, "mines", "info", f"game #{game['game_id']} bombs={game['bombs_count']} shields={shields}")
    if r.get("captcha_required") or "captcha" in msg:
        log(coin, "mines", "wait", "captcha")
        sid = "".join(random.choices("abcdef0123456789", k=32))
        ct = await solve_captcha(session, cfg, init_data, sid, "mines")
        if not ct:
            log(coin, "mines", "err", "captcha fail")
            await api(session, cfg, "mines_forfeit", init_data)
            return False
        r = await api(session, cfg, "mines_start_game", init_data, {"difficulty": "expert", "captcha": ct, "captcha_provider": "internal"})
        if r.get("status") != "success":
            log(coin, "mines", "err", f"restart: {r.get('message','fail')}")
            return False
        game = r["game"]
        shields = int(game.get('continues_remaining', 0) or 0)
    await asyncio.sleep(random.uniform(12, 18))
    tiles = list(range(25))
    random.shuffle(tiles)
    tiles_opened = 0
    can_cashout = False
    for tile in tiles:
        await asyncio.sleep(random.uniform(4, 7))
        tr = await api(session, cfg, "mines_open_tile", init_data, {"tile_index": tile})
        if tr.get("status") != "success":
            msg = str(tr.get("message", "")).lower()
            if "too fast" in msg:
                log(coin, "mines", "info", "fast")
                await api(session, cfg, "mines_forfeit", init_data)
                await asyncio.sleep(random.uniform(15, 25))
                return await play_one_game(session, cfg, init_data, retry=retry+1)
            log(coin, "mines", "err", f"tile: {tr.get('message','fail')}")
            await api(session, cfg, "mines_forfeit", init_data)
            return False
        res = tr["result"]
        rtype = res.get("result", "")
        tiles_opened = int(res.get("tiles_opened", tiles_opened) or 0)
        amt = res.get('earned_doge') or res.get('earned_usd') or res.get('amount')
        if rtype == "safe":
            can_cashout = res.get("can_cashout", False)
            earned = res.get('earned_doge', res.get('earned_usd', res.get('amount', 0)))
            log(coin, "mines", "ok", f"#{tile} +{earned}")
        elif rtype == "all_bombs_auto_cashout":
            log(coin, "mines", "jack", f"all clear +{amt or 0}")
            return True
        elif rtype == "auto_continue":
            shields = int(res.get('continues_remaining', 0) or 0)
            log(coin, "mines", "shield", f"shield #{tile} left={shields}")
        elif rtype == "bomb":
            if can_cashout and tiles_opened >= 10:
                log(coin, "mines", "money", f"cashout {tiles_opened}")
                break
            if await mines_refill(session, cfg, init_data):
                shields += 1
                log(coin, "mines", "shield", f"refill #{tile}")
                continue
            if can_cashout and tiles_opened >= 10:
                break
            log(coin, "mines", "bomb", f"#{tile} dead")
            await api(session, cfg, "mines_forfeit", init_data)
            return False
    if can_cashout and tiles_opened >= 10:
        sid = "".join(random.choices("abcdef0123456789", k=32))
        log(coin, "mines", "wait", "captcha")
        ct = await solve_captcha(session, cfg, init_data, sid, "mines")
        if ct:
            p = await get_proof(session, cfg, init_data, "mines_cashout", sid, cap_token=ct)
            if p:
                co = await api(session, cfg, "mines_cashout", init_data, {"action_proof": p, "captcha": ct, "captcha_provider": "internal"}, sid)
                if co.get("status") == "success":
                    res = co.get("result", co)
                    amt = res.get('earned_doge') or res.get('earned_usd') or res.get('amount')
                    daily = res.get('daily_mines_claims', 0)
                    log(coin, "mines", "money", f"out +{amt or 0} quest={daily}")
                    return True
                log(coin, "mines", "err", f"cashout: {co.get('message','fail')}")
    log(coin, "mines", "err", "forfeit")
    await api(session, cfg, "mines_forfeit", init_data)
    return False
async def run_mines(session, cfg, init_data, user):
    coin = cfg["name"].lower()
    today = time.strftime("%Y-%m-%d")
    quest = user.get("daily_mines_claims", 0)
    if not (user.get("last_mines_claim_activity_at") or "").startswith(today):
        quest = 0
    s = await api(session, cfg, "mines_get_stats", init_data)
    if s.get("status") != "success":
        log(coin, "mines", "err", "stats")
        return 0
    st = s["stats"]
    lives, max_lives, regen = int(st.get("game_lives", 0)), int(st.get("max_game_lives", 6)), int(st.get("life_regen_seconds", 0))
    rs = f" regen={regen//60:02d}:{regen%60:02d}" if lives < max_lives and regen else ""
    log(coin, "mines", "info", f"quest={quest} energy={lives}/{max_lives}{rs}")
    if lives <= 0:
        return 0
    new = 0
    fails = 0
    while True:
        s = await api(session, cfg, "mines_get_stats", init_data)
        if s.get("status") == "success":
            lives = int(s["stats"].get("game_lives", 0))
        if lives <= 0:
            rg = int(s["stats"].get("life_regen_seconds", 0)) if s.get("status") == "success" else 0
            rs = f" regen={rg//60:02d}:{rg%60:02d}" if rg else ""
            log(coin, "mines", "wait", f"empty{rs}")
            break
        ok = await play_one_game(session, cfg, init_data)
        if ok:
            quest += 1
            new += 1
            fails = 0
            log(coin, "mines", "ok", f"win #{quest}")
        else:
            fails += 1
            if fails >= 3:
                log(coin, "mines", "err", f"dead {fails}x")
                break
        lives -= 1
        await asyncio.sleep(random.uniform(4, 7))
    return new
async def run_one_coin(session, client, cfg):
    coin = cfg["name"].lower()
    nets = ["whatsapp", "telegram", "twitter", "facebook", "linkedin"]
    console.print(f"\n[bold #4C566A]{'─'*58}[/bold #4C566A]\n")
    console.print(f"[bold {C[coin]}]▶ {cfg['name']}[/bold {C[coin]}]  [bold #81A1C1]{cfg['url']}[/bold #81A1C1]")
    try:
        init_data = await get_init_data(client, cfg)
        user = await get_user_data(session, cfg, init_data)
        if user.get("is_banned"):
            log(coin, "auth", "err", "banned")
            return
        today = time.strftime("%Y-%m-%d")
        log(coin, "balance", "info", f"{user.get('balance') or 0}")
        if not (user.get("last_daily_bonus") or "").startswith(today):
            log(coin, "daily", "info", "claim")
            r = await claim_daily_bonus(session, cfg, init_data)
            log(coin, "daily", "ok" if r.get("status")=="success" else "err", "claimed" if r.get("status")=="success" else r.get("message","fail"))
            await asyncio.sleep(3)
        shared = []
        if (user.get("last_share_date") or "").startswith(today):
            raw = user.get("shared_platforms_today") or []
            shared = raw if isinstance(raw, list) else ([x.strip() for x in raw.split(",")] if isinstance(raw, str) and raw else [])
        for net in [n for n in nets if n not in shared]:
            log(coin, f"share_{net}", "info", "claim")
            await asyncio.sleep(random.uniform(2, 4))
            r = await claim_share_reward(session, cfg, init_data, net)
            if r.get("status") == "success" or "already" in (r.get("code","") + r.get("message","")).lower():
                shared.append(net)
                amt = r.get("claimed_amount") or r.get("amount") or r.get("reward")
                log(coin, f"share_{net}", "ok", f"+{amt or 0}")
            else:
                log(coin, f"share_{net}", "err", r.get("message","fail"))
            await asyncio.sleep(random.uniform(3, 5))
        for i in range(user.get("daily_rewarded_video_claims", 0), 7):
            log(coin, f"vid_{i+1}/7", "info", "claim")
            r = await claim_rewarded_video(session, cfg, init_data)
            if r.get("status") != "success":
                log(coin, f"vid_{i+1}/7", "err", r.get("message","fail"))
                break
            log(coin, f"vid_{i+1}/7", "ok", f"+{r.get('claimed_amount') or 0}")
            await asyncio.sleep(random.uniform(3, 6))
        log(coin, "faucet", "info", "claim")
        r = await do_claim(session, cfg, init_data)
        if r.get("status") == "success":
            log(coin, "faucet", "money", f"+{r.get('claimed_amount')} bal={r.get('new_balance')}")
        elif r.get("code") == "please_wait_seconds":
            m = re.search(r"(\d+)", r.get("message", "0"))
            wait = int(m.group(1)) + 5 if m else 60
            log(coin, "faucet", "wait", f"wait {wait}s")
            await asyncio.sleep(wait)
            r = await do_claim(session, cfg, init_data)
            log(coin, "faucet", "money" if r.get("status")=="success" else "err", f"+{r.get('claimed_amount')} bal={r.get('new_balance')}" if r.get("status")=="success" else f"fail: {r}")
        else:
            log(coin, "faucet", "err", f"fail: {r}")
        u2 = await get_user_data(session, cfg, init_data)
        if u2.get("daily_double_claims", 0) >= 10 and not (u2.get("last_double_task_claimed_at") or "").startswith(today):
            log(coin, "double", "info", "claim")
            r = await claim_task_reward(session, cfg, init_data, "double_claimer")
            log(coin, "double", "ok" if r.get("status")=="success" else "err", "claimed" if r.get("status")=="success" else r.get("message","fail"))
        await run_mines(session, cfg, init_data, u2)
        u3 = await get_user_data(session, cfg, init_data)
        mt = u3.get("daily_mines_claims", 0)
        if not (u3.get("last_mines_claim_activity_at") or "").startswith(today):
            mt = 0
        if mt >= 10 and not (u3.get("last_mines_task_claimed_at") or "").startswith(today):
            log(coin, "mines_task", "info", f"claim {mt}")
            r = await claim_mines_reward_task(session, cfg, init_data)
            log(coin, "mines_task", "ok" if r.get("status")=="success" else "err", "claimed" if r.get("status")=="success" else r.get("message","fail"))
    except Exception as e:
        log(coin, "error", "err", f"{e}")
        traceback.print_exc()
async def run_account(session_file):
    name = session_file.replace(".session", "")
    client = TelegramClient(name, API_ID, API_HASH)
    await client.start()
    console.print(f"\n[bold #D8DEE9]  account {name}[/bold #D8DEE9]\n")
    try:
        async with httpx.AsyncClient(verify=False) as session:
            while True:
                for cfg in BOTS:
                    await run_one_coin(session, client, cfg)
                    await asyncio.sleep(random.uniform(3, 6))
                wait = CLAIM_INTERVAL_HOURS * 3600
                log("sys", "sleep", "wait", f"{int(wait//60)}m")
                await asyncio.sleep(wait)
    except KeyboardInterrupt:
        console.print(f"\n[bold #D8DEE9]  stopped[/bold #D8DEE9]\n")
        await client.disconnect()
        sys.exit(0)
    finally:
        await client.disconnect()
async def add_account():
    console.print()
    phone = Prompt.ask("  [bold #88C0D0]phone[/bold #88C0D0]", default="", show_default=False).strip()
    if not phone:
        log("sys", "auth", "err", "empty")
        return
    if not phone.startswith("+"):
        phone = "+" + phone
    name = phone.replace("+", "")
    log("sys", "auth", "info", f"login {phone}...")
    client = TelegramClient(name, API_ID, API_HASH)
    try:
        await client.start(phone=phone)
        log("sys", "auth", "ok", f"saved {name}.session")
    except Exception as e:
        log("sys", "auth", "err", f"{e}")
    finally:
        await client.disconnect()
async def main():
    banner()
    sessions = sorted(glob.glob("*.session"))
    if not sessions:
        await add_account()
        sessions = sorted(glob.glob("*.session"))
        if not sessions:
            log("sys", "init", "err", "no account")
            return
    sf = sessions[0]
    log("sys", "init", "info", sf.replace('.session',''))
    await run_account(sf)
if __name__ == "__main__":
    try:
        asyncio.run(main())
    except KeyboardInterrupt:
        console.print(f"\n[bold #D8DEE9]  bye[/bold #D8DEE9]\n")
    except Exception as e:
        log("sys", "fatal", "err", f"{e}")