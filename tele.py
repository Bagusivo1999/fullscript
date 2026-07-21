# tele.py - VERSION FIX
import os
import sys
import time
import subprocess
import threading
import requests
import re
import sqlite3
from datetime import datetime, timedelta
from flask import Flask, request, jsonify
from telegram.ext import Application, CommandHandler, CallbackQueryHandler
from telegram import InlineKeyboardButton, InlineKeyboardMarkup

# ============================================================
# 🔥 KONFIGURASI
# ============================================================

BOT_TOKEN = "7210640994:AAHp4tdBxeS1tL_kz8_Bq6pXgJpWrqfY2Q4"
ADMIN_ID = 1820443547
PORT = 2038

# ============================================================

app = Flask(__name__)

# ===== DATABASE =====
def init_db():
    conn = sqlite3.connect('license.db')
    c = conn.cursor()
    c.execute('''
        CREATE TABLE IF NOT EXISTS licenses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            license_key TEXT UNIQUE,
            user_id TEXT,
            username TEXT,
            first_name TEXT,
            last_name TEXT,
            created_at TEXT,
            expires_at TEXT,
            last_regenerated TEXT,
            regenerate_count INTEGER DEFAULT 0,
            status TEXT DEFAULT 'active'
        )
    ''')
    conn.commit()
    conn.close()

def generate_license():
    import random
    import string
    parts = []
    for _ in range(4):
        parts.append(''.join(random.choices(string.ascii_uppercase + string.digits, k=4)))
    return '-'.join(parts)

def save_license(user_id, username, first_name="", last_name=""):
    conn = sqlite3.connect('license.db')
    c = conn.cursor()
    
    license_key = generate_license()
    created_at = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    expires_at = (datetime.now() + timedelta(days=7)).strftime('%Y-%m-%d %H:%M:%S')
    last_regenerated = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    
    c.execute('''
        INSERT INTO licenses (license_key, user_id, username, first_name, last_name, created_at, expires_at, last_regenerated, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')
    ''', (license_key, str(user_id), username, first_name, last_name, created_at, expires_at, last_regenerated))
    
    conn.commit()
    conn.close()
    return license_key

def check_license(license_key):
    conn = sqlite3.connect('license.db')
    c = conn.cursor()
    
    c.execute('''
        SELECT license_key, user_id, username, expires_at, status, created_at
        FROM licenses
        WHERE license_key = ?
    ''', (license_key,))
    
    result = c.fetchone()
    conn.close()
    
    if not result:
        return None, "License tidak ditemukan!"
    
    license_key, user_id, username, expires_at, status, created_at = result
    
    if status != 'active':
        return None, "License sudah tidak aktif!"
    
    expires_date = datetime.strptime(expires_at, '%Y-%m-%d %H:%M:%S')
    if datetime.now() > expires_date:
        return None, "License sudah expired!"
    
    return {
        'license': license_key,
        'user_id': user_id,
        'username': username,
        'expires_at': expires_at,
        'created_at': created_at
    }, "License valid!"

def sync_valid_licenses():
    conn = sqlite3.connect('license.db')
    c = conn.cursor()
    
    c.execute('''
        SELECT license_key FROM licenses
        WHERE status = 'active' AND expires_at > datetime('now')
    ''')
    
    licenses = [row[0] for row in c.fetchall()]
    conn.close()
    
    with open('valid_licenses.txt', 'w') as f:
        for lic in licenses:
            f.write(lic + '\n')
    
    return len(licenses)

# ===== FLASK API =====
@app.route('/check', methods=['POST'])
def check_license_api():
    try:
        data = request.json
        license_key = data.get('license')
        
        if not license_key:
            return jsonify({'valid': False, 'message': 'License tidak boleh kosong'})
        
        conn = sqlite3.connect('license.db')
        c = conn.cursor()
        c.execute('''
            SELECT status, expires_at FROM licenses
            WHERE license_key = ? AND status = "active"
        ''', (license_key,))
        
        result = c.fetchone()
        conn.close()
        
        if not result:
            return jsonify({'valid': False, 'message': 'License tidak ditemukan'})
        
        status, expires_at = result
        
        expires_date = datetime.strptime(expires_at, '%Y-%m-%d %H:%M:%S')
        if datetime.now() > expires_date:
            return jsonify({'valid': False, 'message': 'License expired'})
        
        return jsonify({'valid': True, 'message': 'License valid'})
        
    except Exception as e:
        return jsonify({'valid': False, 'message': str(e)})

@app.route('/status', methods=['GET'])
def status():
    return jsonify({
        'status': 'online',
        'time': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    })

@app.route('/valid_licenses.txt', methods=['GET'])
def get_valid_licenses():
    try:
        with open('valid_licenses.txt', 'r') as f:
            content = f.read()
        return content, 200, {'Content-Type': 'text/plain'}
    except:
        return "No licenses", 404

