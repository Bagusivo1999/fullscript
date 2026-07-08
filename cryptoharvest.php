<?php

// Matikan pesan error/deprecated bawaan PHP biar terminal bersih
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function sock(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    sock();


// Konfigurasi Warna ANSI
$M = "\033[91m";
$G = "\033[92m";
$Y = "\033[93m";
$B = "\033[94m";
$P = "\033[95m";
$C = "\033[96m";
$RES = "\033[0m";

// User-Agent yang benar sesuai app
$UA = "CryptoHarvestApp/1.0_13.02.2025//JK";

// Membersihkan layar di awal
function clear_screen() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}

// Typing effect seperti Beez
function typing($text, $warna, $delay = 50000) {
    global $RES;
    $text = strtoupper(preg_replace('/\s+/', " ", trim($text)));
    $str = str_split(str_pad($text, 46, " ", STR_PAD_BOTH));
    $typing = null;
    foreach ($str as $value) {
        $typing .= $value;
        strlen($typing) > 46 ? $typing = substr($typing, 1) : null;
        echo "\r  " . $warna . $typing . $RES . " ";
        usleep($delay);
    }
    for ($i = 0; $i < 4; $i++) {
        usleep(100000);
    }
    echo "\n";
}

// Show result seperti Beez - FIXED
function show_result($task, $result, $count = null) {
    global $G, $Y, $C, $RES, $M, $P;
    
    $task_short = strlen($task) > 18 ? substr($task, 0, 15) . "..." : $task;
    $date = date("H:i:s");
    
    echo "\r" . $M . str_pad(" [ " . $task_short . " ]" . ($count ? "[$count]" : "") . " " . $date, 49, " ", STR_PAD_RIGHT) . $RES . $Y . " ⫸\n" . $RES;
    
    foreach ($result as $key => $value) {
        if ($key == 'status') {
            if ($value == 'SUCCESS') {
                echo $C . " # " . $G . str_pad(strtoupper($key), 20, " ", STR_PAD_LEFT) . " " . $Y . " : " . $G . $value . $RES . "\n";
            } else {
                echo $C . " # " . $G . str_pad(strtoupper($key), 20, " ", STR_PAD_LEFT) . " " . $Y . " : " . $M . $value . $RES . "\n";
            }
        } elseif ($key == 'message') {
            echo $C . " # " . $G . str_pad(strtoupper($key), 20, " ", STR_PAD_LEFT) . " " . $Y . " : " . $C . $value . $RES . "\n";
        } elseif ($key == 'reward' || $key == 'amount') {
            if (is_numeric($value)) {
                echo $C . " # " . $G . str_pad(strtoupper($key), 20, " ", STR_PAD_LEFT) . " " . $Y . " : " . $G . number_format((int)$value) . $RES . "\n";
            } else {
                echo $C . " # " . $G . str_pad(strtoupper($key), 20, " ", STR_PAD_LEFT) . " " . $Y . " : " . $C . $value . $RES . "\n";
            }
        } else {
            if (is_numeric($value)) {
                echo $C . " # " . $G . str_pad(strtoupper($key), 20, " ", STR_PAD_LEFT) . " " . $Y . " : " . $G . number_format((int)$value) . $RES . "\n";
            } else {
                echo $C . " # " . $G . str_pad(strtoupper($key), 20, " ", STR_PAD_LEFT) . " " . $Y . " : " . $C . $value . $RES . "\n";
            }
        }
    }
    echo "\n";
    echo $C . str_repeat("━", 50) . "\n" . $RES;
}

function banner() {
    global $M, $G, $Y, $C, $RES;
    clear_screen();
    $waktu = date("H:i:s | d-m-Y");
// Banner dengan Heredoc (CARA PALING AMAN)
$banner = '
                 ██████╗ ███████╗██╗   ██╗
                 ██╔══██╗██╔════╝╚██╗ ██╔╝
                 ██║  ██║█████╗   ╚████╔╝ 
                 ██║  ██║██╔══╝    ╚██╔╝  
                 ██████╔╝███████╗   ██║   
                 ╚═════╝ ╚══════╝   ╚═╝   
                      
                      ███████╗██╗   ██╗██████╗ 
                      ██╔════╝██║   ██║██╔══██╗
                      █████╗  ██║   ██║██████╔╝
                      ██╔══╝  ██║   ██║██╔══██╗
                      ██║     ╚██████╔╝██║  ██║
                      ╚═╝      ╚═════╝ ╚═╝  ╚═╝

            CRYPTO HARVEST AUTO FARMING BOT
════════════════════════════════════════════════════════════════════
Created By : DEV.FUR
WA GROUP  : https://chat.whatsapp.com/BMXzHOEYdy6AardVjevCX7
Time       : ' . $waktu . '
════════════════════════════════════════════════════════════════════
';

// Tampilkan banner
echo $banner;

}

function show_menu() {
    global $G, $Y, $C, $RES;
    echo "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "                         MAIN MENU" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $Y . "  1. " . $G . "START AUTO FARMING" . $RES . "\n";
    echo $Y . "  2. " . $G . "CONFIGURATION" . $RES . "\n";
    echo $Y . "  3. " . $G . "CHECK BALANCE" . $RES . "\n";
    echo $Y . "  4. " . $G . "WITHDRAW" . $RES . "\n";
    echo $Y . "  5. " . $G . "EXIT" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "  Choose option: " . $RES;
}

