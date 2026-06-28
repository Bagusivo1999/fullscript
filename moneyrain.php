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

$email = Sav("email");

function head() {
    return [
        'host' => 'autofaucet.moneyrain.top',
        'user-agent' => 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
        'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
        'accept-language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        'referer' => 'https://autofaucet.moneyrain.top/claim.php',
        'content-type' => 'application/x-www-form-urlencoded'
    ];
}


bn();
while(true){
$log = "https://autofaucet.moneyrain.top/index.php";
$url = "https://autofaucet.moneyrain.top/claim.php";
$log1 = "https://autofaucet.moneyrain.top/index.php";


$res = get1($log);
$tok = explode('"', explode('csrf_token" value="', $res)[1])[0];

$mail = str_replace("@","%40",$email);
$data = "csrf_token=$tok&email=$mail";
$suc = post1($log1, $data);

$claim = get1($url);
$csrf = explode('"', explode('csrf_token" value="', $claim)[1])[0];
$nonce = explode('"', explode('id="claimNonce" value="', $claim)[1])[0];


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

$data = "action=claim&csrf_token=$csrf&claim_nonce=$nonce&device_viewport_width=$viewport&device_screen_width=$screen&device_touch_points=$touch&device_hover=$hover&device_fine_pointer=$fine&device_platform=Android&device_mobile_hint=$mobile";
$done = post1($url, $data);

// Cek apakah IP restricted
if (strpos($done, 'Only one account per IP address is allowed') !== false) {
    echo "❌ Only one account per IP address is allowed!\n";
    exit;
}

// Ambil sukses
$sukses = explode('!', explode('<div class="alert alert-success">
                ', $done)[1])[0];
$error = explode('.', explode('<div class="alert alert-error">', $done)[1])[0];
$timr = explode('<', explode('id="timer">', $done)[1])[0];

// Tampilkan sesuai kondisi
if (isset($sukses) && !empty($sukses)) {
    print og.p.$sukses.cl.n;
    g();
    timer(300);
} else {
    print "❌ " . $error . "\n";
}
}


#$data = "action=claim&csrf_token=37626f7f7b7b9c12dc9aea5253380d70bf9305003d9ec717d9664e68ebf101d8&claim_nonce=1cfb5a2407d0a4d17b75da19704cf4ccee9b004041ce6131d57bdebfcb376e38&device_viewport_width=404&device_screen_width=404&device_touch_points=5&device_hover=0&device_fine_pointer=0&device_platform=Android&device_mobile_hint=1";

// $tes = get1($url);
// echo $tes;

#$mail = str_replace("@","%40",$email);
#$data = "action=claim&csrf_token=37626f7f7b7b9c12dc9aea5253380d70bf9305003d9ec717d9664e68ebf101d8&claim_nonce=1cfb5a2407d0a4d17b75da19704cf4ccee9b004041ce6131d57bdebfcb376e38&device_viewport_width=404&device_screen_width=404&device_touch_points=5&device_hover=0&device_fine_pointer=0&device_platform=Android&device_mobile_hint=1";