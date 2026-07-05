<?php

const script = "punk";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);


$apikey = Sav("apikey xevil");

function curlGet($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0'
    ]);
    
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        return false;
    }
    
    curl_close($ch);
    return $response;
}

function head() {
    
    return [
        "host: dogezone.xyz",
        "user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36",
        "content-type: application/x-www-form-urlencoded"
        // "cookie: " . $cookie  // ✅ Bener: pake koma (,) soalnya masih di dalam array
    ];
}


$url = "https://dogezone.xyz";

function hjhhh($key) {
    global $apikey, $url;
    
    a:
    // Kirim pake cURL
    $r = curlGet("https://sctg.xyz/in.php?key=".$apikey."&method=hcaptcha&sitekey=".$key."&pageurl=".$url);
    
    if (strpos($r, 'OK|') === false) {
        goto a;
    }
    timer(5);
    $task = explode('OK|', $r)[1];
    echo $task . "\n";
   # sleep(5);
    
    if($task) {
        while(true) {
            $r2 = curlGet("https://sctg.xyz/res.php?key=".$apikey."&action=get&id=".$task);
            
            if(strpos($r2, 'OK|') !== false) {
                $hasil = explode('OK|', $r2)[1];
                print $hasil . n.n.n;
                return $hasil;
            } elseif($r2 == "ERROR_CAPTCHA_UNSOLVABLE") {
                goto a;
            } else {
                echo slow(merah2."prosess...                       \r",5000);
                sleep(3);
            }
        }
    } else {
        goto a;
    }
}




$dash = get2($url);
$key = explode('"', explode('data-sitekey="',$dash)[1])[0];
$csrf = explode('"', explode('name="session-token" value="',$dash)[1])[0];

$cap = hjhhh($key);

$data = "session-token=$csrf&address=bagusfildhonfatoni8%40gmail.com&antibotlinks=&captcha=hcaptcha&g-recaptcha-response=$cap&login=Verify+Captcha";

$claim = post2($url, $data);
$suc = explode(' to', explode('<i class="fas fa-money-bill-wave"></i> ',$claim)[1])[0];
print $suc . n; timer(60);