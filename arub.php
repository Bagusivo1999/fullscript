<?php
error_reporting(0);

function curl($url, $post = 0, $httpheader = 0, $proxy = 0) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($httpheader) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    }
    if ($proxy) {
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if (!$httpcode) return "Curl Error: " . curl_error($ch); else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);
        return array($header, $body);
    }
}

function get($url) {
    return curl($url, null, head())[1];
}

function post($url, $data) {
    return curl($url, $data, head())[1];
}

function clear() {
    if (stripos(PHP_OS, 'WIN') === 0) {
        pclose(popen('cls', 'w'));
    } else {
        passthru('clear');
    }
    $warna = ["\033[1;31m", "\033[1;33m", "\033[1;32m", "\033[1;36m", "\033[1;34m", "\033[1;35m"];
    
    echo $warna[0] . "╔══════════════════════════════════════════════════════════════════════╗\n";
    echo $warna[1] . "║                                                          ║\n";
    echo $warna[2] . "║     ███████╗██╗   ██╗██████╗ ██████╗                ║\n";
    echo $warna[3] . "║     ██╔════╝██║   ██║██╔══██╗██╔══██╗               ║\n";
    echo $warna[4] . "║     █████╗  ██║   ██║██████╔╝██████╔╝               ║\n";
    echo $warna[5] . "║     ██╔══╝  ██║   ██║██╔══██╗██╔══██╗               ║\n";
    echo $warna[0] . "║     ██║     ╚██████╔╝██║  ██║██║  ██║               ║\n";
    echo $warna[1] . "║     ╚═╝      ╚═════╝ ╚═╝  ╚═╝╚═╝  ╚═╝               ║\n";
    echo $warna[2] . "║                                                          ║\n";
    echo $warna[3] . "║              🔥  F U R R  T O O L S  🔥               ║\n";
    echo $warna[4] . "║                                                          ║\n";
    echo $warna[5] . "║           👤  DEV: FURR  👤                             ║\n";
    echo $warna[0] . "║           ⏰  " . date('d-m-Y H:i:s') . "  ⏰            ║\n";
    echo $warna[1] . "║                                                          ║\n";
    echo $warna[2] . "║           📊  STATUS: ONLINE  📊                         ║\n";
    echo $warna[3] . "║                                                          ║\n";
    echo $warna[4] . "║           💻  VERSION: 3.0.0  💻                         ║\n";
    echo $warna[5] . "║                                                          ║\n";
    echo $warna[0] . "╚══════════════════════════════════════════════════════════════════════╝\n";
    echo "\033[0m";
    echo "\n";
}

function slow($text, $delay = 30000) {
    ob_start();
    foreach (str_split($text) as $char) {
        echo $char;
    }
    ob_end_flush();
    echo "\r";
}

function timer($timer) {
    date_default_timezone_set('UTC');
    if (!$timer || !is_numeric($timer)) {
        $timer = 5;
    }
    $tim = time() + $timer;
    while (true) {
        echo "\r                                                        \r";
        $tm = $tim - time();
        if ($tm < 1) { break; }
        echo "Please Wait [" . date("H:i:s", $tm) . "]";
        sleep(1);
    }
}

function Save($namadata){
    if(file_exists($namadata)){
        $data = file_get_contents($namadata);
    }else{
        $data = readline("\nInput " . $namadata . ": ");
        file_put_contents($namadata, $data);
    }
    return $data;
}

$email = Save("Email");
$pass = Save("Password");
$api = Save("user-agent");

clear();

// Login
if(!file_exists("cookie.txt")){
login:
unlink("cookie.txt");
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://aruble.net',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_COOKIEJAR => 'cookie.txt',
    CURLOPT_COOKIEFILE => 'cookie.txt',
    CURLOPT_HTTPHEADER => [
        'User-Agent: ' . $api . '',
        'cache-control: max-age=0',
        'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Android WebView";v="146"',
        'sec-ch-ua-mobile: ?1',
        'sec-ch-ua-platform: "Android"',
        'upgrade-insecure-requests: 1',
        'x-requested-with: mark.via.gp',
        'sec-fetch-site: none',
        'sec-fetch-mode: navigate',
        'sec-fetch-user: ?1',
        'sec-fetch-dest: document',
        'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
        'priority: u=0, i',
    ],
]);

