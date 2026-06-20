
error_reporting(0);
// TronBlow Faucet Claim Script for Termux
// Run: php tronblow.php
const script = "Penghasil Tron";
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

    echo "===== ".ob.p."MENU".cl." =====\n";
    echo h."[1]".cl." Tambah Email\n";
    echo h."[2]".cl." Jalankan Script\n";
    echo h."[3]".cl." Exit\n";
    echo "Pilih : ";

    $pilih = trim(fgets(STDIN));

    if($pilih == "1"){

        $jumlah = count(glob("email*")) + 1;

        $email = readline("Masukkan Email : ");

        file_put_contents("email".$jumlah, trim($email));

        echo "Berhasil disimpan ke email".$jumlah."\n";

    }elseif($pilih == "2"){

        $emails = [];

        foreach(glob("email*") as $file){
            $emails[] = trim(file_get_contents($file));
        }

        if(empty($emails)){
            echo "Belum ada email!\n";
            continue;
        }

        bn();

        while(true){

            $timers = [];

            foreach($emails as $no => $email){

    echo "[EMAIL ".($no+1)."]\n";
    

                $data = "action=claim"
                    ."&math_q1=4"
                    ."&math_q2=1"
                    ."&math_op=-"
                    ."&email=".urlencode($email)
                    ."&math_answer=3";

                $oke = post1("https://tronblow.site/?ref=bagusfildhonfatoni8%40gmail.com", $data);

                if(strpos($oke,'alert alert-success') !== false){

                    $claim = explode(
                        ' wallet!</div>',
                        explode('<div class="alert alert-success">',$oke)[1]
                    )[0];

                    echo og.p.$claim.cl.n;

                }else{

                    mr.p."Claim gagal atau cooldown".cl.n;

                }

                if(strpos($oke,'var s=') !== false){

                    $timr = (int) explode(
                        ';',
                        explode('var s=',$oke)[1]
                    )[0];

                    $timers[] = $timr;

                    echo "Timer : ".$timr." detik\n";

                }
g();
                // Jeda antar email
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