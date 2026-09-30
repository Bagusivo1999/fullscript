<?php

#error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$configFile = "config.json";

const hitam  = "\033[0;30m";
const merah  = "\033[0;31m";
const hijau  = "\033[0;32m";
const kuning = "\033[0;33m";
const biru   = "\033[0;34m";
const cyan   = "\033[0;36m";
const putih  = "\033[0;37m";
const reset  = "\033[0m";

const api_url       = "https://coinfree.app/api.php";
const solver_in     = "https://api.waryono.my.id/in.php";
const solver_out    = "https://api.waryono.my.id/res.php";
const SITEKEY       = "0x4AAAAAAB6mAUIH75NUE5fq";
const SOLVE_DOMAIN  = "https://coinfree.app";
const MODES         = ["drop", "coinflip", "claw", "plinko", "target", "box", "card", "wheel"];
const DEFAULT_COIN  = "PEPE";

$HEADERS = [
    'content-type: application/json',
    'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.7922.199 Mobile Safari/537.36 Telegram-Android/12.9.1',
    'accept: application/json, text/plain, */*',
    'origin: https://coinfree.app',
    'referer: https://coinfree.app/',
    'accept-language: en,id-ID;q=0.9,id;q=0.8'
];

function clear() {
    (PHP_OS == "Linux") ? system('clear') : pclose(popen('cls', 'w'));
}

function timer($seconds, $prefix = "[!] please wait") {
    $wait_time = (int)$seconds;
    if ($wait_time < 1) return;
    $frames = ['⣾', '⣽', '⣻', '⢿', '⡿', '⣟', '⣯', '⣷'];
    $frame_count = count($frames);
    $current_frame = 0;
    $frame_delay = 0.1;
    while ($wait_time > 0) {
        $start_time = microtime(true);
        while ((microtime(true) - $start_time) < 1) {
            $hours = floor($wait_time / 3600);
            $minutes = floor(($wait_time % 3600) / 60);
            $seconds_left = $wait_time % 60;
            $time_formatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds_left);
            $spinner = $frames[$current_frame];
            echo putih . $prefix . hijau . " $time_formatted " . putih . $spinner . "\r";
            usleep($frame_delay * 1000000);
            $current_frame = ($current_frame + 1) % $frame_count;
            if ((microtime(true) - $start_time) >= 1) break;
        }
        $wait_time--;
    }
    echo "\r                                     \r";
}

function getConfig($configFile) {
    if (!file_exists($configFile)) {
        echo putih . "API Key (turnstile solver) : " . kuning;
        $apikey = trim(fgets(STDIN));
        echo putih . "initData (TG WebView) : " . kuning;
        $initData = trim(fgets(STDIN));
        echo putih . "enter..." . kuning;
        $deviceId = trim(fgets(STDIN));
        if ($deviceId === '') $deviceId = gen_device_id();
        echo putih . "coupon_code (kosongkan jika tidak ada) : " . kuning;
        $coupon = trim(fgets(STDIN));
        file_put_contents($configFile, json_encode([
            "apikey" => $apikey, "initData" => $initData,
            "deviceId" => $deviceId, "coupon_code" => $coupon
        ], JSON_PRETTY_PRINT));
        echo hijau . "Konfigurasi disimpan ke $configFile\n\n" . reset;
        sleep(2);
        return ["apikey" => $apikey, "initData" => $initData, "deviceId" => $deviceId, "coupon_code" => $coupon];
    }
    return json_decode(file_get_contents($configFile), true);
}

function wkwk($url, $payload = null, $headers = [], $method = "POST") {
    while (true) {
        $ch = curl_init();
        $final = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_COOKIEFILE     => 'cookies.txt',
            CURLOPT_COOKIEJAR      => 'cookies.txt'
        ];
        if ($method === "POST") {
            $final[CURLOPT_POST] = true;
            $final[CURLOPT_POSTFIELDS] = json_encode($payload);
        }
        curl_setopt_array($ch, $final);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response) return $response;
        echo putih . "\nwiwok detok, retry...\n";
        sleep(2);
    }
}

