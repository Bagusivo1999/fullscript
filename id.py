# Di awal bot_license.py
from flask import Flask, request, jsonify
import threading

# ... kode bot ...

# ===== FLASK API =====
flask_app = Flask(__name__)

@flask_app.route('/check', methods=['POST'])
def check_license_api():
    # ... kode cek license ...
    return jsonify({'valid': True})

def run_flask():
    flask_app.run(host='0.0.0.0', port=2038)

# Di main(), jalankan Flask di thread terpisah
if __name__ == "__main__":
    threading.Thread(target=run_flask, daemon=True).start()
    main()  # Jalankan bot