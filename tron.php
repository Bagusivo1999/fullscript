<?php
error_reporting(0);
// TronBlow Faucet Claim Script for Termux
// Run: php tronblow.php
const script = "tronblow.site";
// ========== YOUR CURL FUNCTION ==========
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);
bn();
$email = Sav("email");
// ========== HEADERS ==========
function head() {
    return [
        'Host: tronblow.site',
        'Content-Type: application/x-www-form-urlencoded',
        'Origin: https://tronblow.site',
        'Referer: https://tronblow.site/',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
        'Cookie: PHPSESSID=j709eross1b1g47l8h9g1gdea0'
    ];
}
bn();
while(true){
$data = "action=claim&math_q1=4&math_q2=1&math_op=-&email=".urlencode($email)."&math_answer=3";
$oke = post1("https://tronblow.site/?ref=bagusfildhonfatoni8%40gmail.com", $data);
$claim = explode(' wallet!</div>',explode('<div class="alert alert-success">',$oke)[1])[0];
echo mr.p.$claim.cl.n;
g();
$timr = explode(';',explode('var s=',$oke)[1])[0];
timer($timr);
}