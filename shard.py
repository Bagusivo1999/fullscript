
"""
╔══════════════════════════════════════════════════════════╗
║  💎 SHARDSEARN — AUTO WATCH ADS (FIX LABEL)            ║
║  🔐 Login via Manual Query_ID                          ║
║  📺 Auto detect & claim all ad tasks                  ║
║  ⏱️ Iklan 30 detik • Timer cycle 10s                 ║
║  👑 Owner: @MoneyMaker_w                              ║
╚══════════════════════════════════════════════════════════╝
"""

import requests
import json
import os
import sys
import time
from urllib.parse import parse_qs, unquote

# ==================== WARNA ====================
GREEN = "\033[1;32m"
YELLOW = "\033[1;33m"
RED = "\033[1;31m"
CYAN = "\033[1;36m"
BLUE = "\033[1;34m"
PURPLE = "\033[38;5;141m"
PINK = "\033[38;5;206m"
LIME = "\033[38;5;154m"
DIM = "\033[2;37m"
GOLD = "\033[38;5;220m"
RESET = "\033[0m"

# ==================== KONFIGURASI ====================
CONFIG_FILE = "shards_config.json"
BASE_URL = "https://shardsearn.site"
TIMER_ADS = 30           # Durasi nonton iklan 30 detik
TIMER_CYCLE = 10
MAX_RETRY = 2
RETRY_DELAY = 5

class Config:
    def __init__(self):
        self.init_data = None
        self.auth_token = None

    def load(self):
        if os.path.exists(CONFIG_FILE):
            with open(CONFIG_FILE, 'r') as f:
                data = json.load(f)
                self.init_data = data.get('init_data')
                self.auth_token = data.get('auth_token')
                return True
        return False

    def save(self):
        with open(CONFIG_FILE, 'w') as f:
            json.dump({
                'init_data': self.init_data,
                'auth_token': self.auth_token
            }, f, indent=2)

    def clear(self):
        if os.path.exists(CONFIG_FILE):
            os.remove(CONFIG_FILE)

def extract_user_id(init_data):
    parsed = parse_qs(init_data)
    user_str = parsed.get('user', [None])[0]
    if user_str:
        try:
            user_json = json.loads(unquote(user_str))
            return str(user_json.get('id'))
        except:
            pass
    return None

# ==================== BANNER ====================
def show_banner():
    print(f"""
{PURPLE}╔══════════════════════════════════════════════════════════╗
║                                                          ║
║   {GOLD}███████╗██╗  ██╗ █████╗ ██████╗ ██████╗ ███████╗{PURPLE}║
║   {GOLD}██╔════╝██║  ██║██╔══██╗██╔══██╗██╔══██╗██╔════╝{PURPLE}║
║   {GOLD}███████╗███████║███████║██████╔╝██║  ██║███████╗{PURPLE}║
║   {GOLD}╚════██║██╔══██║██╔══██║██╔══██╗██║  ██║╚════██║{PURPLE}║
║   {GOLD}███████║██║  ██║██║  ██║██║  ██║██████╔╝███████║{PURPLE}║
║   {GOLD}╚══════╝╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝╚═════╝ ╚══════╝{PURPLE}║
║                                                          ║
║   {CYAN}💎 SHARDSEARN — AUTO WATCH ADS 💎{PURPLE}            ║
║   {LIME}📺 Auto detect        {PURPLE}║
║                                                          ║
║   {PINK}👑 Owner : @MoneyMaker_w                          {PURPLE}║
║   {DIM}📦 Version : 1.2                     {PURPLE}║
║                                                          ║
╚══════════════════════════════════════════════════════════╝{RESET}
""")

