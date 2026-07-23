import requests
import time
import random
import sys
import os
from datetime import datetime, timezone
from colorama import Fore, Style, init

init(autoreset=True)

# ==========================================
# ⚙️ CONFIGURATION - ALIXE8 EDITION
# ==========================================

# SHORT_LINK = "https://shrinkme.click/8Wn3"

# PASSWORD_POOL = [
    # "MySuperSecretPass2026",
    # "RainStar@Alpha#8847",
    # "CryptoMiner_X7_Pro",
    # "AdWatch#2026_Secure",
    # "DailyBonus_Rain$99"
# ]

BASE_DATE = datetime(2026, 1, 1, tzinfo=timezone.utc)

# def get_todays_password():
    # today = datetime.now(timezone.utc)
    # day_diff = (today - BASE_DATE).days
    # index = day_diff % len(PASSWORD_POOL)
    # return PASSWORD_POOL[index]

URL = "https://rainstar.online/api/user/ad-watch"

def show_banner():
    # Bersihkan layar
    os.system('cls' if os.name == 'nt' else 'clear')

    # Ambil tanggal & waktu saat ini (format: Thu, 23-07-2026, 20:38)
    now = datetime.now()
    tanggal = now.strftime("%a, %d-%m-%Y, %H:%M")

    # Kode ANSI untuk warna (tanpa library colorama agar lebih ringan)
    YELLOW = '\033[93m'
    GREEN = '\033[92m'
    RED_BG = '\033[41m'
    WHITE = '\033[97m'
    RESET = '\033[0m'

    # Buat banner
    banner = f"""
{YELLOW}--------------------------------------------------
Tanggal : {tanggal}
{YELLOW}--------------------------------------------------
{GREEN}Script   : Rainstar
Creator  : Mode Gratis - Bot
{RED_BG}{WHITE}Script Gratis{RESET}
{YELLOW}--------------------------------------------------{RESET}
"""
    print(banner)

# Panggil fungsi
show_banner()

def watch_ad(cycle, init_data):
    headers = {
        "Host": "rainstar.online",
        "accept": "*/*",
        "content-type": "application/json",
        "x-telegram-init-data": init_data,
        "user-agent": "Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Mobile Safari/537.36",
        "origin": "https://rainstar.online",
        "referer": "https://rainstar.online/",
        "sec-ch-ua-mobile": "?1",
        "sec-ch-ua-platform": '"Android"'
    }

    print(f"\n{Fore.CYAN}--- [ ADVERTISING CYCLE: {cycle} ] ---{Style.RESET_ALL}")
    
    wait_time = random.randint(15, 25)
    for i in range(wait_time, 0, -1):
        sys.stdout.write(f"\r{Fore.YELLOW}⏳ Processing Ad: {i}s remaining...{Style.RESET_ALL}")
        sys.stdout.flush()
        time.sleep(1)
    print("\r" + " " * 45 + "\r", end="")

    print(f"{Fore.BLUE}[ℹ] Submitting watch confirmation...{Style.RESET_ALL}")
    
    try:
        res = requests.post(URL, headers=headers, json={}, timeout=10)
        
        if res.status_code == 200:
            data = res.json()
            if data.get("success"):
                reward = data.get("reward", 0)
                balance = data.get("balance", 0)
                ads_today = data.get("adsToday", 0)
                max_ads = data.get("maxAds", 60)
                
                print(f"{Fore.GREEN}[SUCCESS] +{reward} Points added! 💰{Style.RESET_ALL}")
                print(f"{Fore.WHITE}    Current Balance: {balance}{Style.RESET_ALL}")
                print(f"{Fore.YELLOW}    Progress Today: {ads_today} / {max_ads}{Style.RESET_ALL}")
                
                if ads_today >= max_ads:
                    return "DONE"
                return True
            else:
                msg = data.get("message", "Error")
                print(f"{Fore.RED}[FAILED] {msg}{Style.RESET_ALL}")
                if "limit" in msg.lower() or "cooldown" in msg.lower():
                    return "WAIT"
                
        elif res.status_code == 401 or res.status_code == 403:
            print(f"{Fore.RED}[CRITICAL] Unauthorized Access! Your Query (initData) might be expired.{Style.RESET_ALL}")
            return "STOP"
        else:
            print(f"{Fore.RED}[ERROR] HTTP Status: {res.status_code}{Style.RESET_ALL}")
            
    except Exception as e:
        print(f"{Fore.RED}[CONNECTION] Error: {e}{Style.RESET_ALL}")
        
    return False

if __name__ == "__main__":
    show_banner()
    
    # Step 1: Password FIRST
    # CORRECT_PASSWORD = get_todays_password()
    
    # print(f"{Fore.WHITE}Step 1: Password Verification{Style.RESET_ALL}")
    # print(f"{Fore.YELLOW}⚠ Password changes every 24 hours!{Style.RESET_ALL}")
    # print(f"{Fore.BLUE}Get today's password from Pastebin:{Style.RESET_ALL}")
    # print(f"{Fore.GREEN}👉 {SHORT_LINK} 👈{Style.RESET_ALL}\n")
    
    # attempts = 0
    # while True:
        # user_password = input(f"{Fore.CYAN}Enter today's Password: {Style.RESET_ALL}").strip()
        
        # if user_password == CORRECT_PASSWORD:
            # print(f"\n{Fore.GREEN}[✓] Access Granted!{Style.RESET_ALL}")
            # time.sleep(1)
            # break
        # else:
            # attempts += 1
            # print(f"{Fore.RED}[X] Invalid Password! Attempt #{attempts}{Style.RESET_ALL}")
            # if attempts >= 3:
                # print(f"{Fore.YELLOW}Tip: Visit {SHORT_LINK} to get today's password from Pastebin.{Style.RESET_ALL}")

    # # Step 2: Init Data
    # print(f"\n{Fore.WHITE}Step 2: Authorization{Style.RESET_ALL}")
    init_data = input(f"{Fore.CYAN}Enter your Query (initData): {Style.RESET_ALL}").strip()
    if not init_data:
        print(f"{Fore.RED}Error: Query cannot be empty!{Style.RESET_ALL}")
        sys.exit()

    print(f"\n{Fore.WHITE}Starting automated task...{Style.RESET_ALL}\n")
    
    cycle = 1
    while True:
        status = watch_ad(cycle, init_data)
        
        if status == "DONE":
            print(f"\n{Fore.GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━")
            print(f"{Fore.MAGENTA}🎉 Daily limit reached! Script stopping automatically.{Style.RESET_ALL}")
            print(f"{Fore.GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━{Style.RESET_ALL}")
            break
        elif status == "STOP":
            print(f"\n{Fore.RED}🛑 Execution halted. Check your Query or Token.{Style.RESET_ALL}")
            break
        elif status == "WAIT":
            print(f"{Fore.YELLOW}💤 Cooldown detected. Waiting 5 minutes...{Style.RESET_ALL}")
            time.sleep(300)
        else:
            delay = random.randint(5, 10)
            time.sleep(delay)
            
        cycle += 1

    print(f"\n{Fore.CYAN}Thank you for using @Alixe8 tools!{Style.RESET_ALL}")
