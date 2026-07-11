#!/usr/bin/env python3
"""
╔══════════════════════════════════════════════════════════╗
║  🎮 GAMERLEE AUTO CLAIM — MULTI COIN           ║
║  🔐 Login via Telegram Mini App                         ║
║  💰 Auto Claim Pilihan Koin • Timer 17 Detik           ║
║  👑 Owner: @MoneyMaker_w                               ║
╚══════════════════════════════════════════════════════════╝
"""

import asyncio
import requests
import json
import os
import sys
import re
import hashlib
import time
from urllib.parse import urlparse, parse_qs, unquote
from bs4 import BeautifulSoup
from telethon import TelegramClient, functions, types

# ==================== WARNA ====================
GREEN = "\033[1;32m"
YELLOW = "\033[1;33m"
RED = "\033[1;31m"
CYAN = "\033[1;36m"
BLUE = "\033[1;34m"
PURPLE = "\033[1;35m"
RESET = "\033[0m"

# ==================== DAFTAR KOIN ====================
COINS = [
    "BTC", "ETH", "DOGE", "LTC", "BCH", "DASH", "DGB",
    "TRX", "USDT", "FEY", "ZEC", "TRUMP", "BNB", "SOL", "TON"
]

# ==================== BANNER ====================
def show_banner():
    banner = f"""
{CYAN}╔══════════════════════════════════════════════════════════╗
║                                                          ║
║   {YELLOW}██████╗  █████╗ ███╗   ███╗███████╗██████╗ {CYAN}   ║
║   {YELLOW}██╔════╝ ██╔══██╗████╗ ████║██╔════╝██╔══██╗{CYAN}   ║
║   {YELLOW}██║  ███╗███████║██╔████╔██║█████╗  ██████╔╝{CYAN}   ║
║   {YELLOW}██║   ██║██╔══██║██║╚██╔╝██║██╔══╝  ██╔══██╗{CYAN}   ║
║   {YELLOW}╚██████╔╝██║  ██║██║ ╚═╝ ██║███████╗██║  ██║{CYAN}   ║
║    {YELLOW}╚═════╝ ╚═╝  ╚═╝╚═╝     ╚═╝╚══════╝╚═╝  ╚═╝{CYAN}   ║
║                                                          ║
║   {GREEN}⚡ AUTO CLAIM FAUCET — GAMERLEE.COM ⚡{CYAN}        ║
║   {YELLOW}💰 Multi Coin • Timer 17 Detik               {CYAN}        ║
║                                                          ║
║   {CYAN}👑 Owner : @MoneyMaker_w                          ║
║   {CYAN}📦 Version : 1.0                 ║
║                                                          ║
╚══════════════════════════════════════════════════════════╝{RESET}
    """
    print(banner)

# ==================== KONFIGURASI ====================
CONFIG_FILE = "gamerlee_config.json"
SESSION_DIR = "sessions"
BOT_USERNAME = "gamerleebot"
SELECTED_COIN_FILE = "gamerlee_coin.txt"

class Config:
    def __init__(self):
        self.api_id = None
        self.api_hash = None
        self.phone = None

    def load(self):
        if os.path.exists(CONFIG_FILE):
            with open(CONFIG_FILE, 'r') as f:
                data = json.load(f)
                self.api_id = data.get('api_id')
                self.api_hash = data.get('api_hash')
                self.phone = data.get('phone')
                return True
        return False

    def save(self):
        os.makedirs(SESSION_DIR, exist_ok=True)
        with open(CONFIG_FILE, 'w') as f:
            json.dump({
                'api_id': self.api_id,
                'api_hash': self.api_hash,
                'phone': self.phone
            }, f, indent=2)

    def clear(self):
        if os.path.exists(CONFIG_FILE):
            os.remove(CONFIG_FILE)
        if os.path.exists("gamerlee_init.txt"):
            os.remove("gamerlee_init.txt")
        if os.path.exists(SELECTED_COIN_FILE):
            os.remove(SELECTED_COIN_FILE)