function show_config_menu() {
    global $G, $Y, $C, $RES;
    clear_screen();
    banner();
    echo "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "                        CONFIGURATION" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $Y . "  1. " . $G . "Set Email" . $RES . "\n";
    echo $Y . "  2. " . $G . "Set Proxy" . $RES . "\n";
    echo $Y . "  3. " . $G . "Set Target Withdraw" . $RES . "\n";
    echo $Y . "  4. " . $G . "Task Settings (On/Off)" . $RES . "\n";
    echo $Y . "  5. " . $G . "Advanced Settings" . $RES . "\n";
    echo $Y . "  6. " . $G . "BACK" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "  Choose option: " . $RES;
}

function show_task_menu(&$tasks) {
    global $G, $Y, $C, $RES, $M;
    clear_screen();
    banner();
    echo "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "                      TASK SETTINGS" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    $i = 1;
    foreach ($tasks as $task => $status) {
        $status_text = ($status == 'on') ? $G . "ON" . $RES : $M . "OFF" . $RES;
        $task_name = str_replace('_', ' ', ucfirst($task));
        echo $Y . "  " . $i . ". " . $G . str_pad($task_name, 20) . " : " . $status_text . $RES . "\n";
        $i++;
    }
    echo $Y . "  " . $i . ". " . $G . "SAVE & BACK" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "  Choose option: " . $RES;
    
    $choice = trim(fgets(STDIN));
    if (is_numeric($choice) && $choice >= 1 && $choice <= count($tasks)) {
        $task_keys = array_keys($tasks);
        $selected_task = $task_keys[$choice - 1];
        $tasks[$selected_task] = ($tasks[$selected_task] == 'on') ? 'off' : 'on';
        show_task_menu($tasks);
    } elseif ($choice == count($tasks) + 1) {
        save_config('tasks', $tasks);
        return;
    } else {
        show_task_menu($tasks);
    }
}

function show_advanced_menu(&$settings) {
    global $G, $Y, $C, $RES;
    clear_screen();
    banner();
    echo "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "                    ADVANCED SETTINGS" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $Y . "  1. " . $G . "Claim Check Timer      : " . $Y . $settings['claim_check_timer'] . $RES . "\n";
    echo $Y . "  2. " . $G . "Keep Active Timer      : " . $Y . $settings['keep_active_timer'] . $RES . "\n";
    echo $Y . "  3. " . $G . "Sleep Timer            : " . $Y . $settings['sleep_timer'] . $RES . "\n";
    echo $Y . "  4. " . $G . "Success Before Sleep   : " . $Y . $settings['success_task_before_sleep'] . $RES . "\n";
    echo $Y . "  5. " . $G . "BACK" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "  Choose option: " . $RES;
    
    $choice = trim(fgets(STDIN));
    switch($choice) {
        case '1':
            echo $C . "  Enter claim check timer (e.g., 1 hour, 30 minutes): " . $RES;
            $settings['claim_check_timer'] = trim(fgets(STDIN));
            break;
        case '2':
            echo $C . "  Enter keep active timer (e.g., 30 minutes, 1 hour): " . $RES;
            $settings['keep_active_timer'] = trim(fgets(STDIN));
            break;
        case '3':
            echo $C . "  Enter sleep timer (e.g., 30 minutes, 1 hour, off): " . $RES;
            $settings['sleep_timer'] = trim(fgets(STDIN));
            break;
        case '4':
            echo $C . "  Enter range (e.g., 20~25): " . $RES;
            $settings['success_task_before_sleep'] = trim(fgets(STDIN));
            break;
        case '5':
            save_config('settings', $settings);
            return;
    }
    save_config('settings', $settings);
    show_advanced_menu($settings);
}

function save_config($key, $data) {
    $config_file = 'crypto_config.json';
    $config = [];
    if (file_exists($config_file)) {
        $config = json_decode(file_get_contents($config_file), true);
    }
    $config[$key] = $data;
    file_put_contents($config_file, json_encode($config, JSON_PRETTY_PRINT));
}

function load_config() {
    $config_file = 'crypto_config.json';
    $default_config = [
        'email' => '',
        'proxy' => '',
        'target_withdraw' => 1000000,
        'tasks' => [
            'daily_streak' => 'on',
            'extra_faucet' => 'on',
            'hourly_faucet' => 'on',
            'spin_faucet' => 'on',
            'bonus_faucet' => 'on',
            'lucky_box' => 'on',
            'diamond_hunt' => 'on'
        ],
        'settings' => [
            'claim_check_timer' => '1 hour',
            'keep_active_timer' => '30 minutes',
            'sleep_timer' => 'off',
            'success_task_before_sleep' => '20~25'
        ]
    ];
    
    if (file_exists($config_file)) {
        $config = json_decode(file_get_contents($config_file), true);
        return array_merge($default_config, $config);
    }
    return $default_config;
}

