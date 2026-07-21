# api_license.py - Jalankan di Pterodactyl
from flask import Flask, request, jsonify
import sqlite3
from datetime import datetime
import os

app = Flask(__name__)

# Path database
DB_PATH = os.path.join(os.path.dirname(__file__), 'license.db')

@app.route('/check', methods=['POST'])
def check_license():
    try:
        data = request.json
        license_key = data.get('license')
        
        if not license_key:
            return jsonify({'valid': False, 'message': 'License tidak boleh kosong'})
        
        conn = sqlite3.connect(DB_PATH)
        c = conn.cursor()
        
        c.execute('''
            SELECT status, expires_at FROM licenses
            WHERE license_key = ? AND status = 'active'
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
    """Cek status server"""
    return jsonify({
        'status': 'online',
        'time': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    })

if __name__ == '__main__':
    # Jalankan di port 2038 (sesuai domain)
    app.run(host='0.0.0.0', port=2038, debug=False)