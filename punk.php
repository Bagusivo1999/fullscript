<?php

const script = "punk";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);


$key = Sav("apikey xevil");

function head() {
    global $cookie;
    return [
        "host: dogezone.xyz",
        "user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36",
        "content-type: application/x-www-form-urlencoded"
        // "cookie: " . $cookie  // ✅ Bener: pake koma (,) soalnya masih di dalam array
    ];
}



$url = "https://dogezone.xyz";

$dash = get2($url);
$site = explode('"', explode('data-sitekey="',$dash)[1])[0];
$csrf = explode('"', explode('name="session-token" value="',$dash)[1])[0];

hcap($key, $url);


$data = "session-token=$csrf&address=bagusfildhonfatoni8%40gmail.com&antibotlinks=&captcha=hcaptcha&g-recaptcha-response=$cap&login=Verify+Captcha";

$claim = post2($url, $data);
$csrf = explode(' to', explode('<i class="fas fa-money-bill-wave"></i> ',$claim)[1])[0];
