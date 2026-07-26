<?php

error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$configFile = "config.json";
$tod = "cookies.txt";

const hitam  = "\033[0;30m";
const merah  = "\033[0;31m";
const hijau  = "\033[0;32m";
const kuning = "\033[0;33m";
const biru   = "\033[0;34m";
const cyan   = "\033[0;36m";
const putih  = "\033[0;37m";
const reset  = "\033[0m";

const bg_hitam  = "\033[40m";
const bg_merah  = "\033[41m";
const bg_hijau  = "\033[42m";
const bg_kuning = "\033[43m";
const bg_biru   = "\033[44m";
const bg_ungu   = "\033[45m";
const bg_cyan   = "\033[46m";
const bg_putih  = "\033[47m";

const script_name = "earnbitsun.club";
const host        = "https://earnbitsun.club";
const api_in      = "https://api.waryono.my.id/in.php";

function clear() {
    (PHP_OS == "Linux") ? system('clear') : pclose(popen('cls', 'w'));
}


function skibidixxx($url, $method = 'GET', $data = [], $headers = []) {
    $ch = curl_init();
    $final_headers = [];
    foreach ($headers as $header) {
        $final_headers[] = $header;
    }
    $options = [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYHOST => 1,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER     => $final_headers,
        CURLOPT_CONNECTTIMEOUT => 999,
        CURLOPT_TIMEOUT        => 999,
        CURLOPT_COOKIEFILE     => 'cookies.txt',
        CURLOPT_COOKIEJAR      => 'cookies.txt'
    ];
    if (strtoupper($method) === 'POST') {
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = $data;
    }
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    if ($response) {
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);
        curl_close($ch);
        return $body;
    } else {
        curl_close($ch);
        echo "\33[1;" . rand(30, 37) . "mwiwok detok";
        return "ERROR_SIGNAL";
    }
}

