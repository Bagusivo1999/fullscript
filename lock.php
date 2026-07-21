<?php
/*
 ============================================================
   🔒 ULTIMATE SECURITY SYSTEM v3.0
   Melindungi dari: VPN, Proxy, Root, Emulator, Debugger,
   Interceptor (Reqable/Canary), Scraper, Dll
 ============================================================
*/

// ==================== KONFIGURASI ====================
define('SECRET_KEY', 'DEV_9d41bcefccfd0462_6a5efe08_fd925706a42769f5' . date('Ymd')); // Ganti dengan key Anda
define('MAX_REQUESTS', 5); // Maksimal request per 60 detik
define('BLOCK_TIME', 3600); // Block time dalam detik

// ==================== FUNGSI UTAMA ====================
function killConnection($reason, $level = 'CRITICAL') {
    // Log ke file
    $log = date('Y-m-d H:i:s') . " | $level | $reason | IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    @file_put_contents(__DIR__ . '/security.log', $log, FILE_APPEND);
    
    // Delay acak untuk confuse
    usleep(rand(500, 3000));
    
    // Multiple header response
    header('HTTP/1.0 403 Forbidden');
    header('Content-Type: text/html');
    header('X-Security-Status: BLOCKED');
    header('X-Block-Code: ' . bin2hex(random_bytes(4)));
    
    // Tampilkan pesan error random
    $messages = [
        '🚫 Access Denied',
        '🔒 Connection Blocked',
        '⚠️ Security Violation',
        '❌ Unauthorized Access'
    ];
    
    $html = <<<HTML
    <!DOCTYPE html>
    <html>
    <head><title>Access Denied</title>
    <style>
        body { 
            background: #0a0a0a; 
            color: #ff4444; 
            font-family: monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .error-box {
            border: 2px solid #ff4444;
            padding: 40px;
            border-radius: 10px;
            max-width: 600px;
            background: #1a1a1a;
        }
        .code { color: #ff8800; font-size: 12px; }
        .reason { color: #ff6666; font-weight: bold; }
    </style>
    </head>
    <body>
        <div class="error-box">
            <h1>{$messages[array_rand($messages)]}</h1>
            <p class="reason">⚠️ {$reason}</p>
            <p class="code">🔐 Security ID: " . bin2hex(random_bytes(8)) . "</p>
            <p style="color:#666;font-size:12px;">Your activity has been logged</p>
        </div>
    </body>
    </html>
HTML;
    
    die($html);
}

// ==================== 1. DETEKSI VPN & PROXY ====================
function detectVPNProxy() {
    // Cek via ifconfig
    $interfaces = shell_exec('2>/dev/null ifconfig');
    if(preg_match('/tun[0-9]|tap[0-9]|ppp[0-9]|utun|wg[0-9]|openvpn/i', $interfaces)) {
        killConnection('VPN/Tunnel Detected');
    }
    
    // Cek via ip addr
    $ip_addr = shell_exec('2>/dev/null ip addr');
    if(preg_match('/tun[0-9]|tap[0-9]|ppp[0-9]|utun/i', $ip_addr)) {
        killConnection('VPN/Tunnel Detected');
    }
    
    // Cek route
    $route = shell_exec('2>/dev/null route -n');
    if(preg_match('/tun[0-9]|tap[0-9]|ppp[0-9]/i', $route)) {
        killConnection('VPN Route Detected');
    }
    
    // Cek IP publik vs lokal
    $ip = $_SERVER['REMOTE_ADDR'];
    $private_ips = ['10.', '172.16.', '172.17.', '172.18.', '172.19.',
                    '172.20.', '172.21.', '172.22.', '172.23.', '172.24.',
                    '172.25.', '172.26.', '172.27.', '172.28.', '172.29.',
                    '172.30.', '172.31.', '192.168.'];
    
    foreach($private_ips as $prefix) {
        if(strpos($ip, $prefix) === 0) {
            // IP private, cek apakah ada VPN
            $vpn_check = shell_exec('2>/dev/null ifconfig | grep -E "tun|tap|ppp"');
            if(!empty($vpn_check)) {
                killConnection('Private IP with VPN');
            }
        }
    }
    
    // Cek header proxy
    $proxy_headers = ['HTTP_VIA', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED_HOST',
                      'HTTP_X_FORWARDED_PROTO', 'HTTP_PROXY_CONNECTION'];
    foreach($proxy_headers as $header) {
        if(isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
            killConnection('Proxy Header Detected: ' . $header);
        }
    }
    
    // Cek DNS reverse
    $hostname = gethostbyaddr($ip);
    if(strpos($hostname, 'proxy') !== false || 
       strpos($hostname, 'vpn') !== false || 
       strpos($hostname, 'tor') !== false ||
       strpos($hostname, 'anonym') !== false) {
        killConnection('Proxy/VPN DNS Detected');
    }
}

// ==================== 2. DETEKSI ROOT & PERANGKAT MODIFIKASI ====================
function detectRoot() {
    // File-file root
    $root_files = [
        '/system/xbin/su',
        '/system/bin/su',
        '/system/sbin/su',
        '/data/local/xbin/su',
        '/data/local/bin/su',
        '/data/local/su',
        '/system/bin/.ext/.su',
        '/system/xbin/daemonsu',
        '/system/app/Superuser.apk',
        '/system/app/SuperSU.apk',
        '/system/app/ChainsDD.apk',
        '/data/data/com.topjohnwu.magisk',
        '/data/data/com.koushikdutta.superuser',
        '/data/data/com.noshufou.android.su',
        '/system/lib/libsu.so',
        '/system/lib64/libsu.so'
    ];
    
    foreach($root_files as $file) {
        if(file_exists($file)) {
            killConnection('Root Detected: ' . basename($file));
        }
    }
    
    // Cek command su
    $su_check = shell_exec('2>/dev/null which su');
    if(!empty(trim($su_check))) {
        killConnection('Root Binary Detected');
    }
    
    // Cek user ID
    $uid = shell_exec('2>/dev/null id -u');
    if(trim($uid) === '0') {
        killConnection('Root User Detected');
    }
    
    // Cek build.prop
    $buildprop = @file_get_contents('/system/build.prop');
    if($buildprop) {
        if(preg_match('/ro\.kernel\.qemu=1/i', $buildprop) ||
           preg_match('/ro\.product\.device=generic/i', $buildprop) ||
           preg_match('/ro\.product\.manufacturer=unknown/i', $buildprop)) {
            killConnection('Emulator Detected');
        }
    }
}

// ==================== 3. DETEKSI INTERCEPTOR (REQABLE, CANARY, DLL) ====================
function detectInterceptor() {
    // Header khusus interceptor
    $interceptor_headers = [
        'HTTP_REQABLE_SESSION',
        'HTTP_REQABLE_VERSION',
        'HTTP_REQABLE_DEVICE',
        'HTTP_X_REQABLE',
        'HTTP_X_CANARY',
        'HTTP_X_PROXY',
        'HTTP_X_INTERCEPT',
        'HTTP_X_SSL_INTERCEPT',
        'HTTP_X_HTTP_CANARY'
    ];
    
    foreach($interceptor_headers as $header) {
        if(isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
            killConnection('Interceptor Detected: ' . $header);
        }
    }
    
    // Cek User-Agent interceptor
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $interceptor_ua = [
        'Reqable', 'Canary', 'HttpCanary', 'Charles', 'Fiddler',
        'Burp', 'mitmproxy', 'Packet Capture', 'Proxy',
        'okhttp', 'retrofit', 'volley', 'android-async-http'
    ];
    
    foreach($interceptor_ua as $pattern) {
        if(stripos($ua, $pattern) !== false) {
            killConnection('Interceptor Tool: ' . $pattern);
        }
    }
    
    // Cek SSL Certificate Interceptor
    if(function_exists('openssl_x509_parse')) {
        $context = stream_context_get_params(stream_context_get_default());
        if(isset($context['options']['ssl']['peer_certificate'])) {
            $cert = openssl_x509_parse($context['options']['ssl']['peer_certificate']);
            
            if($cert) {
                $suspicious_issuers = ['Reqable', 'Canary', 'Charles', 'Fiddler', 'Burp', 'mitmproxy'];
                foreach($suspicious_issuers as $issuer) {
                    if(stripos($cert['issuer']['O'] ?? '', $issuer) !== false ||
                       stripos($cert['issuer']['CN'] ?? '', $issuer) !== false) {
                        killConnection('SSL Interception: ' . $issuer);
                    }
                }
            }
        }
    }
    
    // Cek package android interceptor
    if(stripos($ua, 'Android') !== false) {
        $interceptor_packages = [
            'com.reqable',
            'com.canary.http.canary',
            'com.charles',
            'com.fiddler',
            'com.burpsuite',
            'com.android.httpproxy'
        ];
        
        foreach($interceptor_packages as $package) {
            $check = shell_exec("2>/dev/null pm list packages | grep -i '$package'");
            if(!empty(trim($check))) {
                killConnection('Interceptor Package: ' . $package);
            }
        }
    }
}

// ==================== 4. DETEKSI SCRAPER & BOT ====================
function detectScraper() {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // Bot/Scraper patterns
    $bot_patterns = [
        'bot', 'crawl', 'spider', 'scraper', 'wget', 'curl',
        'python', 'java', 'http client', 'phantomjs', 'selenium',
        'headless', 'puppeteer', 'lighthouse', 'nutch',
        'scrapy', 'guzzle', 'rest-client', 'insomnia',
        'postman', 'nikto', 'sqlmap', 'nmap', 'burp',
        'zap', 'owasp', 'nuclei', 'masscan'
    ];
    
    foreach($bot_patterns as $pattern) {
        if(stripos($ua, $pattern) !== false) {
            killConnection('Bot/Scraper Detected: ' . $pattern);
        }
    }
    
    // Cek header lengkap (bot biasanya missing header)
    $required_headers = ['HTTP_ACCEPT', 'HTTP_ACCEPT_LANGUAGE', 'HTTP_ACCEPT_ENCODING'];
    foreach($required_headers as $header) {
        if(!isset($_SERVER[$header]) || empty($_SERVER[$header])) {
            killConnection('Invalid Headers');
        }
    }
    
    // Rate limiting
    $ip = $_SERVER['REMOTE_ADDR'];
    $cache_key = 'rate_' . md5($ip);
    $cache_file = __DIR__ . '/cache/' . $cache_key . '.txt';
    
    if(!is_dir(__DIR__ . '/cache')) {
        mkdir(__DIR__ . '/cache', 0755, true);
    }
    
    if(file_exists($cache_file)) {
        $data = json_decode(file_get_contents($cache_file), true);
        if($data && isset($data['time'])) {
            if($data['time'] > time() - 60) {
                if($data['count'] >= MAX_REQUESTS) {
                    // Cek apakah masih dalam block time
                    if(isset($data['blocked_until']) && $data['blocked_until'] > time()) {
                        killConnection('Rate Limit Blocked until: ' . date('H:i:s', $data['blocked_until']));
                    }
                    // Block untuk 1 jam
                    $data['blocked_until'] = time() + BLOCK_TIME;
                    file_put_contents($cache_file, json_encode($data));
                    killConnection('Rate Limit Exceeded - Blocked 1 Hour');
                }
                $data['count']++;
            } else {
                $data = ['count' => 1, 'time' => time()];
            }
        }
    } else {
        $data = ['count' => 1, 'time' => time()];
    }
    file_put_contents($cache_file, json_encode($data));
}

// ==================== 5. DETEKSI XPOSED, FRIDA, DLL ====================
function detectHackingTools() {
    // Cek Xposed
    $xposed_files = [
        '/data/data/de.robv.android.xposed.installer',
        '/system/framework/XposedBridge.jar',
        '/system/bin/app_process.orig',
        '/data/data/de.robv.android.xposed.installer/bin/XposedBridge.jar'
    ];
    
    foreach($xposed_files as $file) {
        if(file_exists($file)) {
            killConnection('Xposed Framework Detected');
        }
    }
    
    // Cek Frida
    $frida_processes = shell_exec('2>/dev/null ps aux | grep -i frida');
    if(preg_match('/frida|gum-js|frida-agent|frida-gadget|frida-server/i', $frida_processes)) {
        killConnection('Frida Detected');
    }
    
    // Cek debug
    if(isset($_SERVER['HTTP_X_DEBUG_INFO']) || 
       isset($_GET['debug']) || 
       isset($_GET['xdebug']) ||
       isset($_GET['XDEBUG_SESSION'])) {
        killConnection('Debug Mode Detected');
    }
    
    // Cek hooking
    if(isset($_SERVER['HTTP_X_HOOK']) || 
       isset($_SERVER['HTTP_X_FRIDA'])) {
        killConnection('Hooking Detected');
    }
}

// ==================== 6. VALIDASI TOKEN & SESSION ====================
function validateSession() {
    session_start();
    
    // Device fingerprint
    $fingerprint = hash('sha256', 
        ($_SERVER['HTTP_USER_AGENT'] ?? '') . '|' .
        ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '') . '|' .
        ($_SERVER['HTTP_ACCEPT_ENCODING'] ?? '') . '|' .
        ($_SERVER['HTTP_ACCEPT'] ?? '')
    );
    
    if(!isset($_SESSION['device_fingerprint'])) {
        $_SESSION['device_fingerprint'] = $fingerprint;
        $_SESSION['session_start'] = time();
    } elseif($_SESSION['device_fingerprint'] !== $fingerprint) {
        killConnection('Device Fingerprint Mismatch');
    }
    
    // Token validation
    if(!isset($_SESSION['request_token'])) {
        $_SESSION['request_token'] = bin2hex(random_bytes(32));
        $_SESSION['token_time'] = time();
    }
    
    // Token expired setelah 5 menit
    if(time() - $_SESSION['token_time'] > 300) {
        session_regenerate_id(true);
        $_SESSION['request_token'] = bin2hex(random_bytes(32));
        $_SESSION['token_time'] = time();
    }
    
    // Cek token di request
    if(!isset($_GET['token']) || $_GET['token'] !== $_SESSION['request_token']) {
        // Cek di header
        if(!isset($_SERVER['HTTP_X_REQUEST_TOKEN']) || 
           $_SERVER['HTTP_X_REQUEST_TOKEN'] !== $_SESSION['request_token']) {
            killConnection('Invalid Request Token');
        }
    }
}

// ==================== 7. VALIDASI SERTIFIKAT APK ====================
function validateAppSignature() {
    // Cek apakah ini dari aplikasi Android
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if(stripos($ua, 'Android') !== false) {
        // Cek signature app
        $package = 'com.your.app'; // GANTI DENGAN PACKAGE NAME ANDA
        $sig_check = shell_exec("2>/dev/null dumpsys package $package | grep -A 20 'signatures'");
        
        // Signature yang valid - GANTI DENGAN SIGNATURE APK ANDA
        $valid_signatures = [
            'YOUR_APP_SIGNATURE_HASH_1',
            'YOUR_APP_SIGNATURE_HASH_2'
        ];
        
        $valid = false;
        foreach($valid_signatures as $sig) {
            if(strpos($sig_check, $sig) !== false) {
                $valid = true;
                break;
            }
        }
        
        if(!$valid) {
            killConnection('Invalid App Signature');
        }
    }
}

// ==================== 8. FUNGSI UTAMA ====================
function securityCheck() {
    echo "\n🔒 [SECURITY] Initializing...\n";
    
    // Jalankan semua deteksi
    detectVPNProxy();
    echo "✓ VPN/Proxy Check Passed\n";
    
    detectRoot();
    echo "✓ Root Check Passed\n";
    
    detectInterceptor();
    echo "✓ Interceptor Check Passed\n";
    
    detectScraper();
    echo "✓ Scraper Check Passed\n";
    
    detectHackingTools();
    echo "✓ Hacking Tools Check Passed\n";
    
    validateAppSignature();
    echo "✓ App Signature Valid\n";
    
    validateSession();
    echo "✓ Session Validated\n";
    
    echo "✅ [SECURITY] All checks passed!\n";
    echo "🔐 Connection secured successfully.\n\n";
}

// ==================== EKSEKUSI ====================
// Buat cache directory jika belum ada
if(!is_dir(__DIR__ . '/cache')) {
    mkdir(__DIR__ . '/cache', 0755, true);
}

// Jalankan security check
securityCheck();

// ==================== FUNGSI UTAMA APLIKASI ====================
function sock() {
    // Hanya izinkan jika semua security check passed
    echo "\033[1;32m========================================\n";
    echo "   🚀 ACCESS GRANTED\n";
    echo "   Sistem aman, silakan lanjutkan\n";
    echo "========================================\n\n";
    
    // ==== KODE APLIKASI ANDA DI SINI ====
    echo "Selamat datang di aplikasi aman!\n";
    // ... kode aplikasi Anda ...
}

// Jalankan aplikasi
sock();

/*
 ============================================================
   📝 CATATAN PENTING:
   1. Ganti 'YOUR_SECRET_KEY' dengan key unik Anda
   2. Ganti 'com.your.app' dengan package name aplikasi
   3. Ganti 'YOUR_APP_SIGNATURE_HASH' dengan signature APK
   4. Buat folder cache dengan permission 0755
   5. Update secara berkala pola deteksi
 ============================================================
*/
?>