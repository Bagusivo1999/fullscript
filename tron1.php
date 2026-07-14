<?php
// tronblow_simple.php
// TRONBLOW CAPTCHA SOLVER - SIMPLE VERSION
function xontol(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    xontol();
    
    const script = "TRONBLOW";
    $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);
// ========== COOKIE MANAGEMENT ==========
function saveCookie($data, $filename = "cookie_tronblow.txt") {
    file_put_contents($filename, $data);
    return true;
}

function loadCookie($filename = "cookie_tronblow.txt") {
    if (file_exists($filename)) {
        return file_get_contents($filename);
    }
    return '';
}

function getCookie() {
    $cookie = loadCookie("cookie_tronblow.txt");
    if (empty($cookie)) {
        $cookie = 'PHPSESSID=j709eross1b1g47l8h9g1gdea0';
        saveCookie($cookie);
    }
    return $cookie;
}

// ========== FUNCTION CURL ==========
function cuk($url, $post = 0, $httpheader = 0, $proxy = 0){
    $cookie = getCookie();
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_DOH_URL, 'https://dns.google/dns-query');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_PORT, 443);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_TCP_KEEPALIVE, true);
    curl_setopt($ch, CURLOPT_TCP_KEEPIDLE, 60);
    curl_setopt($ch, CURLOPT_TCP_KEEPINTVL, 60);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "Cookie.json");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "Cookie.json");
    
    if($post){ 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if($httpheader){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    }
    if($proxy){
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    
    if ($response) {
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        if (!empty($matches[1])) {
            $cookie_string = implode('; ', $matches[1]);
            saveCookie($cookie_string);
        }
    }
    
    if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        return array($header, $body);
    }
}

function cuk1($url){
    return cuk($url, null, headers())[1];
}

function cuk2($url,$data){
    return cuk($url, $data, headers())[1];
}

// ========== HEADERS ==========
function headers() {
    $cookie = getCookie();
    return [
        'Host: tronblow.site',
        'Content-Type: application/x-www-form-urlencoded',
        'Origin: https://tronblow.site',
        'Referer: https://tronblow.site/',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cache-Control: max-age=0',
        'Upgrade-Insecure-Requests: 1',
        'Sec-Fetch-Site: same-origin',
        'Sec-Fetch-Mode: navigate',
        'Sec-Fetch-User: ?1',
        'Sec-Fetch-Dest: document',
        'Sec-Ch-Ua: "Chromium";v="137", "Not/A)Brand";v="24"',
        'Sec-Ch-Ua-Mobile: ?1',
        'Sec-Ch-Ua-Platform: "Android"',
        'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
        'Cookie: ' . $cookie
    ];
}

// ========== FUNGSI ==========

function extractMathQuestion($html) {
    $patterns = [
        '/What is (\d+)\s*([+\-])\s*(\d+)\s*=/',
        '/(\d+)\s*([+\-])\s*(\d+)\s*=/',
        '/(\d+)\s*([+\-])\s*(\d+)/'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $html, $matches)) {
            if (count($matches) >= 4) {
                return [
                    'num1' => (int)$matches[1],
                    'operator' => $matches[2],
                    'num2' => (int)$matches[3]
                ];
            }
        }
    }
    return false;
}

function calculateMath($num1, $operator, $num2) {
    switch($operator) {
        case '+': return $num1 + $num2;
        case '-': return $num1 - $num2;
        case '*': return $num1 * $num2;
        case '/': return $num2 != 0 ? $num1 / $num2 : 0;
        default: return 0;
    }
}

function extractTimer($html) {
    preg_match('/var s=(\d+);/', $html, $matches);
    if (!empty($matches)) {
        return (int)$matches[1];
    }
    preg_match('/var timer\s*=\s*(\d+)/', $html, $matches);
    if (!empty($matches)) {
        return (int)$matches[1];
    }
    return 0;
}