def get_selected_coin():
    if os.path.exists(SELECTED_COIN_FILE):
        with open(SELECTED_COIN_FILE, 'r') as f:
            return f.read().strip()
    return "LTC"

def save_selected_coin(coin):
    with open(SELECTED_COIN_FILE, 'w') as f:
        f.write(coin)

# ==================== AMBIL INITDATA ====================
async def get_init_data(config):
    session_file = os.path.join(SESSION_DIR, f"gamerlee_{config.phone.replace('+', '')}")
    client = TelegramClient(session_file, config.api_id, config.api_hash)
    
    await client.start(phone=config.phone)
    print(f"{GREEN}✅ Telegram connected!{RESET}")

    try:
        bot = await client.get_input_entity(BOT_USERNAME)
    except:
        print(f"{RED}❌ Bot @{BOT_USERNAME} tidak ditemukan.{RESET}")
        sys.exit(1)

    result = await client(functions.messages.RequestWebViewRequest(
        peer=bot,
        bot=bot,
        platform='android',
        from_bot_menu=True,
        url='https://gamerlee.com'
    ))

    parsed = urlparse(result.url)
    init_data = None
    if parsed.fragment:
        init_data = parse_qs(parsed.fragment).get('tgWebAppData', [None])[0]
    if not init_data and parsed.query:
        init_data = parse_qs(parsed.query).get('tgWebAppData', [None])[0]

    if init_data:
        init_data = unquote(init_data)
        with open("gamerlee_init.txt", "w") as f:
            f.write(init_data)
        print(f"{GREEN}✅ initData saved!{RESET}")
    else:
        print(f"{RED}❌ Gagal mendapatkan initData{RESET}")

    await client.disconnect()
    return init_data

# ==================== UTILITY ====================
def get_hidden_inputs(html):
    soup = BeautifulSoup(html, 'html.parser')
    hidden = {}
    for inp in soup.find_all('input', type='hidden'):
        name = inp.get('name')
        value = inp.get('value', '')
        if name:
            hidden[name] = value
    return hidden

def get_uid_from_initdata(init_data):
    parsed = parse_qs(init_data)
    user_str = parsed.get('user', [None])[0]
    if user_str:
        try:
            user_json = json.loads(unquote(user_str))
            user_id = user_json.get('id')
            if user_id:
                return hashlib.md5(str(user_id).encode()).hexdigest()
        except:
            pass
    return None

