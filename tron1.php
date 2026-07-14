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

// ========== FUNGSI TEST PROXY ==========
function testProxy($proxy) {
    $ch = curl_init('https://httpbin.org/ip');
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res ? true : false;
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

// ========== FUNGSI POST DENGAN PROXY ==========
function postWithProxy($url, $data, $proxy) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, head());
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
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

        // ===== AMBIL PROXY =====
        echo "Mengambil proxy...\n";
        $proxies = getProxies();
        if(empty($proxies)){
            echo "Gagal ambil proxy! Lanjut tanpa proxy...\n";
            $proxies = [''];
        }else{
            echo "Dapat ".count($proxies)." proxy, testing...\n";
            // === JADI BEGINI (LANGSUNG PAKAI SEMUA) ===
$live = $proxies; 
echo "Pakai ".count($live)." proxy tanpa testing\n";
            if(empty($live)){
                echo "Semua proxy mati! Lanjut tanpa proxy...\n";
                $live = [''];
            }else{
                $proxies = $live;
                echo "Siap pakai ".count($proxies)." proxy\n";
            }
        }

        bn();

        while(true){
            $timers = [];

            foreach($emails as $no => $email){
                // ===== PILIH PROXY ACAK =====
                $proxy = $proxies[array_rand($proxies)];
                echo "[EMAIL ".($no+1)."] Proxy: $proxy\n";

                $data = "action=claim"
                    ."&math_q1=4"
                    ."&math_q2=1"
                    ."&math_op=-"
                    ."&email=".urlencode($email)
                    ."&math_answer=3";

                if(!empty($proxy)){
                    $oke = postWithProxy("https://tronblow.site/?ref=bagusfildhonfatoni8%40gmail.com", $data, $proxy);
                }else{
                    $oke = post1("https://tronblow.site/?ref=bagusfildhonfatoni8%40gmail.com", $data);
                }

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

            if(!empty($timers)){
                $wait = max($timers);
                timer($wait);
            }else{
                echo "\nTimer tidak ditemukan, tunggu 60 detik...\n";
                timer(60);
            }
        }

    }elseif($pilih == "3"){
        exit;
    }else{
        echo "Menu tidak tersedia!\n";
    }
}
?>