// ==================== PROXY PARSE ====================
function parse_proxy($proxy_input) {
    if (empty($proxy_input)) return null;
    preg_match('/^(?<prot>\w+):\/\/(?:(?<user>[^:@]+):(?<pwd>[^@]+)@)?(?<ip>(?:\d{1,3}\.){3}\d{1,3}):(?<port>\d+)$/', $proxy_input, $match);
    if (!empty($match)) {
        return [
            'prot' => $match['prot'],
            'ip' => $match['ip'],
            'port' => $match['port'],
            'user' => $match['user'] ?? '',
            'pwd' => $match['pwd'] ?? ''
        ];
    }
    return null;
}

// ==================== CURL FUNCTION ====================
function curl_request($url, $headers = [], $method = "GET", $postfields = null, $proxy = null, $cookie = null, $follow = true) {
    global $UA;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $UA);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
    
    $default_headers = [
        "Accept: application/json, text/plain, */*",
        "Accept-Language: en-US,en;q=0.9",
        "X-Requested-With: crypto.harvest3"
    ];
    
    $all_headers = array_merge($default_headers, $headers);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $all_headers);
    
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    
    if ($proxy && !empty($proxy['ip']) && !empty($proxy['port'])) {
        curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'] . ":" . $proxy['port']);
        if (!empty($proxy['prot'])) {
            $protocols = ['http' => CURLPROXY_HTTP, 'https' => CURLPROXY_HTTPS, 'socks4' => CURLPROXY_SOCKS4, 'socks5' => CURLPROXY_SOCKS5];
            if (isset($protocols[strtolower($proxy['prot'])])) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, $protocols[strtolower($proxy['prot'])]);
            }
        }
        if (!empty($proxy['user']) && !empty($proxy['pwd'])) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['user'] . ":" . $proxy['pwd']);
        }
    }
    
    if ($method == "POST") {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($postfields) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }
    }
    
    $response = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers_out = substr($response, 0, $header_size);
    $body = substr($response, $header_size);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $referer = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    
    return ['code' => $code, 'referer' => $referer, 'headers' => $headers_out, 'body' => $body];
}

// ==================== COOKIE FUNCTION ====================
function cookie_set($cookie = null, $new_cookie = null) {
    $old_cookie = [];
    if (isset($cookie)) {
        preg_match_all('/([^;=\s]+)=([^;]*)/', $cookie, $match);
        $keys = @$match[1];
        $values = @$match[2];
        if (!empty($keys)) {
            $old_cookie = array_combine($keys, $values);
        }
    }
    if (!empty($new_cookie)) {
        $cookie = array_merge($old_cookie, (array)$new_cookie);
    } else {
        $cookie = $old_cookie;
    }
    return implode('; ', array_map(
        fn($i, $x) => trim($i) . "=" . trim($x),
        array_keys($cookie),
        $cookie
    ));
}

// ==================== LOGIN FUNCTION ====================
function do_login($email, $proxy, &$cookie) {
    // Step 1: Get login page
    $result = curl_request("https://grabltc.com/CryptoHarvest/index.php", [], "GET", null, $proxy, null, true);
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    // Step 2: Email validation
    $payload = http_build_query([
        'email' => $email,
        'action' => "EMAIL_CONFIRM_ACCEPTED"
    ]);
    
    $headers = [
        "Content-Type: application/x-www-form-urlencoded",
        "Origin: https://grabltc.com",
        "Referer: https://grabltc.com/CryptoHarvest/index.php"
    ];
    
    $result = curl_request("https://grabltc.com/CryptoHarvest/audit_accept.php", $headers, "POST", $payload, $proxy, $cookie, true);
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    if ($result['code'] != 200 || trim($result['body']) != "OK") {
        return false;
    }
    
    // Step 3: Login
    $payload = http_build_query([
        'email' => $email,
        'website' => "",
        'referral_code' => ""
    ]);
    
    $result = curl_request("https://grabltc.com/CryptoHarvest/login.php", $headers, "POST", $payload, $proxy, $cookie, false);
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    if ($result['code'] == 302) {
        preg_match('/Location:\s*([^\r\n]+)/i', $result['headers'], $loc_match);
        if (isset($loc_match[1])) {
            $result = curl_request(trim($loc_match[1]), [], "GET", null, $proxy, $cookie, true);
            preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
            if (!empty($matches[1])) {
                $new_cookie = array_combine($matches[1], $matches[2]);
                $cookie = cookie_set($cookie, $new_cookie);
            }
        }
        return true;
    }
    
    return false;
}

// ==================== GET BALANCE ====================
function get_balance($proxy, $cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/home.php", [], "GET", null, $proxy, $cookie, true);
    
    if ($result['code'] != 200) {
        return ['pts' => 0, 'level' => 0];
    }
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $GLOBALS['cookie'] = cookie_set($GLOBALS['cookie'], $new_cookie);
    }
    
    $pts = 0;
    $level = 0;
    
    if (preg_match('/<p[^>]*>Available\s*Balance<\/p>.*?<p[^>]*>\s*([\d,]+)\s*<\/p>/s', $result['body'], $match)) {
        $pts = (int)str_replace(',', '', $match[1]);
    }
    
    if (preg_match('/<span[^>]*>\s*Level\s*([\d,]+)\s*<\/span>/', $result['body'], $match)) {
        $level = (int)str_replace(',', '', $match[1]);
    }
    
    return ['pts' => $pts, 'level' => $level];
}

