<?php
error_reporting(0);
// TronBlow Faucet Claim Script for Termux
// Run: php tronblow.php
const script = "Penghasil Tron";
// ========== YOUR CURL FUNCTION ==========
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);
bn();
$email = Sav("email");

// ========== FUNGSI AMBIL PROXY ==========
function getProxies() {
    $html = @file_get_contents('https://free-proxy-list.net/');
    preg_match_all('/\d+\.\d+\.\d+\.\d+:\d+/', $html, $matches);
    return array_unique($matches[0] ?? []);
}

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

// ========== FUNGSI POST ==========
function postRequest($url, $data, $proxy = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if(!empty($proxy)) curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, head());
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// ========== FUNGSI COUNTDOWN ==========
function countdown($detik) {
    for($i = $detik; $i > 0; $i--){
        echo "\rTunggu $i detik...   ";
        sleep(1);
    }
    echo "\n";
}

bn();

while(true){
    echo "===== ".ob.p."MENU".cl." =====\n";
    echo h."[1]".cl." Tambah Email\n";
    echo h."[2]".cl." Jalankan Script\n";
    echo h."[3]".cl." Exit\n";
    echo "Pilih : ";

    $pilih = trim(fgets(STDIN));

    if($pilih == "1"){
        $jumlah = count(glob("email*.txt")) + 1;
        $email = readline("Masukkan Email : ");
        file_put_contents("email".$jumlah.".txt", trim($email));
        echo "Berhasil disimpan ke email".$jumlah.".txt\n";
        sleep(2);
        bn();

    }elseif($pilih == "2"){
        $emails = [];
        foreach(glob("email*.txt") as $file){
            $emails[] = trim(file_get_contents($file));
        }

        if(empty($emails)){
            echo "Belum ada email!\n";
            continue;
        }

        // ===== CEK PROXY DULU =====
        echo "🔍 Mengecek proxy...\n";
        $proxies = getProxies();
        $useProxy = false;

        if(!empty($proxies)){
            echo "✅ Ditemukan ".count($proxies)." proxy.\n";
            echo "Lanjutkan dengan proxy? (y/n) : ";
            $confirm = strtolower(trim(fgets(STDIN)));
            if($confirm == 'y'){
                $useProxy = true;
                echo "✅ Akan menggunakan proxy acak setiap claim.\n";
            } else {
                echo "❌ Lanjut tanpa proxy (pakai IP asli).\n";
            }
        } else {
            echo "⚠️ Tidak ada proxy ditemukan, lanjut tanpa proxy.\n";
        }

        sleep(1);
        bn();
        $lastRefresh = time();

        // ===== MULAI LOOP CLAIM =====
        while(true){
            // Refresh proxy setiap 1 jam (hanya jika pakai proxy)
            if($useProxy && time() - $lastRefresh > 3600){
                echo "⏳ Refreshing proxy list...\n";
                $proxies = getProxies();
                if(empty($proxies)) {
                    echo "⚠️ Proxy kosong, beralih tanpa proxy.\n";
                    $useProxy = false;
                }
                $lastRefresh = time();
                echo "Proxy updated (".count($proxies)." baru).\n";
            }

            $timers = [];

            foreach($emails as $no => $email){
                // Pilih proxy acak (jika useProxy aktif)
                $proxy = null;
                if($useProxy && !empty($proxies)){
                    $proxy = $proxies[array_rand($proxies)];
                    echo "[EMAIL ".($no+1)."] Proxy: $proxy\n";
                } else {
                    echo "[EMAIL ".($no+1)."] Tanpa Proxy\n";
                }

                $data = "action=claim"
                    ."&math_q1=4"
                    ."&math_q2=1"
                    ."&math_op=-"
                    ."&email=".urlencode($email)
                    ."&math_answer=3";

                $oke = postRequest("https://tronblow.site/?ref=bagusfildhonfatoni8%40gmail.com", $data, $proxy);

                if(strpos($oke,'alert alert-success') !== false){
                    $claim = explode(' wallet!</div>', explode('<div class="alert alert-success">',$oke)[1])[0];
                    echo og.p.$claim.cl.n;
                }else{
                    mr.p."Claim gagal atau cooldown".cl.n;
                }

                if(strpos($oke,'var s=') !== false){
                    $timr = (int) explode(';', explode('var s=',$oke)[1])[0];
                    $timers[] = $timr;
                    echo "Timer : ".$timr." detik\n";
                }
                g();
                sleep(1);
            }

            // Timer countdown
            if(!empty($timers)){
                $wait = max($timers);
                countdown($wait);
            }else{
                echo "\nTimer tidak ditemukan, tunggu 10 detik...\n";
                countdown(10);
            }
        }

    }elseif($pilih == "3"){
        exit;
    }else{
        echo "Menu tidak tersedia!\n";
    }
}
?>