function timer($seconds, $prefix = "[!] please wait") {
    $wait_time = (int)$seconds;
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

function cloud($apikey) {
    $headers = ["Content-Type: application/json"];
    $body = json_encode([
        "apikey" => $apikey,
        "methods" => "turnstile",
        "domain" => host,
        "sitekey" => "0x4AAAAAADXP0YCJj-kEWRBh",
        "json" => 1
    ]);
    $request = skibidixxx(api_in, "POST", $body, $headers);
    if (strpos($request, "ERROR_WRONG_METHOD") !== false) { echo putih."Error: ".merah."ERROR_WRONG_METHOD\n"; exit; }
    if (strpos($request, "ERROR_KEY_DOES_NOT_EXIST") !== false) { echo putih."Error: ".merah."ERROR_KEY_DOES_NOT_EXIST\n"; exit; }
    if (strpos($request, "ERROR_METHOD_NOT_SPECIFIED") !== false) { echo putih."Error: ".merah."ERROR_METHOD_NOT_SPECIFIED\n"; exit; }
    if (strpos($request, "ERROR_NO_SUCH_METHOD") !== false) { echo putih."Error: ".merah."ERROR_NO_SUCH_METHOD\n"; exit; }
    if (strpos($request, "ERROR_DATABASE_CONNECTION_FAILED") !== false) { echo putih."Error: ".merah."ERROR_DATABASE_CONNECTION_FAILED\n"; exit; }
    if (strpos($request, "ERROR_TOO_MANY_REQUESTS") !== false) { echo putih."Error: ".merah."ERROR_TOO_MANY_REQUESTS"; sleep(1.8); echo "\r                                               \r"; return "ERROR_TOO_MANY_REQUESTS"; }
    if (strpos($request, "ERROR_WRONG_USER_KEY") !== false) { echo putih."Error: ".merah."ERROR_WRONG_USER_KEY\n"; exit; }
    if (strpos($request, "ERROR_ZERO_BALANCE") !== false) { echo putih."Error: ".merah."ERROR_ZERO_BALANCE\n"; exit; }
    if (strpos($request, "ERROR_BAD_PARAMETERS") !== false) { echo putih."Error: ".merah."ERROR_BAD_PARAMETERS\n"; exit; }
    if (strpos($request, "ERROR_EMPTY_IMAGE") !== false) { echo putih."Error: ".merah."ERROR_EMPTY_IMAGE\n"; exit; }
    if (strpos($request, "ERROR_UNKNOWN") !== false) { echo putih."Error: ".merah."ERROR_UNKNOWN\n"; exit; }
    $json = json_decode($request, true);
    $id = $json["request"];
    reload:
    timer(2, "  cfbypass... ");
    $url = "https://api.waryono.my.id/res.php?apikey=".$apikey."&action=get&id=".$id."&json=1";
    $result = skibidixxx($url, "GET", []);
    if (strpos($result, "ERROR_BAD_PARAMETERS") !== false) { echo putih."Error: ".merah."ERROR_BAD_PARAMETERS\n"; exit; }
    if (strpos($result, "Database connection failed") !== false) { echo putih."Error: ".merah."Database connection failed\n"; exit; }
    if (strpos($result, "WRONG_CAPTCHA_ID") !== false) { echo putih."Error: ".merah."WRONG_CAPTCHA_ID"; sleep(1.8); echo "\r                                               \r"; return "WRONG_CAPTCHA_ID"; }
    if (strpos($result, "ERROR_SOLVE_PENDING") !== false) { echo putih."Error: ".merah."ERROR_SOLVE_PENDING"; sleep(1.8); echo "\r                                               \r"; return "ERROR_SOLVE_PENDING"; }
    if (strpos($result, "CAPCHA_NOT_READY") !== false) { echo putih."Error: ".merah."CAPCHA_NOT_READY"; sleep(1.8); echo "\r                                               \r"; goto reload; }
    if (strpos($result, "ERROR_CAPTCHA_UNSOLVABLE") !== false) { echo putih."Error: ".merah."ERROR_CAPTCHA_UNSOLVABLE"; sleep(1.8); echo "\r                                               \r"; return "ERROR_CAPTCHA_UNSOLVABLE"; }
    if (strpos($result, "ERROR_BAD_REQUEST") !== false) { echo "Error: ".merah."ERROR_BAD_REQUEST\n"; exit; }
    if (strpos($result, "INTENAL_SERVER_ERROR") !== false) { echo "Errro: ".merah."INTENAL_SERVER_ERROR"; sleep(1.8); echo "\r                                               \r"; return "INTENAL_SERVER_ERROR"; }
    $json = json_decode($result, true);
    $res = $json["request"];
    return ["captcha" => $res];
}

function bypassCloudflare(&$config, $configFile, $target) {
    echo putih . "Cloudflare! wait.. ";
    $python_cmd = "python exec.py " . $target ." 2>/dev/null";
    $output = exec($python_cmd);
    $data_bypass = json_decode($output, true);
    if (isset($data_bypass['cf_clearance']) && !empty($data_bypass['cf_clearance'])) {
        $full_new_cf = $data_bypass['cf_clearance'];
        $new_ua = $data_bypass['user_agent'];
        $old_cookie = $config['cookie'];
        if (strpos($full_new_cf, '=') !== false) {
            $new_token_value = explode('=', $full_new_cf)[1];
        } else {
            $new_token_value = $full_new_cf;
        }
        $pattern = '/cf_clearance=[^;]+/';
        $replacement = "cf_clearance=" . $new_token_value;
        if (preg_match($pattern, $old_cookie)) {
            $new_cookie_str = preg_replace($pattern, $replacement, $old_cookie);
        } else {
            $new_cookie_str = rtrim($old_cookie, "; ") . "; " . $replacement;
        }
        $config['cookie'] = $new_cookie_str;
        $config['user_agent'] = $new_ua;
        file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
        echo hijau . "Success Solver Cloudflare! WAF\n";
        sleep(2);
        return true;
    } else {
        echo merah . "Error Bypass\n";
        return false;
    }
}

function getConfig($configFile) {
    if (!file_exists($configFile)) {
        echo putih . "API Key: " . kuning;
        $apikey = trim(fgets(STDIN));
        echo putih . "Email: " . kuning;
        $email = trim(fgets(STDIN));
        echo putih . "Password: " . kuning;
        $password = trim(fgets(STDIN));
        $data = [
            "apikey"   => $apikey,
            "email"    => $email,
            "password" => $password
        ];
        file_put_contents($configFile, json_encode($data, JSON_PRETTY_PRINT));
        echo hijau . "disimpan ke $configFile\n\n" . reset;
        sleep(3);
        return $data;
    }
    return json_decode(file_get_contents($configFile), true);
}

function banner() {
    echo putih  . "---------------------------------------------------\n";
    echo putih. "Script Name : " . hijau . script_name."\n";
    echo putih  . "---------------------------------------------------\n";
}

function asuuuu(&$a, &$b){
	$a = [
		"host: earnbitsun.club",
		"user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36",
		"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,q=0.8,application/signed-exchange;v=b3;q=0.7",
		"referer: https://earnbitsun.club"
	];
	$b = [
		"host: earnbitsun.club",
		"x-version-request: 934d362",
		"user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36",
		"accept: application/json, text/plain",
		"content-type: application/json",
		"origin: https://earnbitsun.club",
		"referer: https://earnbitsun.club/faucet"
	];
	$c = [
		"host: earnbitsun.club",
		"authorization: ",
		"user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36",
		"accept: application/json, text/plain",
		"x-version-request: 934d362",
		"referer: https://earnbitsun.club/faucet",
	];
}


home:
login:
clear();
banner();

$config   = getConfig($configFile);
$apikey   = $config['apikey'];
$email    = $config['email'];
$password = $config['password'];

clear();
banner();

asuuuu($a,$b,$c);

$dash = skibidixxx(host, "GET", [], $a);
	if (strpos($dash, "Faucet - Earnbitsun") !== false) {
		preg_match('/class="text-sm font-bold text-green-600">([^<]+)</i', $dash, $user);
		$username = isset($user[1]) ? trim($user[1]) : '???';
		$inpo = json_decode(skibidixxx(host."/api/account/tokens/Coins", "GET", [], $c), true);
		$coin = $inpo['data']['balance'];
		echo putih . "username " . hijau . $username . "\n";
		echo putih . "balance " . hijau . $coin . "\n\n";

		asu:
		$check = json_decode(skibidixxx(host."/api/faucet", "GET", [], $a), true);
		if (isset($check['data']['cycle_ended_at'])) {
		    $endTime = strtotime($check['data']['cycle_ended_at']);
		    $now = time();
		    $delay = $endTime - $now;
		    if ($delay > 0) {
		        timer($delay, "  next claim...");
		        goto y;

		    } else {
		        goto y;

		    }

		} else {
		    echo merah . "[ERROR] Data timer 'cycle_ended_at' gak ketangkap!\n";
		    goto asu;
		}

		y:
		$bypass = cloud($apikey);
		if (is_array($bypass)) {
		$cftoken = $bypass["captcha"];
		$data = json_encode([
			  "captcha_token" => "turnstile:$cftoken"
		]);
		$claim = json_decode(skibidixxx(host."/api/faucet", "POST", $data, $b), true);
		if (isset($claim['data']['claimed_amount'])) {
		    $amount = $claim['data']['claimed_amount'];
		    $inpo = json_decode(skibidixxx(host."/api/account/tokens/Coins", "GET", [], $c), true);
		    $coin = $inpo['data']['balance'];
		    echo putih . "[INFO] " . "claim reward " . biru . $amount . putih . " Coins ". hijau. $coin."\n";
		    if (isset($claim['data']['cycle_ended_at'])) {
		        $endTime = strtotime($claim['data']['cycle_ended_at']);
		        $now = time();
		        $delay = $endTime - $now;
		        $delay = ($delay > 0) ? $delay : 5; 
		        timer($delay, "  wait...");
		        goto asu;
		    }
		
		} elseif (isset($claim['error'])) {
		    $msg = $claim['error'];
		    echo putih . "[INFO] " . merah . trim($msg) . "\n";
		    goto asu;
		
		} else {
		    echo putih . "[INFO] " . kuning . "INTERNAL ERROR\n";
		    sleep(3);
		    goto asu;
		}
		
		} elseif (in_array($bypass, ["WRONG_CAPTCHA_ID", "ERROR_CAPTCHA_UNSOLVABLE", "ERROR_TOO_MANY_REQUESTS", "INTENAL_SERVER_ERROR"])) {
		  goto y;

	} else {
		echo putih."Error: ".merah." Tidak diketahui!! mencoba lagi...\n";
		goto y;
	}

	} else {
		echo kuning."login required...!\n";
		jembut:
		asuuuu($a,$b,$c);

		$home = skibidixxx(host, "GET", [], $a);
		$cs = json_decode(skibidixxx(host."/api/auth/csrf", "GET", [], $a), true);
		$csrf = $cs['csrfToken'] ?? '';

        $bypass = cloud($apikey);
        if (is_array($bypass)) {
        $cftoken = $bypass["captcha"];
		$data = json_encode([
			  "email" => $email,
			  "password" => $password,
			  "captcha_token" => "turnstile:$cftoken"
		]);
		$login = json_decode(skibidixxx(host."/api/auth/signin", "POST", $data, $b), true);
		if (isset($login['data']['success'])) {
		    $msg = $login['data']['success'];
		    echo putih . "[INFO] " . hijau . trim($msg) . "\n";
		    sleep(3);
		    goto home;
		
		} elseif (isset($login['error'])) {
		    $msg = $login['error'];
		    echo putih . "[INFO] " . merah . trim($msg) . "\n";
		    @unlink($waryono);@unlink($configFile);
		    exit;
		
		} else {
		    echo putih . "[INFO] " . kuning . "INTERNAL ERROR\n";
		    @unlink($waryono);@unlink($configFile);
		    exit;
		}

	  } elseif (in_array($bypass, ["WRONG_CAPTCHA_ID", "ERROR_CAPTCHA_UNSOLVABLE", "ERROR_TOO_MANY_REQUESTS", "INTENAL_SERVER_ERROR"])) {
	  goto jembut;
		      
	 } else {
	 echo putih."Error: ".merah." Tidak diketahui!! mencoba lagi...\n";
	 sleep(2);
	 goto jembut;

   }

}