# ==================== BOT ====================
class ShardsBot:
    def __init__(self, init_data, auth_token=None):
        self.init_data = init_data
        self.auth_token = auth_token
        self.session = requests.Session()
        self.base_url = BASE_URL
        self.headers = {
            "User-Agent": "Mozilla/5.0 (Linux; Android 16; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.7827.164 Mobile Safari/537.36 Telegram-Android/12.6.4",
            "Accept": "*/*",
            "Accept-Language": "id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
            "Content-Type": "application/json",
            "Origin": "https://shardsearn.site",
            "X-Requested-With": "org.telegram.messenger.web",
            "Sec-Fetch-Site": "same-origin",
            "Sec-Fetch-Mode": "cors",
            "Sec-Fetch-Dest": "empty",
            "Connection": "keep-alive",
        }
        if auth_token:
            self.headers["Cookie"] = f"auth_token={auth_token}"
        self.tasks = []
        self.total_reward = 0
        self.balance = 0

    def login(self):
        print(f"{BLUE}┌─ 🔐 Login...{RESET}")
        payload = {"initData": self.init_data}
        resp = self.session.post(f"{self.base_url}/api/auth/telegram/initdata", json=payload, headers=self.headers)
        if resp.status_code == 200:
            for cookie in self.session.cookies:
                if cookie.name == "auth_token":
                    self.auth_token = cookie.value
                    self.headers["Cookie"] = f"auth_token={self.auth_token}"
                    break
            if not self.auth_token:
                try:
                    data = resp.json()
                    self.auth_token = data.get('token') or data.get('auth_token')
                    if self.auth_token:
                        self.headers["Cookie"] = f"auth_token={self.auth_token}"
                except:
                    pass
            print(f"{GREEN}└─ ✅ Login berhasil!{RESET}")
            return True
        else:
            print(f"{RED}└─ ❌ Login gagal: {resp.status_code}{RESET}")
            return False

    def get_dashboard(self):
        print(f"{BLUE}┌─ 📊 Fetching dashboard...{RESET}")
        resp = self.session.get(f"{self.base_url}/api/pages/dashboard", headers=self.headers)
        if resp.status_code == 200:
            try:
                data = resp.json()
                if data.get('ok'):
                    self.balance = data.get('user', {}).get('points', 0)
                    tasks = data.get('featuredTasks', [])
                    ad_tasks = []
                    for task in tasks:
                        if task.get('type') in ['adsgram', 'adsgram_special']:
                            vp = task.get('viewProgress', {})
                            views_rem = vp.get('viewsRemaining', 0)
                            if views_rem > 0:
                                ad_tasks.append({
                                    'id': task.get('id'),
                                    'title': task.get('title'),
                                    'type': task.get('type'),
                                    'views_remaining': views_rem,
                                    'max_views': vp.get('maxViews', 10),
                                    'next_reward': vp.get('nextReward', 0),
                                    'view_rewards': task.get('viewRewards', []),
                                    'views_used': vp.get('viewsUsed', 0)
                                })
                    self.tasks = ad_tasks
                    print(f"{GREEN}└─ ✅ Found {len(ad_tasks)} active ad tasks | Balance: {self.balance} SHARDS{RESET}")
                    return data
            except Exception as e:
                print(f"{RED}└─ ❌ Parse error: {e}{RESET}")
                return {}
        else:
            print(f"{RED}└─ ❌ Gagal: {resp.status_code}{RESET}")
            return {}

    def get_user_id(self):
        print(f"{BLUE}┌─ 🆔 Get user ID...{RESET}")
        resp = self.session.get(f"{self.base_url}/api/ads/user-id", headers=self.headers)
        if resp.status_code == 200:
            try:
                data = resp.json()
                uid = data.get('userId')
                print(f"{GREEN}└─ ✅ User ID: {uid}{RESET}")
                return uid
            except:
                print(f"{GREEN}└─ ✅ User ID loaded{RESET}")
                return None
        else:
            print(f"{RED}└─ ❌ Gagal: {resp.status_code}{RESET}")
            return None

    def generate_token(self, task_id):
        print(f"{BLUE}┌─ 🎫 Generate token for task {task_id}...{RESET}")
        payload = {"provider": "adsgram", "taskId": task_id}
        resp = self.session.post(f"{self.base_url}/api/ads/generate-token", json=payload, headers=self.headers)
        if resp.status_code == 200:
            try:
                data = resp.json()
                token = data.get('token')
                print(f"{GREEN}└─ ✅ Token generated!{RESET}")
                return token
            except:
                print(f"{GREEN}└─ ✅ Token generated!{RESET}")
                return None
        else:
            print(f"{RED}└─ ❌ Gagal: {resp.status_code}{RESET}")
            return None

    def mark_clicked(self, token, task_id):
        print(f"{BLUE}┌─ 📺 Watching ad...{RESET}")
        payload = {
            "token": token,
            "clickData": {
                "requests": 3,
                "timestamp": int(time.time() * 1000)
            }
        }
        resp = self.session.post(f"{self.base_url}/api/ads/mark-clicked", json=payload, headers=self.headers)
        if resp.status_code == 200:
            try:
                data = resp.json()
                if data.get('ok'):
                    reward = data.get('rewardAmount') or data.get('reward', 0)
                    new_points = data.get('newPoints')
                    views_rem = data.get('viewsRemaining')
                    view_num = data.get('viewNumber')
                    if reward:
                        self.total_reward += reward
                        self.balance = new_points or self.balance
                        print(f"{GREEN}└─ ✅ Ad #{view_num} watched! +{reward} SHARDS (remaining: {views_rem}){RESET}")
                        return True, views_rem
                    else:
                        print(f"{GREEN}└─ ✅ Ad watched!{RESET}")
                        return True, views_rem
                else:
                    msg = data.get('message', data.get('error', 'Unknown'))
                    print(f"{YELLOW}└─ ⚠️ Ad failed: {msg}{RESET}")
                    return False, None
            except Exception as e:
                print(f"{GREEN}└─ ✅ Ad watched! (raw){RESET}")
                return True, None
        else:
            print(f"{RED}└─ ❌ Gagal: {resp.status_code}{RESET}")
            return False, None

    def watch_task(self, task):
        task_id = task['id']
        task_name = task['title']
        views_rem = task['views_remaining']
        next_reward = task['next_reward']
        
        print(f"\n{YELLOW}📺 {task_name} (remaining: {views_rem}, next: {next_reward} SHARDS){RESET}")
        
        self.get_user_id()
        time.sleep(2)
        
        token = self.generate_token(task_id)
        if not token:
            print(f"{RED}❌ Gagal generate token untuk task {task_id}{RESET}")
            return False
        
        # ⏳ TONTON IKLAN 30 DETIK (bukan 429)
        print(f"{BLUE}┌─ 📺 Menonton iklan 30 detik...{RESET}")
        for i in range(TIMER_ADS, 0, -1):
            sys.stdout.write(f"\r{YELLOW}⏳ Sisa waktu iklan {i} detik{RESET}")
            sys.stdout.flush()
            time.sleep(1)
        print()
        
        success, new_views_rem = self.mark_clicked(token, task_id)
        
        if success and new_views_rem is not None:
            task['views_remaining'] = new_views_rem
            view_rewards = task.get('view_rewards', [])
            used = task.get('max_views', 10) - new_views_rem
            if used < len(view_rewards):
                task['next_reward'] = view_rewards[used]
        
        return success

    def countdown(self, seconds, msg="⏳ Menunggu"):
        for i in range(seconds, 0, -1):
            sys.stdout.write(f"\r{YELLOW}{msg} {i} detik{RESET}")
            sys.stdout.flush()
            time.sleep(1)
        print()

    def is_all_done(self):
        return all(t['views_remaining'] <= 0 for t in self.tasks)