// ==================== ALL TASKS ====================

function task_daily_streak($proxy, &$cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/DailyBonus/dailybonus.php", [], "GET", null, $proxy, $cookie, true);
    if ($result['code'] != 200) return false;
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    if (!preg_match('/<button\s*id="claimBtn"[^>]*>/', $result['body'])) {
        return false;
    }
    
    $headers = ["Referer: " . $result['referer']];
    $result = curl_request("https://grabltc.com/CryptoHarvest/DailyBonus/process_daily.php", $headers, "GET", null, $proxy, $cookie, true);
    
    $json = json_decode($result['body'], true);
    if ($result['code'] == 200 && isset($json['status']) && $json['status'] == 'success') {
        return ['reward' => isset($json['reward']) ? (int)$json['reward'] : 0];
    }
    return false;
}

function task_extra_faucet($proxy, &$cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/ExtraFaucet/extrafaucet.php", [], "GET", null, $proxy, $cookie, true);
    if ($result['code'] != 200) return false;
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    $headers = ["Referer: " . $result['referer']];
    $result = curl_request("https://grabltc.com/CryptoHarvest/ExtraFaucet/extrafaucet_process.php", $headers, "GET", null, $proxy, $cookie, true);
    
    $json = json_decode($result['body'], true);
    if (isset($json['success']) && $json['success'] === true && isset($json['can_claim']) && $json['can_claim'] === true) {
        $headers = ["Referer: " . $result['referer'], "Origin: https://grabltc.com"];
        $result = curl_request("https://grabltc.com/CryptoHarvest/ExtraFaucet/extrafaucet_process.php", $headers, "POST", "", $proxy, $cookie, true);
        $json = json_decode($result['body'], true);
        if (isset($json['success']) && $json['success'] === true) {
            return ['reward' => isset($json['reward']) ? (int)$json['reward'] : 0];
        }
    }
    return false;
}

function task_hourly_faucet($proxy, &$cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/HourlyFaucet/hourlyfaucet.php", [], "GET", null, $proxy, $cookie, true);
    if ($result['code'] != 200) return false;
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    if (!preg_match('/<button\s*id="harvestBtn"[^>]*>/', $result['body'])) {
        return false;
    }
    
    $headers = ["Referer: " . $result['referer']];
    $result = curl_request("https://grabltc.com/CryptoHarvest/HourlyFaucet/process_hourly.php", $headers, "GET", null, $proxy, $cookie, true);
    
    $json = json_decode($result['body'], true);
    if ($result['code'] == 200 && isset($json['status']) && $json['status'] == 'success') {
        return ['reward' => isset($json['total_reward']) ? (int)$json['total_reward'] : 0];
    }
    return false;
}

function task_spin_faucet($proxy, &$cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/SpinFaucet/spinfaucet.php", [], "GET", null, $proxy, $cookie, true);
    if ($result['code'] != 200) return false;
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    preg_match('/<div\s*[^>]*>(\d+)<\/div>\s*<div[^>]*>Spins\s*Left<\/div>/', $result['body'], $match);
    $spins_left = isset($match[1]) ? (int)$match[1] : 0;
    
    if ($spins_left <= 0) return false;
    
    $headers = ["Referer: " . $result['referer']];
    $result = curl_request("https://grabltc.com/CryptoHarvest/SpinFaucet/spinfaucet_backend.php", $headers, "GET", null, $proxy, $cookie, true);
    
    $json = json_decode($result['body'], true);
    if (isset($json['status']) && $json['status'] == 'success' && isset($json['spin_token'])) {
        $token = $json['spin_token'];
        sleep(2);
        
        $headers = ["Referer: " . $result['referer'], "Origin: https://grabltc.com", "Content-Type: application/json"];
        $payload = json_encode(['spin_token' => $token]);
        $result = curl_request("https://grabltc.com/CryptoHarvest/SpinFaucet/spinfaucet_backend.php", $headers, "POST", $payload, $proxy, $cookie, true);
        
        $json = json_decode($result['body'], true);
        $status = $json['status'] ?? $json['success'] ?? false;
        
        if ($status == 'success' || $status === true) {
            return ['reward' => isset($json['total_reward']) ? (int)$json['total_reward'] : 0];
        }
    }
    return false;
}

function task_bonus_faucet($proxy, &$cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/BonusFaucet/bonusfaucet.php", [], "GET", null, $proxy, $cookie, true);
    if ($result['code'] != 200) return false;
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    if (!preg_match('/<button\s*id="claimBtn"[^>]*>/', $result['body'])) {
        return false;
    }
    
    $headers = ["Referer: " . $result['referer']];
    $result = curl_request("https://grabltc.com/CryptoHarvest/BonusFaucet/process_bonus.php", $headers, "GET", null, $proxy, $cookie, true);
    
    $json = json_decode($result['body'], true);
    if ($result['code'] == 200 && isset($json['status']) && $json['status'] == 'success') {
        return ['reward' => isset($json['total_reward']) ? (int)$json['total_reward'] : 0];
    }
    return false;
}