function extractTimerFromError($message) {
    $patterns = [
        '/(\d+)\s*m\s*(\d+)\s*s/',
        '/(\d+)\s*m/',
        '/(\d+)\s*s/',
        '/wait\s*(\d+)\s*seconds?/i',
        '/wait\s*(\d+)\s*s/i'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $message, $matches)) {
            if (count($matches) == 3) {
                $minutes = (int)$matches[1];
                $seconds = (int)$matches[2];
                return ($minutes * 60) + $seconds;
            } elseif (count($matches) == 2) {
                return (int)$matches[1];
            }
        }
    }
    return 0;
}

function extractMessage($html) {
    if (preg_match('/<div class="alert alert-success">(.*?)<\/div>/', $html, $matches)) {
        return ['success' => true, 'message' => strip_tags($matches[1])];
    }
    if (preg_match('/<div class="alert alert-danger">(.*?)<\/div>/', $html, $matches)) {
        $message = strip_tags($matches[1]);
        return ['success' => false, 'message' => $message];
    }
    if (preg_match('/<div class="alert alert-(.*?)">(.*?)<\/div>/', $html, $matches)) {
        $message = strip_tags($matches[2]);
        return ['success' => false, 'message' => $message];
    }
    return ['success' => false, 'message' => 'No message found'];
}

function formatTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $secs = $seconds % 60;
    
    if ($hours > 0) {
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
    }
    return sprintf("%02d:%02d", $minutes, $secs);
}

// ========== TIMER SIMPLE (TIDAK MANJANG) ==========

function waitTimer($seconds, $label = "⏱") {
    if ($seconds <= 0) return;
    
    // Simpan posisi cursor
    echo "\033[s";
    
    for ($i = $seconds; $i >= 0; $i--) {
        // Kembali ke posisi awal
        echo "\033[u\033[K";
        
        $progress = (($seconds - $i) / $seconds) * 100;
        $bar_length = 30;
        $filled = round(($progress / 100) * $bar_length);
        $empty = $bar_length - $filled;
        $bar = str_repeat("█", $filled) . str_repeat("░", $empty);
        
        $time_left = formatTime($i);
        
        echo "$label $time_left [$bar] " . round($progress) . "%";
        
        if ($i > 0) {
            usleep(1000000);
        }
    }
    echo "\n";
}

// ========== FUNGSI CLAIM ==========

function resolveAndClaim($email) {
    
    $html = cuk1('https://tronblow.site/');
    
    // Cek timer
    $timer = extractTimer($html);
    if ($timer > 0) {
        waitTimer($timer, "⏱ Cooldown");
        echo "🔄 Refresh...\n";
        $html = cuk1('https://tronblow.site/');
    }
    
    // Ekstrak soal
    $math = extractMathQuestion($html);
    if (!$math) {
        echo "❌ Gagal ambil soal, coba lagi...\n";
        sleep(2);
        $html = cuk1('https://tronblow.site/');
        $math = extractMathQuestion($html);
        if (!$math) {
            return ['success' => false, 'message' => 'Gagal mengambil soal'];
        }
    }
    
    // Hitung jawaban
    $answer = calculateMath($math['num1'], $math['operator'], $math['num2']);
    
    echo "🧮 Captcha: {$math['num1']} {$math['operator']} {$math['num2']} = ?\n";
    echo "✅ Jawaban: {$answer}\n";
$mail = urldecode($email);
// Hasil: bagusfildhonfatoni8@gmail.com ✅
    // Kirim claim
    $postData = http_build_query([
        'action' => 'claim',
        'math_q1' => $math['num1'],
        'math_q2' => $math['num2'],
        'math_op' => $math['operator'],
        'email' => $mail,
        'math_answer' => $answer
    ]);
    
    echo "📤 Mengirim claim...\n";
    
    $response = cuk2('https://tronblow.site/', $postData);
    
    // Parse response
    $result = extractMessage($response);
    $timer_from_error = 0;
    $timer_from_html = extractTimer($response);
    
    if (!$result['success']) {
        $timer_from_error = extractTimerFromError($result['message']);
        if ($timer_from_error > 0) {
            $result['wait_time'] = $timer_from_error;
        }
    }
    
    if ($timer_from_html > 0) {
        $result['wait_time'] = $timer_from_html;
    }
    
    // Tampilkan hasil
    if ($result['success']) {
        echo "✅ SUCCESS: {$result['message']}\n";
    } else {
        echo "❌ FAILED: {$result['message']}\n";
        if ($timer_from_error > 0) {
            echo "⏱ Wait: " . formatTime($timer_from_error) . "\n";
        }
    }
    
    return $result;
}

