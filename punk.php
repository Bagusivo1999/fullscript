<?php
error_reporting(0);

const script = "punk";


// Ambil fungsi dari GitHub
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

$apikey = Sav("apikey xevil");
$url = "https://dogezone.xyz";

// ========== HEADER (versi lo) ==========
function head() {
    $headers = [];

    $headers[] = "Host: dogezone.xyz";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36";
    $headers[] = "Referer: https://dogezone.xyz/";
    $headers[] = "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";

    return $headers;
}

// ========== CURL FUNCTION ==========
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
        echo "cURL Error: " . curl_error($ch) . "\n";
        return false;
    }
    
    return $response;
}

// ========== CAPTCHA SOLVER ==========
function hjhhh($key) {
    global $apikey, $url;
    
    a:
    $r = curlGet("https://157.180.15.203/in.php?key=".$apikey."&method=hcaptcha&sitekey=".$key."&pageurl=".$url);
    
    if (strpos($r, 'OK|') === false) {
        goto a;
    }
    timer(5);
    $task = explode('OK|', $r)[1];
    echo $task . "\n";
    
    if($task) {
        while(true) {
            $r2 = curlGet("https://157.180.15.203/res.php?key=".$apikey."&action=get&id=".$task);
            
            if(strpos($r2, 'OK|') !== false) {
                $hasil = explode('OK|', $r2)[1];
                // Di dalam hjhhh(), sebelum return:
print "Raw captcha result: " . $hasil . n;
print "Captcha length: " . strlen($hasil) . n;
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


function ngen($key) {
    global $apikey, $url;
    
    a:
    // Encode URL biar aman
    $encodedUrl = urlencode($url);
    
    // Kirim pake file_get_contents (raw)
    $r = file_get_contents("https://api.sctg.xyz/in.php?key=".$apikey."&method=hcaptcha&sitekey=".$key."&pageurl=".$encodedUrl);
    
    if ($r === false) {
        echo "❌ Failed to connect to XEvil API\n";
        sleep(3);
        goto a;
    }
    
    if (strpos($r, 'OK|') === false) {
        echo "❌ Error sending captcha: $r\n";
        sleep(3);
        goto a;
    }
    
    timer(5);
    $task = explode('OK|', $r)[1];
    echo "Task ID: $task\n";
    
    if($task) {
        while(true) {
            // Cek hasil pake file_get_contents
            $r2 = file_get_contents("https://api.sctg.xyz/res.php?key=".$apikey."&action=get&id=".$task);
            
            if ($r2 === false) {
                echo "❌ Failed to check captcha result\n";
                sleep(3);
                continue;
            }
            
            if(strpos($r2, 'OK|') !== false) {
                $hasil = explode('OK|', $r2)[1];
                print $hasil . n.n.n;
                return $hasil;
                
            } elseif($r2 == "ERROR_CAPTCHA_UNSOLVABLE") {
                echo "❌ Captcha unsolvable, retrying...\n";
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

// ========== LOOP FOREVER ==========
echo "🚀 Script Running... Press Ctrl+C to stop\n\n";

$claimCount = 0;
$successCount = 0;
$failCount = 0;

while(true) {
    $claimCount++;
    echo "\n========== CLAIM #$claimCount ==========\n";
    echo date('Y-m-d H:i:s') . "\n";
    
    // 1. Ambil halaman
    $dash = get2($url);
    
    if (!$dash || empty($dash)) {
        echo "❌ Failed to get page!\n";
        $failCount++;
        timer(10);
        continue;
    }
    
    // 2. Extract sitekey & CSRF
    if (strpos($dash, 'data-sitekey="') !== false) {
        $key = explode('"', explode('data-sitekey="', $dash)[1])[0];
    } else {
        echo "❌ Sitekey not found!\n";
        $failCount++;
        timer(10);
        continue;
    }
    
    if (strpos($dash, 'name="session-token" value="') !== false) {
        $csrf = explode('"', explode('name="session-token" value="', $dash)[1])[0];
    } else {
        echo "❌ CSRF token not found!\n";
        $failCount++;
        timer(10);
        continue;
    }
    
    echo "CSRF: " . substr($csrf, 0, 20) . "...\n";
    echo "Sitekey: $key\n";
    
    // 3. Solve captcha
    $cap = ngen($key);
    
    if (!$cap || empty($cap)) {
        echo "❌ Failed to solve captcha!\n";
        $failCount++;
        timer(10);
        continue;
    }
    
    echo "Captcha: " . substr($cap, 0, 30) . "...\n";
    
    // 4. Prepare & send claim
    $data = "session-token=$csrf&address=bagusfildhonfatoni8%40gmail.com&antibotlinks=&captcha=hcaptcha&g-recaptcha-response=$cap&login=Verify+Captcha";
    
    $claim = post2($url, $data);
    
    // 5. Cek hasil
    // 5. Cek hasil
if (strpos($claim, 'Captcha was invaild') !== false || strpos($claim, 'alert alert-danger') !== false) {
    echo "❌ Captcha invalid!\n";
    $failCount++;
} elseif (strpos($claim, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode(' to', explode('<i class="fas fa-money-bill-wave"></i> ',$claim)[1])[0];
    echo "✅ SUCCESS! Claimed: $suc DOGE\n";
    $successCount++;
} elseif (strpos($claim, 'You have already claimed') !== false) {
    echo "⏳ Already claimed! Waiting 60s...\n";
    timer(60);
} else {
    echo "❌ Unknown response!\n";
    // Debug: print response
    echo "\n=== RESPONSE (first 1000 chars) ===\n";
    echo substr($claim, 0, 1000) . "\n";
    echo "=== END RESPONSE ===\n";
    $failCount++;
}
    
    // Status
    echo "📊 Success: $successCount | Failed: $failCount\n";
    
    // Cooldown
    echo "⏳ Waiting 60 seconds...\n";
    timer(60);
}