# ===== TUNNEL SERVA =====
public_url = None

def send_telegram_notification(url):
    try:
        message = f"""
🎉 *TUNNEL AKTIF!*

🔗 URL Publik: `{url}`

📌 Gunakan URL ini di PHP:
$url = "{url}/check";

📌 Untuk validasi license:
$url = "{url}/valid_licenses.txt";

⏰ Waktu: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}
"""
        
        requests.post(
            f"https://api.telegram.org/bot{BOT_TOKEN}/sendMessage",
            json={
                'chat_id': ADMIN_ID,
                'text': message,
                'parse_mode': 'Markdown'
            }
        )
        print("[✅] Notifikasi terkirim ke admin!")
    except Exception as e:
        print(f"[❌] Gagal kirim notifikasi: {e}")

def run_tunnel():
    global public_url
    while True:
        try:
            print("\n[🚀] Menjalankan tunnel Serveo...")
            cmd = ["ssh", "-R", "80:localhost:2038", "serveo.net"]
            
            process = subprocess.Popen(
                cmd,
                stdout=subprocess.PIPE,
                stderr=subprocess.PIPE,
                text=True
            )
            
            for line in process.stdout:
                if "https://" in line:
                    match = re.search(r'(https://[a-zA-Z0-9.-]+\.serveo\.net)', line)
                    if match:
                        public_url = match.group(1)
                        print(f"\n[✅] URL PUBLIK: {public_url}")
                        with open('public_url.txt', 'w') as f:
                            f.write(public_url)
                        send_telegram_notification(public_url)
                print(line, end='')
            
            print("[⚠️] Tunnel mati, restart dalam 5 detik...")
            time.sleep(5)
            
        except Exception as e:
            print(f"[❌] Error tunnel: {e}")
            time.sleep(10)

# ===== BOT TELEGRAM =====
async def start(update, context):
    user_id = update.effective_user.id
    username = update.effective_user.username or "NoUsername"
    first_name = update.effective_user.first_name or ""
    last_name = update.effective_user.last_name or ""
    
    conn = sqlite3.connect('license.db')
    c = conn.cursor()
    c.execute('''
        SELECT license_key, expires_at FROM licenses
        WHERE user_id = ? AND status = "active"
        ORDER BY id DESC LIMIT 1
    ''', (str(user_id),))
    existing = c.fetchone()
    conn.close()
    
    if existing:
        license_key, expires_at = existing
        keyboard = [[InlineKeyboardButton("📋 Copy License", callback_data=f"copy_{license_key}")]]
        reply_markup = InlineKeyboardMarkup(keyboard)
        
        await update.message.reply_text(
            f"🎫 *License Kamu:*\n\n"
            f"🔑 `{license_key}`\n\n"
            f"⏰ Expired: {expires_at}\n"
            f"📌 Copy license ini, lalu masukkan ke script PHP.",
            reply_markup=reply_markup,
            parse_mode='Markdown'
        )
    else:
        license_key = save_license(user_id, username, first_name, last_name)
        sync_valid_licenses()
        
        keyboard = [[InlineKeyboardButton("📋 Copy License", callback_data=f"copy_{license_key}")]]
        reply_markup = InlineKeyboardMarkup(keyboard)
        
        await update.message.reply_text(
            f"✅ *License Berhasil Dibuat!*\n\n"
            f"🔑 `{license_key}`\n\n"
            f"⏰ Masa aktif: 7 hari\n"
            f"🔄 License berganti otomatis setiap 2 hari\n"
            f"📌 Copy license ini, lalu masukkan ke script PHP.",
            reply_markup=reply_markup,
            parse_mode='Markdown'
        )

async def callback_handler(update, context):
    query = update.callback_query
    await query.answer()
    
    if query.data.startswith("copy_"):
        license_key = query.data.replace("copy_", "")
        await query.edit_message_text(
            f"📋 License: `{license_key}`\n\nSilakan copy dan masukkan ke script PHP.",
            parse_mode='Markdown'
        )

# ===== MAIN =====
def main():
    init_db()
    sync_valid_licenses()
    
    # Flask thread
    flask_thread = threading.Thread(target=lambda: app.run(host='0.0.0.0', port=PORT, debug=False))
    flask_thread.daemon = True
    flask_thread.start()
    print(f"[✅] Flask API running on port {PORT}")
    
    # Tunnel thread
    tunnel_thread = threading.Thread(target=run_tunnel)
    tunnel_thread.daemon = True
    tunnel_thread.start()
    
    # Bot Telegram
    app_bot = Application.builder().token(BOT_TOKEN).build()
    app_bot.add_handler(CommandHandler("start", start))
    app_bot.add_handler(CallbackQueryHandler(callback_handler))
    
    print("[✅] Bot Telegram running...")
    app_bot.run_polling()

if __name__ == "__main__":
    main()