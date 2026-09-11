<?php

error_reporting(0);

function sock(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    sock();
const script = "coinpin";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

function head(){
$h[] = "host: coinpin.top";
$h[] = "upgrade-insecure-requests: 1";
$h[] = "user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Mobile Safari/537.36";
$h[] = "referer: https://coinpin.top/";
$h[] = "accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
return $h;
}

$log = get2("https://coinpin.top/login");

$pattern = '/<input[^>]*name=["\']csrf_token_name["\'][^>]*value=["\']([^"\']+)["\']/i';

preg_match_all($pattern, $log, $matches);
$all_tokens = $matches[1]; // array semua value

$csrf = $all_tokens[0]?? ''; // <- fix: pake '' bukan ";

$data = "email=bagusfildhonfatoni8%40gmail.com&password=bagusff199&csrf_token_name=". urlencode($csrf);
$suclog = post2("https://coinpin.top/auth/login", $data);
$suclog = post2("https://coinpin.top/auth/login", $data);

$pattern = '/<p class="acc-amount">.*?([0-9.,]+)</i';

if (preg_match($pattern, $suclog, $matches)) {
    $saldo = $matches[1]; // hasilnya: 500.00
    echo "Balance: ". $saldo;
} else {
    echo "Saldo tidak ditemukan";
}