function api_call($action, $extra = [], $retried = false) {
    global $initData, $deviceId;
    $payload = array_merge([
        "action"   => $action,
        "initData" => $initData,
        "deviceId" => $deviceId
    ], $extra);
    $res = wkwk(api_url, $payload, $GLOBALS['HEADERS']);
    $json = json_decode($res, true);
    if (!is_array($json)) return ["status" => "error", "message" => substr($res, 0, 300)];
    if (!$retried && is_auth_error($json['message'] ?? '')) {
        if (prompt_new_initdata()) {
            echo putih . "[AUTH] " . hijau . "ulang " . $action . " dengan initData baru...\n";
            return api_call($action, $extra, true);
        }
    }
    return $json;
}

function is_auth_error($msg) {
    $m = strtolower(is_string($msg) ? $msg : '');
    if ($m === '') return false;
    foreach (['invalid initdata', 'unauthorized', 'invalid session', 'session expired', 'access denied'] as $e) {
        if (strpos($m, $e) !== false) return true;
    }
    return false;
}

function gen_device_id() {
    return bin2hex(random_bytes(32)) . bin2hex(random_bytes(32));
}

function update_config($key, $val) {
    global $configFile;
    $cfg = file_exists($configFile) ? json_decode(file_get_contents($configFile), true) : [];
    if (!is_array($cfg)) $cfg = [];
    $cfg[$key] = $val;
    file_put_contents($configFile, json_encode($cfg, JSON_PRETTY_PRINT));
    echo hijau . "[CONFIG] $key disimpan.\n" . reset;
}

function prompt_new_initdata() {
    global $initData;
    echo merah . "unauthorized access. Please new data\n" . reset;
    echo putih . "initData (TG WebView): " . kuning;
    $new = trim(fgets(STDIN));
    if ($new === '') {
        echo putih . "[AUTH] batal, tetap pakai initData lama.\n" . reset;
        return false;
    }
    $initData = $new;
    update_config('initData', $new);
    return true;
}

function solve_captcha($apikey, $action = "faucet_claim") {
    while (true) {
        $body = [
            "apikey"  => $apikey,
            "methods" => "turnstile",
            "domain"  => SOLVE_DOMAIN,
            "sitekey" => SITEKEY,
            "action"  => $action,
            "cdata"   => "",
            "json"    => 1
        ];
        $request = wkwk(solver_in, $body, ["Content-Type: application/json"]);
        foreach (["ERROR_WRONG_METHOD", "ERROR_KEY_DOES_NOT_EXIST", "ERROR_NO_SUCH_METHOD", "ERROR_WRONG_USER_KEY", "ERROR_ZERO_BALANCE", "ERROR_BAD_PARAMETERS", "ERROR_UNKNOWN"] as $e) {
            if (strpos($request, $e) !== false) {
                echo putih . "Error: " . merah . $e . "\n";
                exit;
            }
        }
        if (strpos($request, "ERROR_TOO_MANY_REQUESTS") !== false) { sleep(2); continue; }
        $id = (json_decode($request, true))["request"];

        while (true) {
            timer(5, "  captcha...");
            $result = wkwk(solver_out . "?apikey=" . $apikey . "&action=get&id=" . $id . "&json=1", null, [], "GET");
            if (strpos($result, "CAPCHA_NOT_READY") !== false) continue;
            $json = json_decode($result, true);
            $tok = is_array($json) ? ($json["request"] ?? "") : "";
            if (is_string($tok) && strlen($tok) > 50 && strpos($tok, ".") !== false) {
                echo putih . "[CAPTCHA] " . hijau . "OK\n";
                return $tok;
            }
            echo putih . "[CAPTCHA] " . kuning . "respon aneh: " . substr(is_array($json) ? json_encode($json) : $result, 0, 120) . "\n";
            sleep(3);
            continue;
        }
    }
}

function fetch_user() {
    $r = api_call("get_user_data");
    return $r;
}

function get_data($r) {
    return ($r['status'] ?? '') == 'success' ? ($r['data'] ?? $r) : null;
}

function coin_of($d) {
    return strtoupper($d['preferred_coin'] ?? DEFAULT_COIN);
}

function fmt_num($n) {
    return rtrim(rtrim(number_format((float)$n, 8, '.', ''), '0'), '.');
}

function show_banner($d) {
    echo "\n";
    echo putih . "balance: " . biru . fmt_num($d['balance'] ?? 0) . " " . coin_of($d)
       . putih . "today: " . biru . fmt_num($d['earned_today'] ?? 0) . "\n";
}