# ==================== BOT ====================
class GamerLeeBot:
    def __init__(self, init_data):
        self.init_data = init_data
        self.session = requests.Session()
        self.base_url = "https://gamerlee.com"
        self.headers = {
            "User-Agent": "Mozilla/5.0 (Linux; Android 16; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.7827.164 Mobile Safari/537.36 Telegram-Android/12.6.4",
            "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
            "Accept-Language": "id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
            "X-Requested-With": "org.telegram.messenger.web",
            "Origin": "https://gamerlee.com",
            "Sec-Ch-Ua": '"Android WebView";v="149", "Chromium";v="149", "Not)A;Brand";v="24"',
            "Sec-Ch-Ua-Mobile": "?1",
            "Sec-Ch-Ua-Platform": '"Android"',
            "Upgrade-Insecure-Requests": "1",
            "Sec-Fetch-Site": "same-origin",
            "Sec-Fetch-Mode": "navigate",
            "Sec-Fetch-Dest": "document",
            "Cache-Control": "max-age=0",
        }

    def login(self):
        print(f"{YELLOW}🔍 Mengambil halaman utama...{RESET}")
        resp = self.session.get(self.base_url + "/", headers=self.headers)
        if resp.status_code != 200:
            print(f"{RED}❌ Gagal akses halaman utama: {resp.status_code}{RESET}")
            return False

        hidden = get_hidden_inputs(resp.text)
        csrf = self.session.cookies.get('csrf_cookie_name') or hidden.get('csrf_test_name')
        reg_nonce = hidden.get('reg_nonce')
        uid = hidden.get('uid')

        if not uid:
            uid = get_uid_from_initdata(self.init_data)

        if not csrf or not reg_nonce or not uid:
            print(f"{RED}❌ Gagal mendapatkan parameter login{RESET}")
            return False

        print(f"{YELLOW}🔐 Login...{RESET}")
        login_data = {
            'csrf_test_name': csrf,
            'tg_init_data': self.init_data,
            'reg_nonce': reg_nonce,
            'uid': uid,
            'website_url': ''
        }

        login_resp = self.session.post(
            self.base_url + "/app/auth/telegram_login",
            data=login_data,
            headers=self.headers
        )

        if login_resp.status_code != 200:
            print(f"{RED}❌ Login gagal (HTTP {login_resp.status_code}){RESET}")
            return False

        if "dashboard" in login_resp.url or "Dashboard" in login_resp.text:
            print(f"{GREEN}✅ Login berhasil!{RESET}")
            return True
        else:
            print(f"{RED}❌ Login tidak berhasil.{RESET}")
            return False

    def claim_coin(self, currency):
        print(f"{YELLOW}🔄 Claiming {currency} faucet...{RESET}")
        faucet_url = f"{self.base_url}/app/faucet?currency={currency}"
        resp = self.session.get(faucet_url, headers=self.headers)
        if resp.status_code != 200:
            print(f"{RED}❌ Gagal akses halaman faucet: {resp.status_code}{RESET}")
            return False

        hidden = get_hidden_inputs(resp.text)
        claim_token = hidden.get('claim_token')
        if not claim_token:
            match = re.search(r'name=["\']claim_token["\']\s+value=["\']([^"\']+)["\']', resp.text)
            if match:
                claim_token = match.group(1)
        if not claim_token:
            print(f"{RED}❌ Tidak dapat claim_token{RESET}")
            return False

        csrf = self.session.cookies.get('csrf_cookie_name') or hidden.get('csrf_test_name')
        if not csrf:
            print(f"{RED}❌ Tidak dapat csrf_test_name{RESET}")
            return False

        verify_data = {
            'csrf_test_name': csrf,
            'claim_token': claim_token,
            'tg_init_data': self.init_data
        }
        verify_url = f"{self.base_url}/faucet/currency/{currency.lower()}/verify"
        verify_resp = self.session.post(verify_url, data=verify_data, headers=self.headers)

        if verify_resp.status_code == 200:
            print(f"{GREEN}✅ Claim {currency} berhasil!{RESET}")
            return True
        else:
            print(f"{RED}❌ Claim {currency} gagal: {verify_resp.status_code}{RESET}")
            return False

# ==================== MENU ====================
def show_menu():
    print(f"\n{CYAN}╔════════════════════════════════════════════════════╗")
    print(f"║                    MAIN MENU                         ║")
    print(f"╠════════════════════════════════════════════════════╣")
    print(f"║  {GREEN}[1]{RESET} 🪙 Pilih Koin                              ║")
    print(f"║  {YELLOW}[2]{RESET} ⚙️  Set Data (Reset Config)                ║")
    print(f"║  {BLUE}[3]{RESET} 🚀 Start Farming (Timer 17 detik)           ║")
    print(f"║  {RED}[0]{RESET} ❌ Exit                                  ║")
    print(f"╚════════════════════════════════════════════════════╝{RESET}")

def show_coin_list():
    print(f"\n{CYAN}📋 Daftar Koin:{RESET}")
    for i, coin in enumerate(COINS, 1):
        print(f"  {GREEN}{i:2}. {coin}{RESET}")
    print(f"  {RED}0. Kembali{RESET}")