$res = curl_exec($curl);
$csrf = explode('">', explode('<meta name="csrf-token" content="', $res)[1])[0];

// GET CAPTCHA
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://aruble.net/captcha/challenge',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR => 'cookie.txt',
    CURLOPT_COOKIEFILE => 'cookie.txt',
    CURLOPT_HTTPHEADER => [
        'x-requested-with: mark.via.gp',
        'user-agent: ' . $api
    ],
]);

$res = curl_exec($curl);
$data = json_decode($res, true);
$key = $data['key'];
$type = $data['type'];
$answer = "";

if ($type == "least_repeat") {
    $icons = [];
    foreach ($data['grid'] as $item) {
        $icons[$item['icon']][] = $item['id'];
    }
    asort($icons);
    $answer = $icons[array_key_first($icons)][0];
} elseif ($type == "slide") {
    $target = $data['target_pct'];
    $answer = $target + rand(2,5);
} elseif ($type == "icon_order") {
    $map = [];
    foreach ($data['display'] as $item) {
        $map[$item['icon']] = $item['id'];
    }
    $answerArr = [];
    foreach ($data['prompt'] as $icon) {
        $answerArr[] = $map[$icon];
    }
    $answer = json_encode($answerArr);
}

slow("answer $answer\r");

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://aruble.net/captcha/verify',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => "key=$key&answer=$answer&_csrf_token=$csrf",
    CURLOPT_COOKIEJAR => 'cookie.txt',
    CURLOPT_COOKIEFILE => 'cookie.txt',
]);
$response = curl_exec($curl);
$data = json_decode($response, true);

if (isset($data['success']) && $data['success']) {
    $token = $data['token'];
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/api/auth/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "_csrf_token=$csrf&email=$email&password=$pass&captcha_token=$token&remember_me=1&device_fingerprint=0d2be167b01027c02ec8e88326aaa91d26c20f1794b4c221d905fa603846c7c3",
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'User-Agent: ' . $api . '',
            'sec-ch-ua-platform: "Android"',
            'x-requested-with: mark.via.gp',
            'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Android WebView";v="146"',
            'content-type: application/x-www-form-urlencoded; charset=UTF-8',
            'sec-ch-ua-mobile: ?1',
            'origin: https://aruble.net',
            'sec-fetch-site: same-origin',
            'sec-fetch-mode: cors',
            'sec-fetch-dest: empty',
            'referer: https://aruble.net/',
            'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
            'priority: u=1, i',
        ],
    ]);
    $response = curl_exec($curl);
    $data = json_decode($response, true);
    if ($data && ($data['success'] ?? false)) {
        $message = $data['message'];
        slow("answer $message\r");
        sleep(5);
    }
}
}