function daily_bonus() {
    $r = api_call("claim_daily_streak");
    if (($r['status'] ?? '') == 'success') {
        $s = $r['data'] ?? [];
        $amt = $s['reward_amount'] ?? $s['reward_amount_claimed'] ?? '?';
        $cn  = strtoupper($s['reward_coin'] ?? DEFAULT_COIN);
        if (!empty($s['completed_now'])) {
            echo putih . "[DAILY] " . hijau . "siklus selesai! +" . $amt . " " . $cn . "\n";
        } else {
            echo putih . "[DAILY] " . hijau . "OK +" . $amt . " " . $cn . "\n";
        }
    } else {
        echo putih . "[DAILY] " . kuning . ($r['message'] ?? 'gagal / sudah claim') . "\n";
    }
}

function referral_claim() {
    $r = api_call("claim_referral_earnings");
    if (($r['status'] ?? '') == 'success') {
        echo putih . "[REF] " . hijau . ($r['message'] ?? 'OK') . "\n";
    } else {
        echo putih . "[REF] " . kuning . ($r['message'] ?? 'gagal') . "\n";
    }
}

function coupon_redeem($code = '') {
    if ($code === '') {
        echo putih . "Kode coupon: " . kuning;
        $code = trim(fgets(STDIN));
        if ($code === '') { echo putih . "batal.\n"; return; }
    }
    echo putih . "[COUPON] " . kuning . "redeem " . $code . "...\n";
    $r = api_call("redeem_daily_coupon", ["coupon_code" => $code]);
    if (($r['status'] ?? '') == 'success') {
        $c = $r['data'] ?? [];
        $amt = $c['reward_amount_claimed'] ?? '?';
        $cn  = strtoupper($c['reward_coin_claimed'] ?? DEFAULT_COIN);
        echo putih . "[COUPON] " . hijau . "OK +" . $amt . " " . $cn . "\n";
    } else {
        echo putih . "[COUPON] " . merah . ($r['message'] ?? 'gagal') . "\n";
    }
}

