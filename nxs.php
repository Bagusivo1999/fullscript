<?php
error_reporting(0);

function curl($url, $post = 0, $httpheader = 0, $proxy = 0){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_PORT, 443);
curl_setopt($ch, CURLOPT_DOH_URL, 'https://dns.google/dns-query');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
#curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_COOKIE,TRUE);
curl_setopt($ch, CURLOPT_TCP_KEEPALIVE, true);
curl_setopt($ch, CURLOPT_TCP_KEEPIDLE, 60);
curl_setopt($ch, CURLOPT_TCP_KEEPINTVL, 60);
if($post){
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);}
if($httpheader){
curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);}
if($proxy){
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
curl_setopt($ch, CURLOPT_PROXY, $proxy);}
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch);
if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
$header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
$body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
##curl_close($ch);
return array($header, $body);}}
function get($url){return curl($url, null, head())[1];}
function post($url,$data){return curl($url, $data, head())[1];}


system("clear");
$cookie = readline("Masukkan Cookie: ");


function head() {
    global $cookie;
    
    $h = [];
    $h[] = "Host: tubepay.net";
    $h[] = "Connection: keep-alive";
    $h[] = "Upgrade-Insecure-Requests: 1";
    $h[] = "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36";
    $h[] = "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
    $h[] = "Cookie: " . $cookie;
    
    return $h;
}

function timer($timr){
while(true){
for ($x=$timr;$x>0;$x--){
echo "\r                                             \r";
echo $y1."wait yaa ".$blue2.$x.$red2." Second ";

sleep(1);
}
echo "\r                                                  \r";
}
}


system("clear");
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
    print_r("Claim Left: $today / $total\n");

    $claim = get("https://tubepay.net/viewyt/$id");
    preg_match("/cnt\s*=\s*'([^']*)'/", $claim, $match);
    $kode = $match[1] ?? null;
    preg_match("/timers_w\s*=\s*(\d+)/", $claim, $match);
    $timr = $match[1] ?? null;
    timer($timr);

    $data = "cnt=$kode";
    $suc = post("https://tubepay.net/ajax/surfv/coin.php", $data);
    preg_match("/OK;([0-9.]+)/", $suc, $match);
    $saldo = $match[1] ?? null;

    echo "sukses play $saldo klaim\n";
}