function autoResolve($email) {
    $count = 0;
    
    while (true) {
        $count++;
        echo "🔄 CLAIM KE-#$count  🕐 " . date('H:i:s') . "\n";
        g();
        $result = resolveAndClaim($email);
        
        if ($result['success']) {
            $wait_time = 60;
        } else {
            $wait_time = isset($result['wait_time']) ? $result['wait_time'] : 30;
        }
        
        if ($wait_time > 0) {
            waitTimer($wait_time, "⏱ Next"); g();
        } else {
            echo "⏱ Timer 0, tunggu 10 detik...\n";
            sleep(10);
        }
    }
}

function showCookieInfo() {
    $cookie = getCookie();
    if (file_exists("cookie_tronblow.txt")) {
        
    }
}

function updateCookie($new_cookie) {
    saveCookie($new_cookie);
    echo "✅ Cookie updated!\n";
}

function clearScreen() {
    echo "\033[2J\033[H";
}

function showMenu($email) {
    bn();
    echo "  📧 Email: $email\n";
    showCookieInfo();
    g();
    echo "  1. Claim Sekali (Auto Timer)\n";
    echo "  2. Auto Claim (Loop)\n";
    echo "  3. Update Cookie\n";
    echo "  4. Hapus Cookie\n";
    echo "  5. Exit\n";
    g();
    echo "  Pilih (1-5): ";
}

// ========== MAIN ==========
function main() {
    if (isset($argv[1]) && $argv[1] == '--clear-cookie') {
        if (file_exists("cookie_tronblow.txt")) unlink("cookie_tronblow.txt");
        if (file_exists("Cookie.json")) unlink("Cookie.json");
        echo "✅ Cookie dihapus\n";
    }
    
    $email = Sav("email tronblow");
    $running = true;
    
    while ($running) {
        showMenu($email);
        
        $handle = fopen("php://stdin", "r");
        $choice = trim(fgets($handle));
        fclose($handle);
        
        switch($choice) {
            case '1':
                bn();
                resolveAndClaim($email);
                echo "\nTekan Enter untuk kembali...";
                fgets(fopen("php://stdin", "r"));
                break;
                
            case '2':
                bn();
                autoResolve($email);
                break;
                
            case '3':
                bn();
                echo "Masukkan cookie baru: ";
                $handle = fopen("php://stdin", "r");
                $new_cookie = trim(fgets($handle));
                fclose($handle);
                if (!empty($new_cookie)) {
                    updateCookie($new_cookie);
                } else {
                    echo "❌ Cookie tidak boleh kosong!\n";
                }
                echo "\nTekan Enter untuk kembali...";
                fgets(fopen("php://stdin", "r"));
                break;
                
            case '4':
            bn();
                if (file_exists("cookie_tronblow.txt")) unlink("cookie_tronblow.txt");
                if (file_exists("Cookie.json")) unlink("Cookie.json");
                echo "✅ Cookie dihapus!\n";
                echo "\nTekan Enter untuk kembali...";
                fgets(fopen("php://stdin", "r"));
                break;
                
            case '5':
                bn();
                echo "\n👋 Sampai jumpa!\n\n";
                $running = false;
                break;
                
            default:
                echo "\n❌ Pilihan tidak valid!\n";
                echo "Tekan Enter untuk kembali...";
                fgets(fopen("php://stdin", "r"));
        }
    }
}

if (php_sapi_name() === 'cli') {
    main();
} else {
    header('Content-Type: text/plain');
    echo "Script ini hanya untuk Termux/CLI!\n";
    echo "Jalankan: php tronblow_simple.php\n";
}
?>