function claim_all_game() {
    global $apikey;
    $ready_at = [];
    $mode_idx = -1;
    $notified = [];
    $dead = [];
    $limit_count = 0;

    echo putih . "------------------------------------------\n";

    while (true) {
        $u = fetch_user();
        $d = get_data($u);
        if (!$d) {
            echo putih . "[DATA] " . merah . ($u['message'] ?? 'gagal get_user_data') . "\n";
            timer(60, "  retry...");
            continue;
        }

        $global_left = intval($d['faucet_global_cooldown_remaining'] ?? 0);
        if ($global_left > 0) {
            timer($global_left, "  cooldown global...");
            continue;
        }

        $shortest = 999999;
        $tried = false;
        $claimed = false;
        $now = time();

        for ($k = 0; $k < count(MODES); $k++) {
            $mode_idx = ($mode_idx + 1) % count(MODES);
            $m = MODES[$mode_idx];
            if (isset($dead[$m])) continue;
            if (isset($ready_at[$m]) && $ready_at[$m] > $now) {
                $shortest = min($shortest, $ready_at[$m] - $now);
                continue;
            }
            $left = intval($d["faucet_cooldown_remaining_" . $m] ?? 0);
            if ($left > 0) {
                $ready_at[$m] = $now + $left;
                $shortest = min($shortest, $left);
                continue;
            }
            $tried = true;

            $spin = api_call("get_faucet_spin_reward", ["mode" => $m]);
            if (($spin['status'] ?? '') != 'success') {
                $msg = $spin['message'] ?? json_encode($spin);
                $rem = intval($spin["faucet_cooldown_remaining_" . $m] ?? $spin['cooldown_remaining'] ?? 0);
                if ($rem > 0) { $ready_at[$m] = $now + $rem; $shortest = min($shortest, $rem); continue; }
                if (stripos($msg, 'invalid faucet mode') !== false || stripos($msg, 'unknown mode') !== false || stripos($msg, 'mode not found') !== false) {
                    if (empty($notified[$m])) {
                        echo putih . "[" . cyan . $m . putih . "] " . kuning . "mode sudah tidak tersedia, skip\n";
                        $notified[$m] = true;
                    }
                    $dead[$m] = true;
                    continue;
                }
                if (stripos($msg, 'limit') !== false || stripos($msg, 'exhaust') !== false || stripos($msg, 'daily') !== false) {
                    if (empty($notified[$m])) {
                        echo putih . "[" . cyan . $m . putih . "] " . kuning . "limit tercapai\n";
                        $notified[$m] = true;
                        $limit_count++;
                        if ($limit_count >= count(MODES)) {
                            echo putih . "semua mode limit, kembali ke menu...\n";
                            return;
                        }
                    }
                    $ready_at[$m] = $now + 3600;
                    continue;
                }
                echo putih . "[" . cyan . $m . putih . "] " . merah . $msg . "\n";
                continue;
            }

            $tok = solve_captcha($apikey, "faucet_claim");
            $cf = api_call("claim_faucet", ["mode" => $m, "captchaToken" => $tok]);
            if (($cf['status'] ?? '') != 'success') {
                $msg = $cf['message'] ?? '';
                if ($msg === '') $msg = substr(json_encode($cf), 0, 200);
                $rem = intval($cf["faucet_cooldown_remaining_" . $m] ?? $cf['faucet_global_cooldown_remaining'] ?? $cf['cooldown_remaining'] ?? 0);
                if ($rem > 0) { $ready_at[$m] = $now + $rem; $shortest = min($shortest, $rem); }
                echo putih . "[" . cyan . $m . putih . "] " . merah . $msg . "\n";
                continue;
            }

            $data = $cf['data'] ?? $cf;
            $amt = $data['claimed_amount'] ?? $data['reward_amount'] ?? $data['base_reward'] ?? $data['amount'] ?? '?';
            $cn  = strtoupper($data['reward_coin'] ?? $data['coin'] ?? coin_of($d));
            $bal = $data['balance'] ?? $d['balance'] ?? '?';

            $fresh = fetch_user();
            $fd = get_data($fresh);
            if ($fd) {
                $d = $fd;
                $bal = $d['balance'] ?? $bal;
            }

            echo putih . "[" . cyan . $m . putih . "] +" . hijau . fmt_num($amt) . " " . $cn . putih." - balance " . biru . fmt_num($bal) . "\n";
            $claimed = true;
            $gcd = intval($data['faucet_global_cooldown_seconds'] ?? $cf['faucet_global_cooldown_seconds'] ?? 60);
            $shortest = min($shortest, $gcd);
        }

        if (!$tried) {
            $wait = ($shortest < 999999) ? $shortest : 30;
            if ($wait < 1) $wait = 5;
            timer($wait, "  waiting...");
            continue;
        }
        if ($claimed) {
            $wait = ($shortest < 999999) ? $shortest : 60;
            timer($wait, "  next claim...");
            continue;
        }
        if ($shortest < 999999) {
            timer($shortest, "  waiting...");
        } else {
            timer(20, "  retry...");
        }
    }
}

