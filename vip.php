<?php

#error_reporting(0);

function sock(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    sock();
// ===== FUNGSI CURL =====
function get($url, $cookie = '') {
    $ch = curl_init($url);
    $headers = [
        "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36",
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Referer: https://vipcoinfaucet.com/app/dashboard",
    ];
    if ($cookie) $headers[] = "Cookie: $cookie";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $res = curl_exec($ch);
    return $res;
}

function post($url, $data, $cookie = '') {
    $ch = curl_init($url);
    $headers = [
        "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36",
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Referer: https://vipcoinfaucet.com/app/dashboard",
        "Content-Type: application/x-www-form-urlencoded",
    ];
    if ($cookie) $headers[] = "Cookie: $cookie";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $res = curl_exec($ch);
    return $res;
}

// ===== AMBIL SEMUA COOKIE =====
function extract_all_cookies($response) {
    preg_match_all('/set-cookie: ([^;]+)/i', $response, $matches);
    return implode('; ', $matches[1]);
}

// ===== MAIN =====
$init_url = 'https://vipcoinfaucet.com/#tgWebAppData=query_id%3DAAGbw4FsAAAAAJvDgWyFIcMr%26user%3D%257B%2522id%2522%253A1820443547%252C%2522first_name%2522%253A%2522xusksjsj%2522%252C%2522last_name%2522%253A%2522%2522%252C%2522username%2522%253A%2522xusxxs%2522%252C%2522language_code%2522%253A%2522id%2522%252C%2522allows_write_to_pm%2522%253Atrue%252C%2522photo_url%2522%253A%2522https%253A%255C%252F%255C%252Ft.me%255C%252Fi%255C%252Fuserpic%255C%252F320%255C%252FkWbQbBG2giLMcu_zWEVH_2Jua5L-tHAQqBWoRrjpHH4.svg%2522%257D%26auth_date%3D1783616002%26signature%3DkhdTOz331uCEX_mUVKssYjaeSzLNsYBDtCllZfKcWguQ5jx3FgcdVLrvgDa82wn1ByGYCnuQDS-rtmOk6OCOCw%26hash%3Dcc88dbe9268310703d777a8c518c92d54909fc7fff70881e5bcef020b6ac476a&tgWebAppVersion=9.6&tgWebAppPlatform=android&tgWebAppThemeParams=%7B%22bg_color%22%3A%22%23212d3b%22%2C%22section_bg_color%22%3A%22%231d2733%22%2C%22secondary_bg_color%22%3A%22%23151e27%22%2C%22text_color%22%3A%22%23ffffff%22%2C%22hint_color%22%3A%22%237d8b99%22%2C%22link_color%22%3A%22%235eabe1%22%2C%22button_color%22%3A%22%23229af0%22%2C%22button_text_color%22%3A%22%23ffffff%22%2C%22header_bg_color%22%3A%22%23242d39%22%2C%22accent_text_color%22%3A%22%2364b5ef%22%2C%22section_header_text_color%22%3A%22%2379c4fc%22%2C%22subtitle_text_color%22%3A%22%237b8790%22%2C%22destructive_text_color%22%3A%22%23ee686f%22%2C%22section_separator_color%22%3A%22%230d1218%22%2C%22bottom_bar_bg_color%22%3A%22%23151e27%22%7D';

parse_str(parse_url($init_url, PHP_URL_FRAGMENT), $fragment);
$init = $fragment['tgWebAppData'] ?? '';

// 1. Login (dapatkan semua cookie)
$login_data = "tg_init_data=" . urlencode($init);
$login_res = post("https://vipcoinfaucet.com/app/auth/telegram_login", $login_data);
$cookie = extract_all_cookies($login_res);

echo "Cookie: $cookie\n";

// 2. Ambil halaman LTC
$ltc_res = get("https://vipcoinfaucet.com/faucet/currency/ltc", $cookie);
$ltc_html = substr($ltc_res, strpos($ltc_res, "\r\n\r\n") + 4);
file_put_contents("data.txt", $ltc_html);

// 3. Cek apakah login berhasil
if (strpos($ltc_html, 'Dashboard') === false && strpos($ltc_html, 'Faucet') === false) {
    die("Gagal login! Cek data.txt");
}

// 4. Ambil CSRF & claim_token
preg_match('/name="csrf_test_name" id="token" value="([^"]+)"/', $ltc_html, $matches);
$csrf = $matches[1] ?? '';
preg_match('/name="claim_token" value="([^"]+)"/', $ltc_html, $matches);
$claim_token = $matches[1] ?? '';

echo "CSRF: $csrf\nClaim: $claim_token\n";

if (!$csrf || !$claim_token) {
    die("Token tidak ditemukan!");
}

// 5. Kirim claim
$data = "csrf_test_name=$csrf&claim_token=$claim_token&tg_init_data=" . urlencode($init);
$claim_res = post("https://vipcoinfaucet.com/faucet/currency/ltc", $data, $cookie);
$claim_html = substr($claim_res, strpos($claim_res, "\r\n\r\n") + 4);
file_put_contents("data2.txt", $claim_html);

// 6. Ambil hasil LTC
preg_match('/([0-9.]+) LTC.*?Faucetpay/i', $claim_html, $matches);
$amount = $matches[1] ?? '0';

echo "Berhasil claim: $amount LTC\n";