// Daily Bonus
Daily:
while (true) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/daily-bonus',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);

    $res = curl_exec($curl);
    sleep(rand(2,5));

    $csrf = explode('">', explode('<meta name="csrf-token" content="', $res)[1])[0];
    $title = explode('</title>', explode('<title>', $res)[1])[0];
    
    if ($title == "Just a moment...") {
        slow("answer $title\r");
        sleep(300);
        continue;
    }

    if (stripos($res, '<title>Redirecting...</title>') !== false) {
        goto login;
    }

    if (preg_match('/globalCooldown\s*:\s*(\d+)/', $res, $m)) {
        $cooldown = $m[1];
        if ($cooldown > 0) {
            timer($cooldown + rand(5,15));
            continue;
        }
    }

    if (rand(1,10) == 3) {
        sleep(rand(5,15));
        continue;
    }

    if (strpos($res, 'Come Back Later') !== false) {
        goto faucet;
    }

    // Bot check signal
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/bot-check/signal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => [
            'mouse' => rand(8,25),
            'keyboard' => rand(0,4),
            'scroll' => rand(3,12),
            'touch' => rand(2,8),
            'elapsed' => rand(20000,80000),
            'mouse_linear' => rand(0,3),
            'direct_clicks' => rand(1,3),
            'integrity' => '',
            'path' => '/faucet',
        ],
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    curl_exec($curl);
    curl_close($curl);
    sleep(rand(2,6));

    // Get captcha
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/captcha/challenge',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    $res = curl_exec($curl);
    $data = json_decode($res, true);

    if ($data && ($data['banned'] ?? false)) {
        $seconds = $data['remaining_seconds'] + rand(5,20);
        timer($seconds);
        continue;
    }

    if (!$data || !isset($data['type'])) continue;

    $key = $data['key'];
    $type = $data['type'];
    $answer = "";

    if ($type == "least_repeat") {
        $icons = [];
        foreach ($data['grid'] as $item) {
            $icons[$item['icon']][] = $item['id'];
        }
        asort($icons);
        $answer = $icons[array_key_first($icons)][0];
    } elseif ($type == "slide") {
        $target = $data['target_pct'];
        $answer = $target + rand(2,5);
    } elseif ($type == "icon_order") {
        $map = [];
        foreach ($data['display'] as $item) {
            $map[$item['icon']] = $item['id'];
        }
        $answerArr = [];
        foreach ($data['prompt'] as $icon) {
            $answerArr[] = $map[$icon];
        }
        $answer = json_encode($answerArr);
    }
    slow("answer $answer\r");

    // Verify captcha
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/captcha/verify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "key=$key&answer=$answer&_csrf_token=$csrf",
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    $response = curl_exec($curl);
    $data = json_decode($response, true);

    if ($data['expired'] ?? false) {
        // goto login;
    }

    if (isset($data['success']) && $data['success']) {
        $token = $data['token'];

        // Daily claim
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://aruble.net/daily-bonus/claim',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "captcha_token=$token&_csrf_token=$csrf",
            CURLOPT_COOKIEJAR => 'cookie.txt',
            CURLOPT_COOKIEFILE => 'cookie.txt',
            CURLOPT_HTTPHEADER => [
                'User-Agent: ' . $api . '',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'sec-ch-ua-platform: "Android"',
                'x-requested-with: mark.via.gp',
                'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Android WebView";v="146"',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'sec-ch-ua-mobile: ?1',
                'origin: https://aruble.net',
                'sec-fetch-site: same-origin',
                'sec-fetch-mode: cors',
                'sec-fetch-dest: empty',
                'referer: https://aruble.net/faucet',
                'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
                'priority: u=1, i',
            ],
        ]);

        $res = curl_exec($curl);
        $data = json_decode($res, true);

        if (isset($data['message']) && $data['message'] === "Invalid session. Please go back and try again.") {
            goto login;
        }
        if (isset($data['message']) && $data['message'] === "Please login") {
            sleep(300);
            continue;
        }
        if ($data && ($data['success'] ?? false)) {
            $amount = $data['amount'];
            $streak = $data['streak'];
            $balance = $data['balance_after'];
            $nextReward = $data['next_reward'];
            $symbol = $data['symbol'];
            $icon = $data['icon'];

            date_default_timezone_set('Asia/Kolkata');
            slow("⏰ " . date("h:i:s A") . " | 🎁 Daily Bonus Claimed | {$icon} +{$amount} {$symbol} | 🔥 Streak {$streak} | 💰 {$balance} | 🎯 Next {$nextReward} {$symbol}\n");
        }
    }
}