function do_withdraw() {
    global $apikey;

    $u = fetch_user();
    $d = get_data($u);
    if (!$d) {
        echo putih . "[WD] " . merah . ($u['message'] ?? 'gagal get data') . "\n";
        return;
    }
    $bal  = $d['balance'] ?? 0;
    $coin = coin_of($d);
    $email = $d['email'] ?? '';
    $min_fp = $d['min_withdraw_faucetpay'] ?? 0;
    $min_cw = $d['min_withdraw_cwallet'] ?? 0;

    echo putih . "[coinfree " . kuning . "withdraw" . putih . "]\n";
    echo putih . "------------------------------------------\n\n";
    echo putih . "Balance      : " . biru . fmt_num($bal) . " " . $coin . "\n";
    echo putih . "Email payout : " . cyan . ($email === '' ? '(belum diset)' : $email) . "\n";

    if ($email === '') {
        echo "\n" . putih . "Email belum diset. Masukkan email: " . kuning;
        $new_email = trim(fgets(STDIN));
        if ($new_email === '') { echo putih . "batal.\n"; return; }
        $up = api_call("update_user_email", ["email" => $new_email]);
        if (($up['status'] ?? '') == 'success') {
            echo putih . "[SET] " . hijau . ($up['message'] ?? 'OK, email tersimpan') . "\n";
            $email = $new_email;
        } else {
            echo putih . "[SET] " . merah . ($up['message'] ?? 'gagal update email') . "\n";
            return;
        }
    }

    echo "\n";
    echo putih . "Method (withdraw saldo penuh):\n";
    echo putih . "  1. FaucetPay  [min " . fmt_num($min_fp) . " " . $coin . "]\n";
    echo putih . "  2. Cwallet    [min " . fmt_num($min_cw) . " " . $coin . "]\n";
    echo putih . "  0. Batal\n";
    echo putih . "pilih: " . kuning;
    $opt = trim(fgets(STDIN));
    if ($opt == '1') $method = 'faucetpay';
    elseif ($opt == '2') $method = 'cwallet';
    else { echo putih . "batal.\n"; return; }

    $min = ($method == 'faucetpay') ? floatval($min_fp) : floatval($min_cw);
    if (floatval($bal) < $min) {
        echo putih . "[!] Saldo tidak cukup (" . fmt_num($bal) . " < min " . fmt_num($min) . ")\n";
        return;
    }

    echo "\n";
    echo putih . "Konfirmasi withdraw semua saldo:\n";
    echo putih . "  method  : " . cyan . $method . "\n";
    echo putih . "  email   : " . cyan . $email . "\n";
    echo putih . "  jumlah  : " . cyan . fmt_num($bal) . " " . $coin . "\n";
    echo putih . "Lanjut? (y/N): " . kuning;
    $ok = strtolower(trim(fgets(STDIN)));
    if ($ok !== 'y' && $ok !== 'yes') { echo putih . "batal.\n"; return; }

    echo putih . "[CAPTCHA] " . kuning . "solving turnstile...\n";
    $tok = solve_captcha($apikey, "withdraw_funds");
    echo putih . "[WD] " . kuning . "kirim via " . $method . "...\n";
    $r = api_call("withdraw_funds", ["method" => $method, "captchaToken" => $tok]);
    if (($r['status'] ?? '') == 'success' || ($r['status'] ?? '') == 'pending') {
        echo putih . "[WD] " . hijau . ($r['message'] ?? 'OK') . "\n";
    } else {
        echo putih . "[WD] " . merah . ($r['message'] ?? json_encode($r)) . "\n";
    }
}

clear();
$config   = getConfig($configFile);
$apikey   = $config['apikey'];
$initData = $config['initData'];
$deviceId = $config['deviceId'];
if (trim($deviceId) === '') {
    $deviceId = gen_device_id();
    update_config('deviceId', $deviceId);
}
$coupon_code = trim($config['coupon_code'] ?? '');

while (true) {
    clear();
    echo putih . "CoinFree Bot\n";

    $u = fetch_user();
    $d = get_data($u);
    if ($d) {
        echo putih . "balance: " . biru . fmt_num($d['balance'] ?? 0) . " " . coin_of($d)
           . putih . " | today: " . biru . fmt_num($d['earned_today'] ?? 0)
           . putih . "\n";
    } else {
        echo putih . "balance: " . merah . "gagal fetch (" . ($u['message'] ?? '?') . ")\n";
    }

    echo "\n";
    echo putih . "  1. " . cyan . "Claim All Game" . putih . " (rotasi 8 mode faucet)\n";
    echo putih . "  2. " . cyan . "Daily Streak Check-in\n";
    echo putih . "  3. " . cyan . "Claim Referral Earnings\n";
    echo putih . "  4. " . cyan . "Redeem Daily Coupon\n";
    echo putih . "  5. " . cyan . "Withdraw\n";
    echo putih . "  0. " . merah . "Exit\n";
    echo putih . "pilih: " . kuning;
    $opt = trim(fgets(STDIN));

    if ($opt == '1') {
        claim_all_game();
        echo "\n" . putih . "enter untuk kembali...";
        fgets(STDIN);
    } elseif ($opt == '2') {
        daily_bonus();
        echo "\n" . putih . "enter untuk kembali...";
        fgets(STDIN);
    } elseif ($opt == '3') {
        referral_claim();
        echo "\n" . putih . "enter untuk kembali...";
        fgets(STDIN);
    } elseif ($opt == '4') {
        coupon_redeem($coupon_code);
        echo "\n" . putih . "enter untuk kembali...";
        fgets(STDIN);
    } elseif ($opt == '5') {
        do_withdraw();
        echo "\n" . putih . "enter untuk kembali...";
        fgets(STDIN);
    } elseif ($opt == '0') {
        exit;
    }
}
