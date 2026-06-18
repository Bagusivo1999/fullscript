
error_reporting(E_ALL);
function sock(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    sock();
const script = "Cashclip";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku");
eval($function);

bn();

$COOKIE_FILE = 'Cookie.json';
$ID_FILE = 'id.txt';
$DISCLAIMER_FILE = 'penting.txt'; // <-- pindah ke sini paling atas
$USER_AGENT = 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36';

function head(){
$HEADERS = [
    'Connection: keep-alive',
    'sec-ch-ua: "Chromium";v="137", "Not/A)Brand";v="24"',
    'sec-ch-ua-mobile:?1',
    'sec-ch-ua-platform: "Android"',
    'Upgrade-Insecure-Requests: 1',
    'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'Sec-Fetch-Site: cross-site',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-User:?1',
    'Sec-Fetch-Dest: iframe',
    'Referer: https://web.telegram.org/',
    'Accept-Encoding: gzip, deflate, br',
    'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
];
}



function loadingTimer($detik, $uid) {
    for ($i = $detik; $i >= 0; $i--) {
        $bar = str_repeat('█', $detik - $i). str_repeat('░', $i);
        echo "\r[$uid] Loading: [$bar] {$i}s ";
        sleep(1);
    }
    echo "\r". str_repeat(' ', 50). "\r";
}

function loadIds() {
    global $ID_FILE;
    if (!file_exists($ID_FILE)) return [];
    return array_filter(array_map('trim', file($ID_FILE)));
}

function jalanSekali($timerDetik = 0) {
    $ids = loadIds();
    if (empty($ids)) {
        echo "id.txt kosong\n";
        return;
    }

    foreach ($ids as $uid) {
        echo "Proses User ID: $uid\n";

        $html = get1("https://clipapp1.com/?id=$uid");
        if (!preg_match('/src="\/video\?id=(\d+)"/', $html, $match)) {
            echo "ID video tidak ditemukan untuk $uid\n";
            continue;
        }

        $videoId = $match[1];
        echo "Video ID: $videoId\n";

        curl1("https://clipapp1.com/video?id=$videoId");
        loadingTimer($timerDetik, $uid);

        $seen = get1("https://clipapp1.com/seen?id=$uid");
        echo "Result: $seen\n";
        g();
    }
}

function menu() {
    global $ID_FILE;
    while (true) {
        echo "\n=== MENU CLIPAPP ===\n";
        echo "1. Tambah User ID\n";
        echo "2. Jalan Auto Reload\n";
        echo "3. Klaim Timer Manual Loop\n";
        echo "4. Keluar\n";
        echo "Pilih: ";
        $pilih = trim(fgets(STDIN));

        if ($pilih == '1') {
            echo "Masukin User ID: ";
            $id = trim(fgets(STDIN));
            if (!empty($id)) {
                file_put_contents($ID_FILE, $id. PHP_EOL, FILE_APPEND);
                echo "ID $id berhasil disimpan ke $ID_FILE\n";
            }
        } elseif ($pilih == '2') {
        bn();
            echo "Mode auto reload 0s aktif. Ctrl+C buat stop\n";
            while (true) {
                jalanSekali(0);
                
            }
        } elseif ($pilih == '3') {
        bn();
            echo "Masukin detik timer: ";
            $detik = (int)trim(fgets(STDIN));
            if ($detik <= 0) $detik = 15;

            echo "Masukin delay antar loop detik: ";
            $delay = (int)trim(fgets(STDIN));
            if ($delay < 0) $delay = 5;

            echo "Mode timer $detik detik + delay $delay detik. Ctrl+C buat stop\n";
            while (true) {
                jalanSekali($detik);
                echo "Delay $delay detik sebelum loop...\n";
                sleep($delay);
            }
        } elseif ($pilih == '4') {
        bn();
            exit("Keluar\n");
        } else {
            echo "Pilihan ga valid\n";
        }
    }
}

menu();