function task_lucky_box($proxy, &$cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/Game/game.php", [], "GET", null, $proxy, $cookie, true);
    if ($result['code'] != 200) return false;
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    $session_id = "session_" . substr(bin2hex(random_bytes(5)), 0, 9);
    $total_reward = 0;
    $opened = [];
    
    for ($i = 1; $i <= 20; $i++) {
        $available = array_diff(range(1, 20), $opened);
        if (empty($available)) break;
        
        $box_id = $available[array_rand($available)];
        $opened[] = $box_id;
        
        $payload = http_build_query([
            'action' => 'open_box',
            'box_id' => $box_id,
            'session_id' => $session_id
        ]);
        
        $headers = ["Content-Type: application/x-www-form-urlencoded", "Referer: " . $result['referer']];
        $result_req = curl_request("https://grabltc.com/CryptoHarvest/Game/game_process.php", $headers, "POST", $payload, $proxy, $cookie, true);
        
        $json = json_decode($result_req['body'], true);
        if ($result_req['code'] == 200 && isset($json['reward_amount'])) {
            $total_reward += (int)$json['reward_amount'];
            $attempts_left = isset($json['attempts_left']) ? (int)$json['attempts_left'] : 0;
            if ($attempts_left <= 0) break;
        }
        sleep(1);
    }
    
    if ($total_reward > 0) {
        $payload = http_build_query([
            'action' => 'claim_rewards',
            'session_id' => $session_id,
            'total_earnings' => $total_reward
        ]);
        $headers = ["Content-Type: application/x-www-form-urlencoded", "Referer: " . $result['referer']];
        curl_request("https://grabltc.com/CryptoHarvest/Game/game_process.php", $headers, "POST", $payload, $proxy, $cookie, true);
        return ['reward' => $total_reward];
    }
    return false;
}

function task_diamond_hunt($proxy, &$cookie) {
    $result = curl_request("https://grabltc.com/CryptoHarvest/Game/diamond_hunt.php", [], "GET", null, $proxy, $cookie, true);
    if ($result['code'] != 200) return false;
    
    preg_match_all('/^set-cookie:\s*([^=]+)=([^;]+)/im', $result['headers'], $matches);
    if (!empty($matches[1])) {
        $new_cookie = array_combine($matches[1], $matches[2]);
        $cookie = cookie_set($cookie, $new_cookie);
    }
    
    preg_match('/const\s*BOMB_INDICES\s*=\s*(.*?);/', $result['body'], $match);
    $bombs = isset($match[1]) ? json_decode($match[1], true) : [];
    
    $tiles = [];
    for ($i = 0; $i < 15 - count($bombs); $i++) {
        $available = array_diff(range(0, 15), $tiles, $bombs);
        if (empty($available)) break;
        
        $index = $available[array_rand($available)];
        $tiles[] = $index;
        
        $payload = http_build_query(['index' => $index]);
        $headers = ["Content-Type: application/x-www-form-urlencoded", "Referer: " . $result['referer'], "Origin: https://grabltc.com"];
        curl_request("https://grabltc.com/CryptoHarvest/Game/diamond_process.php", $headers, "POST", $payload, $proxy, $cookie, true);
        sleep(1);
    }
    
    $result = curl_request("https://grabltc.com/CryptoHarvest/Game/diamond_process.php?action=cashout", [], "GET", null, $proxy, $cookie, true);
    $json = json_decode($result['body'], true);
    
    if (isset($json['status']) && $json['status'] == 'cashed_out') {
        return ['reward' => isset($json['amount']) ? (int)$json['amount'] : 0];
    }
    return false;
}

// ==================== CHECK BALANCE ====================
function check_balance() {
    global $G, $Y, $C, $RES, $config;
    
    banner();
    
    if (empty($config['email'])) {
        typing("EMAIL NOT CONFIGURED", $M);
        echo $C . "\nPress Enter to continue..." . $RES;
        fgets(STDIN);
        return;
    }
    
    $cookie = null;
    $proxy = parse_proxy($config['proxy']);
    
    typing("CONNECTING TO SERVER", $C);
    if (!do_login($config['email'], $proxy, $cookie)) {
        typing("LOGIN FAILED", $M);
        echo $C . "\nPress Enter to continue..." . $RES;
        fgets(STDIN);
        return;
    }
    
    typing("GETTING BALANCE", $C);
    $balance_data = get_balance($proxy, $cookie);
    
    echo "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "                         BALANCE INFO" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $G . "  Available Balance: " . $Y . number_format($balance_data['pts']) . $G . " pts" . $RES . "\n";
    echo $G . "  Level: " . $Y . $balance_data['level'] . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "\nPress Enter to continue..." . $RES;
    fgets(STDIN);
}