# ==================== MENU ====================
def show_menu():
    print(f"\n{CYAN}╔════════════════════════════════════════════════════╗")
    print(f"║                    MAIN MENU                         ║")
    print(f"╠════════════════════════════════════════════════════╣")
    print(f"║  {GREEN}[1]{RESET} 🚀 Start Farming (Auto detect ads)         ║")
    print(f"║  {YELLOW}[2]{RESET} 📝 Set Query_ID                         ║")
    print(f"║  {RED}[0]{RESET} ❌ Exit                                  ║")
    print(f"╚════════════════════════════════════════════════════╝{RESET}")

# ==================== FARMING ====================
def start_farming(config):
    if not config.init_data:
        print(f"{RED}❌ Query_ID belum diset!{RESET}")
        return

    bot = ShardsBot(config.init_data, config.auth_token)

    if not bot.login():
        print(f"{RED}❌ Login gagal. Cek Query_ID.{RESET}")
        return

    if bot.auth_token:
        config.auth_token = bot.auth_token
        config.save()

    bot.get_dashboard()
    
    if not bot.tasks:
        print(f"{YELLOW}⚠️ Tidak ada task ads yang tersisa.{RESET}")
        return

    print(f"{CYAN}🚀 Starting farming {len(bot.tasks)} ad tasks...{RESET}")
    print(f"{YELLOW}⏱️ Durasi iklan: {TIMER_ADS}s, antar cycle: {TIMER_CYCLE}s{RESET}")
    print(f"{YELLOW}Press Ctrl+C to stop{RESET}\n")

    cycle = 0
    try:
        while True:
            cycle += 1
            print(f"\n{CYAN}🔄 Cycle #{cycle}{RESET}")

            for task in bot.tasks:
                if task['views_remaining'] <= 0:
                    continue
                
                success = bot.watch_task(task)
                if not success:
                    print(f"{RED}❌ Task {task['id']} gagal, lanjut...{RESET}")

            bot.get_dashboard()

            if bot.is_all_done():
                print(f"\n{GREEN}✅ Semua iklan sudah ditonton! Total reward: {bot.total_reward} SHARDS{RESET}")
                print(f"📊 Final balance: {bot.balance} SHARDS")
                break

            print(f"{DIM}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━{RESET}")
            print(f"{YELLOW}⏰ Cycle #{cycle} selesai. Tunggu {TIMER_CYCLE} detik...{RESET}")
            bot.countdown(TIMER_CYCLE, "⏳ Next cycle dalam")
            
    except KeyboardInterrupt:
        print(f"\n{YELLOW}⏹️ Farming stopped.{RESET}")
        input("Tekan Enter untuk kembali ke menu...")

