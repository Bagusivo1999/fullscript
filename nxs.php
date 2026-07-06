<?php
#error_reporting(0);

function turoxxx(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    turoxxx();

const script = "TUBEPAY";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);


$cookie = cok("cookie tube");


function head() {
    global $cookie;
    
    $h = [];
    $h[] = "Host: tubepay.net";
    $h[] = "Connection: keep-alive";
    $h[] = "Upgrade-Insecure-Requests: 1";
    $h[] = "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36";
    $h[] = "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
    $h[] = "Cookie: " . $cookie;
    
    return $h; // <-- titik koma di sini
}


bn();
while(true){
    $dash = get("https://tubepay.net/user/watch");
    preg_match("/startView\('(\d+)'\)/", $dash, $match);
    $id = $match[1] ?? null;
    
    if (empty($id)) {
        echo "Iklan habis atau tidak ada video. Berhenti.\n";
        break;
    }
    
    // Ambil progress video hari ini
    preg_match("/<span[^>]*>(\d+)\s*\/\s*(\d+)<\/span>/", $dash, $match);
    $today = $match[1] ?? 0;
    $total = $match[2] ?? 20;
    print p."Claim Left: ".green2."$today / $total".cl.n;

    $claim = get("https://tubepay.net/viewyt/$id");
    preg_match("/cnt\s*=\s*'([^']*)'/", $claim, $match);
    $kode = $match[1] ?? null;
    preg_match("/timers_w\s*=\s*(\d+)/", $claim, $match);
    $timr = $match[1] ?? null;
    g();
    timer($timr);

    $data = "cnt=$kode";
    $suc = post("https://tubepay.net/ajax/surfv/coin.php", $data);
    preg_match("/OK;([0-9.]+)/", $suc, $match);
    $saldo = $match[1] ?? null;

    echo og.p."sukses play $saldo klaim".cl.n; g();
}