// ==================== WITHDRAW - FIXED ====================
function do_withdraw($amount, $proxy, $cookie) {
    $headers = [
        "Content-Type: application/x-www-form-urlencoded",
        "Origin: https://grabltc.com",
        "X-Requested-With: crypto.harvest3"
    ];
    
    $payload = http_build_query([
        'amount_pts' => (string)$amount,
        'currency_id' => '4'
    ]);
    
    $result = curl_request("https://grabltc.com/CryptoHarvest/Withdrawal/process_withdraw.php", $headers, "POST", $payload, $proxy, $cookie, true);
    
    // Debug response
    $json = json_decode($result['body'], true);
    
    // If JSON decode failed, try to extract from HTML response
    if ($json === null) {
        // Try to parse message from HTML
        if (preg_match('/<div[^>]*class="[^"]*success[^"]*"[^>]*>([^<]+)<\/div>/i', $result['body'], $match)) {
            return ['status' => 'error', 'message' => trim($match[1])];
        }
        if (preg_match('/<div[^>]*class="[^"]*alert[^"]*"[^>]*>([^<]+)<\/div>/i', $result['body'], $match)) {
            return ['status' => 'error', 'message' => trim($match[1])];
        }
        if (preg_match('/<div[^>]*class="[^"]*message[^"]*"[^>]*>([^<]+)<\/div>/i', $result['body'], $match)) {
            return ['status' => 'error', 'message' => trim($match[1])];
        }
        return ['status' => 'error', 'message' => 'Unknown response from server'];
    }
    
    return $json;
}

// ==================== DASHBOARD ====================
function show_dashboard($balance, $total_earned, $success, $failed, $level, $proxy_info) {
    global $G, $Y, $C, $M, $RES;
    
    $info = [
        "script" => "CRYPTO HARVEST",
        "config" => "DEFAULT",
        "proxy" => $proxy_info ?: "OFF"
    ];
    
    $account = [
        "pts" => number_format($balance),
        "level" => $level,
        "earned" => number_format($total_earned),
        "success" => $success,
        "failed" => $failed
    ];
    
    $content = array_merge($info, $account);
    $long = 20;
    
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    foreach ($content as $index => $value) {
        echo $C . "  ๏ " . $G . str_pad("〔 " . strtoupper($index) . " 〕", $long + 8, ".", STR_PAD_RIGHT) . ". : " . $Y . $value . $RES . "\n";
    }
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
}