// Faucet
faucet:
while (true) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/faucet',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);

    $res = curl_exec($curl);
    sleep(rand(2,5));

    $csrf = explode('">', explode('<meta name="csrf-token" content="', $res)[1])[0];
    $title = explode('</title>', explode('<title>', $res)[1])[0];
    
    if ($title == "Just a moment...") {
        slow("answer $title\r");
        sleep(300);
        continue;
    }

    if (stripos($res, '<title>Redirecting...</title>') !== false) {
        goto login;
    }

    if (preg_match('/globalCooldown\s*:\s*(\d+)/', $res, $m)) {
        $cooldown = $m[1];
        if ($cooldown > 0) {
            timer($cooldown + rand(5,15));
            continue;
        }
    }

    if (rand(1,10) == 3) {
        sleep(rand(5,15));
        continue;
    }

    // Bot check signal
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/bot-check/signal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => [
            'mouse' => rand(8,25),
            'keyboard' => rand(0,4),
            'scroll' => rand(3,12),
            'touch' => rand(2,8),
            'elapsed' => rand(20000,80000),
            'mouse_linear' => rand(0,3),
            'direct_clicks' => rand(1,3),
            'integrity' => '',
            'path' => '/faucet',
        ],
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    curl_exec($curl);
    curl_close($curl);
    sleep(rand(2,6));

    // Get captcha
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/captcha/challenge',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    $res = curl_exec($curl);
    $data = json_decode($res, true);

    if ($data && ($data['banned'] ?? false)) {
        $seconds = $data['remaining_seconds'] + rand(5,20);
        timer($seconds);
        continue;
    }

    if (!$data || !isset($data['type'])) continue;

    $key = $data['key'];
    $type = $data['type'];
    $answer = "";

    if ($type == "least_repeat") {
        $icons = [];
        foreach ($data['grid'] as $item) {
            $icons[$item['icon']][] = $item['id'];
        }
        asort($icons);
        $answer = $icons[array_key_first($icons)][0];
    } elseif ($type == "slide") {
        $target = $data['target_pct'];
        $answer = $target + rand(2,5);
    } elseif ($type == "icon_order") {
        $map = [];
        foreach ($data['display'] as $item) {
            $map[$item['icon']] = $item['id'];
        }
        $answerArr = [];
        foreach ($data['prompt'] as $icon) {
            $answerArr[] = $map[$icon];
        }
        $answer = json_encode($answerArr);
    }
    slow("answer $answer\r");

    // Verify captcha
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/captcha/verify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "key=$key&answer=$answer&_csrf_token=$csrf",
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    $response = curl_exec($curl);
    $data = json_decode($response, true);

    if (isset($data['success']) && $data['success']) {
        $token = $data['token'];

        // Faucet claim
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://aruble.net/faucet/claim',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "dest=account&wc_id=0&captcha_token=$token&fp=0d2be167b01027c02ec8e88326aaa91d26c20f1794b4c221d905fa603846c7c3&_csrf_token=$csrf",
            CURLOPT_COOKIEJAR => 'cookie.txt',
            CURLOPT_COOKIEFILE => 'cookie.txt',
            CURLOPT_HTTPHEADER => [
                'User-Agent: ' . $api . '',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'sec-ch-ua-platform: "Android"',
                'x-requested-with: mark.via.gp',
                'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Android WebView";v="146"',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'sec-ch-ua-mobile: ?1',
                'origin: https://aruble.net',
                'sec-fetch-site: same-origin',
                'sec-fetch-mode: cors',
                'sec-fetch-dest: empty',
                'referer: https://aruble.net/faucet',
                'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
                'priority: u=1, i',
            ],
        ]);

        $res = curl_exec($curl);
        $data = json_decode($res, true);

        if ($data && ($data['success'] ?? false) === false) {
            $msg = $data['message'] ?? '';
            if (strpos($msg, 'daily limit') !== false) {
                goto auto;
            }
        }
        if (isset($data['message']) && $data['message'] === "Invalid session. Please go back and try again.") {
            goto login;
        }
        if (isset($data['message']) && $data['message'] === "Please login") {
            sleep(300);
            continue;
        }
        if ($data && ($data['success'] ?? false)) {
            $amount = $data['amount'];
            $symbol = $data['symbol'];
            $balance = $data['balance_after'];
            $next = $data['next_claim_in'];
            $min = floor($next / 60);
            $sec = $next % 60;
            date_default_timezone_set('Asia/Kolkata');
            slow("⏰ " . date("h:i:s A") . " | 🎁 {$amount} {$symbol} | 💰 {$balance} | 📊 {$data['claims_today']}/{$data['claims_max']} | ⏳ {$min}m {$sec}s\n");
            timer($next + rand(0,0));
        }
    }
}