def select_coin():
    current = get_selected_coin()
    print(f"\n{YELLOW}Koin saat ini: {GREEN}{current}{RESET}")
    while True:
        show_coin_list()
        try:
            choice = input(f"\n{PURPLE}❯ Pilih nomor koin: {RESET}").strip()
            if choice == '0':
                return
            idx = int(choice) - 1
            if 0 <= idx < len(COINS):
                selected = COINS[idx]
                save_selected_coin(selected)
                print(f"{GREEN}✅ Koin diubah ke: {selected}{RESET}")
                input("Tekan Enter untuk kembali...")
                return
            else:
                print(f"{RED}❌ Pilihan tidak valid!{RESET}")
        except ValueError:
            print(f"{RED}❌ Masukkan angka!{RESET}")

def set_data():
    print(f"{YELLOW}⚠️ Reset Config akan menghapus semua data login & initData.{RESET}")
    confirm = input("Yakin? (y/n): ").strip().lower()
    if confirm == 'y':
        config = Config()
        config.clear()
        print(f"{GREEN}✅ Config & initData direset!{RESET}")
    else:
        print(f"{YELLOW}⏹️ Dibatalkan.{RESET}")
    input("Tekan Enter untuk kembali...")

# ==================== FARMING ====================
def start_farming():
    config = Config()
    if not config.load():
        print(f"{RED}❌ Data Telegram belum diset! Lakukan setup otomatis.{RESET}")
        print(f"{YELLOW}📋 FIRST TIME SETUP{RESET}")
        print("Get API from: https://my.telegram.org/apps")
        config.api_id = int(input("API ID: "))
        config.api_hash = input("API Hash: ")
        config.phone = input("Phone (with +): ")
        config.save()

    init_data = None
    if os.path.exists("gamerlee_init.txt"):
        with open("gamerlee_init.txt", "r") as f:
            init_data = f.read().strip()
        print(f"{GREEN}✅ Menggunakan initData yang tersimpan{RESET}")
    else:
        print(f"{YELLOW}⏳ Mendapatkan initData dari Telegram...{RESET}")
        init_data = asyncio.run(get_init_data(config))

    if not init_data:
        print(f"{RED}❌ Gagal mendapatkan initData{RESET}")
        input("Tekan Enter untuk kembali...")
        return

    bot = GamerLeeBot(init_data)
    if not bot.login():
        print(f"{RED}❌ Login gagal. Coba hapus gamerlee_init.txt lalu jalankan ulang.{RESET}")
        input("Tekan Enter untuk kembali...")
        return

    coin = get_selected_coin()
    print(f"{CYAN}🚀 Starting farming for {coin}...{RESET}")
    print(f"{YELLOW}⏱️ Timer: 17 detik antar claim{RESET}")
    print(f"{YELLOW}Press Ctrl+C to stop{RESET}\n")

    cycle = 0
    try:
        while True:
            cycle += 1
            print(f"\n{CYAN}🔄 Cycle #{cycle} — {coin}{RESET}")
            bot.claim_coin(coin)
            print(f"{YELLOW}⏳ Menunggu 17 detik sebelum claim berikutnya...{RESET}")
            # Timer 17 detik dengan countdown
            for i in range(17, 0, -1):
                sys.stdout.write(f"\r{YELLOW}⏳ Next claim in {i} detik{RESET}")
                sys.stdout.flush()
                time.sleep(1)
            print()
    except KeyboardInterrupt:
        print(f"\n{YELLOW}⏹️ Farming stopped.{RESET}")

# ==================== MAIN ====================
def main():
    while True:
        show_banner()
        show_menu()
        current_coin = get_selected_coin()
        print(f"{CYAN}🪙 Koin aktif : {GREEN}{current_coin}{RESET}")
        choice = input(f"\n{PURPLE}❯ Pilih menu: {RESET}").strip()

        if choice == '0':
            print(f"{YELLOW}👋 Bye!{RESET}")
            sys.exit(0)
        elif choice == '1':
            select_coin()
        elif choice == '2':
            set_data()
        elif choice == '3':
            start_farming()
        else:
            print(f"{RED}❌ Pilihan tidak valid!{RESET}")
            time.sleep(1)

if __name__ == "__main__":
    main()