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
    
const script = "moneyrain";


$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);
bn();
$email = "bagusfildhonfatoni8@gmail.com";

function head() {
    $h = [];
    $h[] = "host: autofaucet.moneyrain.top";
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36";
    $h[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8";
    $h[] = "accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
    $h[] = "content-type: application/x-www-form-urlencoded";
    return $h;
}


bn();
while(true){
$log = "https://autofaucet.moneyrain.top/index.php";
$url = "https://autofaucet.moneyrain.top/claim.php";
$log1 = "https://autofaucet.moneyrain.top/index.php";


$res = get2("https://autofaucet.moneyrain.top/index.php");
preg_match('/name="csrf_token"\s+value="([^"]+)"/', $res, $csrf_match);
$tok = $csrf_match[1] ?? '';

$mail = str_replace("@","%40",$email);
$data = "csrf_token=$tok&email=$mail";
$suc = post2($log1, $data);

$claim = get2("https://autofaucet.moneyrain.top/claim.php");
preg_match('/csrf_token" value="([^"]+)"/', $claim, $csrf_match2);
$csrf = $csrf_match2[1] ?? '';

preg_match('/id="claimNonce" value="([^"]+)"/', $claim, $nonce_match);
$nonce = $nonce_match[1] ?? '';


// Viewport & screen (beda tipis biar natural)
$viewport = rand(360, 428);
$screen = $viewport + rand(-10, 10); // beda 0-10 pixel

// Touch points (rata-rata HP 5 atau 10)
$touch = (rand(1, 10) > 7) ? 10 : 5; // 70% 5, 30% 10

// Hover & fine (Android jarang 1)
$hover = (rand(1, 100) > 90) ? 1 : 0; // 10% chance
$fine = (rand(1, 100) > 95) ? 1 : 0; // 5% chance

// Mobile hint (99% 1)
$mobile = (rand(1, 100) > 98) ? 0 : 1;

$data = "action=claim&csrf_token=$csrf&claim_nonce=$nonce&device_viewport_width=404&device_screen_width=404&device_touch_points=5&device_hover=0&device_fine_pointer=0&device_platform=Android&device_mobile_hint=$mobile";
print$done = post2("https://autofaucet.moneyrain.top/claim.php", $data);

// Cek apakah IP restricted
if (strpos($done, 'Only one account per IP address is allowed') !== false) {
    echo "❌ Only one account per IP address is allowed!\n";
    exit;
}

// Ambil sukses dengan preg_match
preg_match('/<div class="alert alert-success">\s*([^!]+)!/', $done, $sukses_match);
$sukses = $sukses_match[1] ?? '';

preg_match('/<div class="alert alert-error">([^<]+)/', $done, $error_match);
$error = $error_match[1] ?? '';

preg_match('/id="timer">([^<]+)/', $done, $timer_match);
$timr = $timer_match[1] ?? '';

// Tampilkan sesuai kondisi
if (isset($sukses) && !empty($sukses)) {
    print og.p.$sukses.cl.n;
    g();
    timer($timr);
} else {
    print "❌ " . $error . "\n";
    # timer(300);
}
}


#$data = "action=claim&csrf_token=37626f7f7b7b9c12dc9aea5253380d70bf9305003d9ec717d9664e68ebf101d8&claim_nonce=1cfb5a2407d0a4d17b75da19704cf4ccee9b004041ce6131d57bdebfcb376e38&device_viewport_width=404&device_screen_width=404&device_touch_points=5&device_hover=0&device_fine_pointer=0&device_platform=Android&device_mobile_hint=1";

// $tes = get1($url);
// echo $tes;

#$mail = str_replace("@","%40",$email);
#$data = "action=claim&csrf_token=37626f7f7b7b9c12dc9aea5253380d70bf9305003d9ec717d9664e68ebf101d8&claim_nonce=1cfb5a2407d0a4d17b75da19704cf4ccee9b004041ce6131d57bdebfcb376e38&device_viewport_width=404&device_screen_width=404&device_touch_points=5&device_hover=0&device_fine_pointer=0&device_platform=Android&device_mobile_hint=1";