// ==================== FARMING LOOP ====================
function start_farming($config) {
    global $G, $Y, $C, $M, $RES, $cookie;
    
    banner();
    
    $email = $config['email'];
    $proxy_input = $config['proxy'];
    $target_withdraw = $config['target_withdraw'];
    $tasks = $config['tasks'];
    $settings = $config['settings'];
    
    if (empty($email)) {
        typing("EMAIL NOT CONFIGURED", $M);
        echo $C . "\nPress Enter to continue..." . $RES;
        fgets(STDIN);
        return;
    }
    
    $proxy = parse_proxy($proxy_input);
    $cookie = null;
    $success_count = 0;
    $failed_count = 0;
    $total_earned = 0;
    $cycle = 0;
    
    // Parse success task before sleep
    preg_match('/(\d+)~(\d+)/', $settings['success_task_before_sleep'], $match);
    $success_min = isset($match[1]) ? (int)$match[1] : 20;
    $success_max = isset($match[2]) ? (int)$match[2] : 25;
    $success_limit = rand($success_min, $success_max);
    
    $proxy_info = $proxy ? $proxy['ip'] . ":" . $proxy['port'] : null;
    
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $G . "STARTING CRYPTO HARVEST BOT..." . $RES . "\n";
    echo $G . "EMAIL: " . $Y . $email . $RES . "\n";
    echo $G . "PROXY: " . $Y . ($proxy_info ?: "OFF") . $RES . "\n";
    echo $G . "TARGET: " . $Y . number_format($target_withdraw) . $G . " POINTS" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n\n";
    
    typing("CONNECTING TO SERVER", $C);
    if (!do_login($email, $proxy, $cookie)) {
        typing("LOGIN FAILED", $M);
        echo $C . "\nPress Enter to continue..." . $RES;
        fgets(STDIN);
        return;
    }
    typing("LOGIN SUCCESS", $G);
    
    // Task execution order
    $task_order = ['daily_streak', 'extra_faucet', 'hourly_faucet', 'spin_faucet', 'bonus_faucet', 'lucky_box', 'diamond_hunt'];
    $task_names = [
        'daily_streak' => 'DAILY STREAK',
        'extra_faucet' => 'EXTRA FAUCET',
        'hourly_faucet' => 'HOURLY FAUCET',
        'spin_faucet' => 'SPIN FAUCET',
        'bonus_faucet' => 'BONUS FAUCET',
        'lucky_box' => 'LUCKY BOX',
        'diamond_hunt' => 'DIAMOND HUNT'
    ];
    
    while (true) {
        $cycle++;
        
        // Get current balance
        $balance_data = get_balance($proxy, $cookie);
        $current_balance = $balance_data['pts'];
        $level = $balance_data['level'];
        
        // Show dashboard
        show_dashboard($current_balance, $total_earned, $success_count, $failed_count, $level, $proxy_info);
        
        // Check target
        if ($current_balance >= $target_withdraw) {
            typing("TARGET ACHIEVED - PROCESSING WITHDRAWAL", $G);
            $wd_result = do_withdraw($target_withdraw, $proxy, $cookie);
            if ($wd_result && isset($wd_result['message'])) {
                show_result("WITHDRAWAL", [
                    'status' => 'SUCCESS',
                    'message' => $wd_result['message'],
                    'amount' => $target_withdraw
                ]);
                if (isset($wd_result['tx_hash'])) {
                    echo $C . " 🔗 TX HASH: " . $wd_result['tx_hash'] . $RES . "\n";
                }
            } else {
                show_result("WITHDRAWAL", ['status' => 'FAILED', 'message' => json_encode($wd_result)]);
            }
            echo $C . "\nPress Enter to continue..." . $RES;
            fgets(STDIN);
            return;
        }
        
        // Execute all tasks in one cycle
        $task_count = 0;
        foreach ($task_order as $task) {
            if ($tasks[$task] == 'on') {
                $task_count++;
                $result = null;
                
                switch ($task) {
                    case 'daily_streak':
                        $result = task_daily_streak($proxy, $cookie);
                        break;
                    case 'extra_faucet':
                        $result = task_extra_faucet($proxy, $cookie);
                        break;
                    case 'hourly_faucet':
                        $result = task_hourly_faucet($proxy, $cookie);
                        break;
                    case 'spin_faucet':
                        $result = task_spin_faucet($proxy, $cookie);
                        break;
                    case 'bonus_faucet':
                        $result = task_bonus_faucet($proxy, $cookie);
                        break;
                    case 'lucky_box':
                        $result = task_lucky_box($proxy, $cookie);
                        break;
                    case 'diamond_hunt':
                        $result = task_diamond_hunt($proxy, $cookie);
                        break;
                }
                
                if ($result !== false && isset($result['reward']) && $result['reward'] > 0) {
                    $success_count++;
                    $total_earned += $result['reward'];
                    show_result($task_names[$task], [
                        'status' => 'SUCCESS',
                        'reward' => $result['reward']
                    ]);
                } else {
                    $failed_count++;
                    show_result($task_names[$task], [
                        'status' => 'FAILED',
                        'reward' => 0
                    ]);
                }
            }
        }
        
        if ($task_count == 0) {
            typing("NO ACTIVE TASKS", $Y);
        }
        
        // Sleep between cycles
        echo $Y . "\n⏳ WAITING 15 SECONDS BEFORE NEXT CYCLE..." . $RES . "\n";
        for ($i = 15; $i > 0; $i--) {
            echo "\r   " . $C . "TIME REMAINING: " . $Y . $i . $C . " SECONDS    " . $RES;
            sleep(1);
        }
        echo "\r" . str_repeat(" ", 50) . "\r";
        
        // Long sleep if enabled
        if ($settings['sleep_timer'] != 'off' && $success_count >= $success_limit) {
            preg_match('/(\d+)/', $settings['sleep_timer'], $match);
            $sleep_minutes = isset($match[1]) ? (int)$match[1] : 30;
            $sleep_seconds = $sleep_minutes * 60;
            
            echo $Y . "\n😴 SLEEPING FOR " . $sleep_minutes . " MINUTES..." . $RES . "\n";
            for ($i = $sleep_seconds; $i > 0; $i--) {
                echo "\r   " . $C . "SLEEP REMAINING: " . $Y . gmdate("H:i:s", $i) . $C . "    " . $RES;
                sleep(1);
            }
            echo "\r" . str_repeat(" ", 50) . "\r";
            
            $success_count = 0;
            $success_limit = rand($success_min, $success_max);
        }
    }
}