# ==================== MAIN ====================
def main():
    config = Config()
    config.load()

    while True:
        show_banner()
        show_menu()

        if config.init_data:
            print(f"{GREEN}✅ Query_ID tersimpan (panjang: {len(config.init_data)}){RESET}")
        else:
            print(f"{RED}❌ Query_ID belum diset!{RESET}")

        choice = input(f"\n{PURPLE}❯ Pilih: {RESET}").strip()

        if choice == '0':
            print(f"{YELLOW}👋 Bye!{RESET}")
            sys.exit(0)

        elif choice == '1':
            start_farming(config)

        elif choice == '2':
            print(f"{YELLOW}📝 Masukkan Query_ID dari Telegram:{RESET}")
            print(f"{DIM}Contoh: query_id=...&user=...&auth_date=...&hash=...{RESET}")
            qid = input("Query_ID: ").strip()
            if qid:
                config.init_data = qid
                config.auth_token = None
                config.save()
                print(f"{GREEN}✅ Query_ID disimpan!{RESET}")
            else:
                print(f"{RED}❌ Query_ID tidak boleh kosong!{RESET}")
            input("Tekan Enter untuk kembali...")

        else:
            print(f"{RED}❌ Pilihan salah!{RESET}")
            time.sleep(1)

if __name__ == "__main__":
    main()