// Auto
auto:
while (true) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/auto',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);

    $res = curl_exec($curl);
    sleep(rand(2,5));

    $csrf = explode('">', explode('<meta name="csrf-token" content="', $res)[1])[0];
    $statNext = explode('s</div>', explode('<div class="mining-stat-value" id="statNext">', $res)[1])[0];
    $title = explode('</title>', explode('<title>', $res)[1])[0];

    if ($title == "Just a moment...") {
        slow("answer $title\r");
        sleep(300);
        continue;
    }

    if (stripos($res, '<title>Redirecting...</title>') !== false) {
        goto login;
    }

    if (preg_match('/globalCooldown\s*:\s*(\d+)/', $res, $m)) {
        $cooldown = $m[1];
        if ($cooldown > 0) {
            timer($cooldown + rand(5,15));
            continue;
        }
    }

    if (rand(1,10) == 3) {
        sleep(rand(5,15));
        continue;
    }

    preg_match('/currentEnergy\s*:\s*(\d+)/', $res, $energy);
    preg_match('/energyCost\s*:\s*(\d+)/', $res, $cost);
    $currentEnergy = $energy[1] ?? 0;
    $energyCost = $cost[1] ?? 10;

    if ($currentEnergy < $energyCost) {
        goto roll;
    }

    timer($statNext);

    // Bot check signal
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/bot-check/signal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => [
            'mouse' => rand(8,25),
            'keyboard' => rand(0,4),
            'scroll' => rand(3,12),
            'touch' => rand(2,8),
            'elapsed' => rand(20000,80000),
            'mouse_linear' => rand(0,3),
            'direct_clicks' => rand(1,3),
            'integrity' => '',
            'path' => '/faucet',
        ],
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    curl_exec($curl);
    curl_close($curl);
    sleep(rand(2,6));

    // Auto burn
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/auto/burn',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "_csrf_token=$csrf",
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'User-Agent: ' . $api . '',
            'Accept: application/json, text/javascript, */*; q=0.01',
            'sec-ch-ua-platform: "Android"',
            'x-requested-with: mark.via.gp',
            'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Android WebView";v="146"',
            'content-type: application/x-www-form-urlencoded; charset=UTF-8',
            'sec-ch-ua-mobile: ?1',
            'origin: https://aruble.net',
            'sec-fetch-site: same-origin',
            'sec-fetch-mode: cors',
            'sec-fetch-dest: empty',
            'referer: https://aruble.net/faucet',
            'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
            'priority: u=1, i',
        ],
    ]);

    $res = curl_exec($curl);
    $data = json_decode($res, true);

    if (isset($data['message']) && $data['message'] === "Invalid session. Please go back and try again.") {
        goto login;
    }
    if (isset($data['message']) && $data['message'] === "Please login") {
        sleep(300);
        continue;
    }
    if ($data && ($data['success'] ?? false)) {
        $earned = $data['coins_earned'];
        $spent = $data['energy_spent'];
        $energy = $data['energy_after'];
        $balance = $data['balance_after'];
        $multiplier = $data['multiplier'];
        $bonus = $data['bonus_pct'];
        $symbol = $data['coin_symbol'];
        $icon = $data['coin_icon'];
        date_default_timezone_set('Asia/Kolkata');
        slow("⏰ " . date("h:i:s A") . " | ⛏️ -{$spent}⚡ | {$icon} +{$earned} {$symbol} | 💰 {$balance} | ⚡ {$energy} | 📈 x{$multiplier} | 🎁 {$bonus}%\n");
    }
}