// ==================== WITHDRAW FULL MENU ====================
function withdraw_full($config) {
    global $G, $Y, $C, $M, $RES;
    
    banner();
    
    if (empty($config['email'])) {
        typing("EMAIL NOT CONFIGURED", $M);
        echo $C . "\nPress Enter to continue..." . $RES;
        fgets(STDIN);
        return;
    }
    
    $cookie = null;
    $proxy = parse_proxy($config['proxy']);
    
    typing("CONNECTING TO SERVER", $C);
    if (!do_login($config['email'], $proxy, $cookie)) {
        typing("LOGIN FAILED", $M);
        echo $C . "\nPress Enter to continue..." . $RES;
        fgets(STDIN);
        return;
    }
    
    $balance_data = get_balance($proxy, $cookie);
    $current_balance = $balance_data['pts'];
    
    echo "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "                         WITHDRAWAL" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $G . "  CURRENT BALANCE: " . $Y . number_format($current_balance) . $G . " PTS" . $RES . "\n";
    echo $G . "  TARGET: " . $Y . number_format($config['target_withdraw']) . $G . " PTS" . $RES . "\n";
    echo $G . "════════════════════════════════════════════════════════════════════" . $RES . "\n";
    echo $C . "\n  ENTER AMOUNT TO WITHDRAW (MAX: " . number_format($current_balance) . "):" . $RES . "\n";
    echo $Y . "  [1] WITHDRAW FULL BALANCE" . $RES . "\n";
    echo $Y . "  [2] WITHDRAW TARGET AMOUNT (" . number_format($config['target_withdraw']) . ")" . $RES . "\n";
    echo $Y . "  [3] CUSTOM AMOUNT" . $RES . "\n";
    echo $C . "\n  Choose option (1-3): " . $RES;
    
    $option = trim(fgets(STDIN));
    $amount = 0;
    
    switch($option) {
        case '1':
            $amount = $current_balance;
            break;
        case '2':
            $amount = $config['target_withdraw'];
            if ($amount > $current_balance) {
                typing("INSUFFICIENT BALANCE FOR TARGET AMOUNT", $M);
                echo $C . "\nPress Enter to continue..." . $RES;
                fgets(STDIN);
                return;
            }
            break;
        case '3':
            echo $C . "\n  ENTER CUSTOM AMOUNT: " . $RES;
            $amount = trim(fgets(STDIN));
            if (!is_numeric($amount) || $amount <= 0) {
                typing("INVALID AMOUNT", $M);
                echo $C . "\nPress Enter to continue..." . $RES;
                fgets(STDIN);
                return;
            }
            $amount = (int)$amount;
            break;
        default:
            typing("INVALID OPTION", $M);
            echo $C . "\nPress Enter to continue..." . $RES;
            fgets(STDIN);
            return;
    }
    
    if ($amount > $current_balance) {
        typing("INSUFFICIENT BALANCE", $M);
        echo $C . "\nPress Enter to continue..." . $RES;
        fgets(STDIN);
        return;
    }
    
    if ($amount < 1000000 && $current_balance > 1000000) {
        echo $Y . "\n  ⚠️ Minimum withdrawal is 1,000,000 points!" . $RES . "\n";
        echo $C . "  Press Enter to continue or Ctrl+C to cancel..." . $RES;
        fgets(STDIN);
        if ($amount < 1000000) {
            typing("WITHDRAWAL CANCELLED - AMOUNT TOO LOW", $M);
            echo $C . "\nPress Enter to continue..." . $RES;
            fgets(STDIN);
            return;
        }
    }
    
    typing("PROCESSING WITHDRAWAL OF " . number_format($amount) . " POINTS", $C);
    
    $result = do_withdraw($amount, $proxy, $cookie);
    
    echo "\n";
    if ($result && isset($result['message'])) {
        show_result("WITHDRAWAL", [
            'status' => 'SUCCESS',
            'message' => $result['message'],
            'amount' => $amount
        ]);
        if (isset($result['tx_hash'])) {
            echo $C . "  🔗 TX HASH: " . $result['tx_hash'] . $RES . "\n";
        }
        if (isset($result['balance'])) {
            echo $C . "  💰 REMAINING BALANCE: " . $G . number_format($result['balance']) . $RES . "\n";
        }
    } else {
        $error_msg = is_array($result) ? ($result['message'] ?? json_encode($result)) : "Unknown error";
        show_result("WITHDRAWAL", [
            'status' => 'FAILED',
            'message' => $error_msg
        ]);
    }
    
    echo $C . "\nPress Enter to continue..." . $RES;
    fgets(STDIN);
}

// ==================== MAIN PROGRAM ====================
$config = load_config();

while (true) {
    banner();
    show_menu();
    $choice = trim(fgets(STDIN));
    
    switch($choice) {
        case '1':
            start_farming($config);
            break;
        case '2':
            while (true) {
                show_config_menu();
                $sub_choice = trim(fgets(STDIN));
                switch($sub_choice) {
                    case '1':
                        echo $C . "  ENTER FAUCETPAY EMAIL: " . $RES;
                        $config['email'] = trim(fgets(STDIN));
                        save_config('email', $config['email']);
                        typing("EMAIL SAVED", $G);
                        sleep(1);
                        break;
                    case '2':
                        echo $C . "  ENTER PROXY (FORMAT: PROTOCOL://IP:PORT OR PROTOCOL://USER:PASS@IP:PORT): " . $RES;
                        echo $Y . "  EXAMPLE: HTTP://127.0.0.1:8080 OR HTTP://USER:PASS@127.0.0.1:8080" . $RES . "\n";
                        echo $C . "  LEAVE EMPTY FOR NO PROXY: " . $RES;
                        $config['proxy'] = trim(fgets(STDIN));
                        save_config('proxy', $config['proxy']);
                        typing("PROXY SAVED", $G);
                        sleep(1);
                        break;
                    case '3':
                        echo $C . "  ENTER TARGET POINTS TO WITHDRAW (MIN 1000000): " . $RES;
                        $input = trim(fgets(STDIN));
                        if (is_numeric($input) && $input > 0) {
                            $config['target_withdraw'] = (int)$input;
                            save_config('target_withdraw', $config['target_withdraw']);
                            typing("TARGET SAVED", $G);
                        } else {
                            typing("INVALID INPUT", $M);
                        }
                        sleep(1);
                        break;
                    case '4':
                        show_task_menu($config['tasks']);
                        break;
                    case '5':
                        show_advanced_menu($config['settings']);
                        break;
                    case '6':
                        break 2;
                    default:
                        typing("INVALID OPTION", $M);
                        sleep(1);
                }
            }
            break;
        case '3':
            check_balance();
            break;
        case '4':
            withdraw_full($config);
            break;
        case '5':
            typing("GOODBYE!", $G);
            exit(0);
        default:
            typing("INVALID OPTION", $M);
            sleep(1);
    }
}
?>