// Roll Win
roll:
while (true) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/bonus-roll',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);

    $res = curl_exec($curl);
    sleep(rand(2,5));

    $csrf = explode('">', explode('<meta name="csrf-token" content="', $res)[1])[0];
    $title = explode('</title>', explode('<title>', $res)[1])[0];

    if ($title == "Just a moment...") {
        slow("answer $title\r");
        sleep(300);
        continue;
    }

    if (stripos($res, '<title>Redirecting...</title>') !== false) {
        goto login;
    }

    if (preg_match('/globalCooldown\s*:\s*(\d+)/', $res, $m)) {
        $cooldown = $m[1];
        if ($cooldown > 0) {
            timer($cooldown + rand(5,15));
            continue;
        }
    }

    if (rand(1,10) == 3) {
        sleep(rand(5,15));
        continue;
    }

    // Bot check signal
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/bot-check/signal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => [
            'mouse' => rand(8,25),
            'keyboard' => rand(0,4),
            'scroll' => rand(3,12),
            'touch' => rand(2,8),
            'elapsed' => rand(20000,80000),
            'mouse_linear' => rand(0,3),
            'direct_clicks' => rand(1,3),
            'integrity' => '',
            'path' => '/faucet',
        ],
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    curl_exec($curl);
    curl_close($curl);
    sleep(rand(2,6));

    // Get captcha
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/captcha/challenge',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    $res = curl_exec($curl);
    $data = json_decode($res, true);

    if ($data && ($data['banned'] ?? false)) {
        $seconds = $data['remaining_seconds'] + rand(5,20);
        timer($seconds);
        continue;
    }

    if (!$data || !isset($data['type'])) continue;

    $key = $data['key'];
    $type = $data['type'];
    $answer = "";

    if ($type == "least_repeat") {
        $icons = [];
        foreach ($data['grid'] as $item) {
            $icons[$item['icon']][] = $item['id'];
        }
        asort($icons);
        $answer = $icons[array_key_first($icons)][0];
    } elseif ($type == "slide") {
        $target = $data['target_pct'];
        $answer = $target + rand(2,5);
    } elseif ($type == "icon_order") {
        $map = [];
        foreach ($data['display'] as $item) {
            $map[$item['icon']] = $item['id'];
        }
        $answerArr = [];
        foreach ($data['prompt'] as $icon) {
            $answerArr[] = $map[$icon];
        }
        $answer = json_encode($answerArr);
    }
    slow("answer $answer\r");

    // Verify captcha
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://aruble.net/captcha/verify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "key=$key&answer=$answer&_csrf_token=$csrf",
        CURLOPT_COOKIEJAR => 'cookie.txt',
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            'x-requested-with: mark.via.gp',
            'User-Agent: ' . $api . '',
            'sec-ch-ua-full-version: "149.0.7827.197"',
        ],
    ]);
    $response = curl_exec($curl);
    $data = json_decode($response, true);

    if (isset($data['success']) && $data['success']) {
        $token = $data['token'];

        // Roll claim
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://aruble.net/bonus-roll/claim',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "captcha_token=$token&_csrf_token=$csrf",
            CURLOPT_COOKIEJAR => 'cookie.txt',
            CURLOPT_COOKIEFILE => 'cookie.txt',
            CURLOPT_HTTPHEADER => [
                'User-Agent: ' . $api . '',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'sec-ch-ua-platform: "Android"',
                'x-requested-with: mark.via.gp',
                'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Android WebView";v="146"',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'sec-ch-ua-mobile: ?1',
                'origin: https://aruble.net',
                'sec-fetch-site: same-origin',
                'sec-fetch-mode: cors',
                'sec-fetch-dest: empty',
                'referer: https://aruble.net/faucet',
                'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
                'priority: u=1, i',
            ],
        ]);

        $res = curl_exec($curl);
        $data = json_decode($res, true);

        if (isset($data['message']) && $data['message'] === "Invalid session. Please go back and try again.") {
            goto login;
        }
        if (isset($data['message']) && $data['message'] === "Please login") {
            sleep(300);
            continue;
        }
        if ($data && ($data['success'] ?? false)) {
            $drawn = $data['number_drawn'];
            $reward = $data['reward'];
            $label = strip_tags($data['label']);
            $balance = $data['new_token_balance'];
            $next = $data['next_roll_in'];
            $min = floor($next / 60);
            $sec = $next % 60;
            date_default_timezone_set('Asia/Kolkata');
            slow("⏰ " . date("h:i:s A") . " | 🎲 {$drawn} | 🏆 {$label} | ⚡ +{$reward} | 💰 {$balance} | ⏳ {$min}m {$sec}s\n");
            timer($next);
        }
    }
}
?>