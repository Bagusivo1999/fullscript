
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
const script = "earntycoon";
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

while (true) {
    bn();
    echo "1. Daftar web dulu\n";
    echo "2. Mulai jalankan script\n";
    echo "3. Exit\n";
    echo "Pilih [1-3]: ";
    
    $pilihan = trim(fgets(STDIN));

    switch ($pilihan) {
        case '1':
            system("xdg-open https://earntycoon-v.top/go?ref=kmyzvk");
            break;

        case '2':
            
            
            // === CONFIG ===
bn();
$token = Sav("bearer");
$tz = -420; // WIB = -420

// Header biar mirip browser
function head($token) {
    return [
        'Host: earntycoon.com',
        'authorization: '. $token,
        'Content-Type: application/json',  // ← TAMBAHKAN INI
        'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
        'referer: https://earntycoon.com/videos/',
        'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        'accept: application/json'  // ← TAMBAHKAN INI JUGA
    ];
}

// Fungsi cURL GET
function curl_get($url, $headers) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);
    #curl_close($ch);
    return json_decode($res, true);
}

// Fungsi cURL POST
function curl_post($url, $data, $headers) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // ← PASTIKAN INI
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // Tambahkan untuk debug
    #curl_setopt($ch, CURLOPT_VERBOSE, true);
    
    $res = curl_exec($ch);
    
    // Cek error curl
    if (curl_error($ch)) {
        echo "CURL Error: " . curl_error($ch) . "\n";
    }
    
    #curl_close($ch);
    return json_decode($res, true);
}

bn();


$url_balance = "https://earntycoon.com/api/wallet/balance";
$res_bal = curl_get($url_balance, head($token));

// Cek response
if ($res_bal['success']) {
    // Ambil coins dari data
    $coins = $res_bal['data']['coins'] ?? 0;
    $level = $res_bal['data']['level'] ?? 1;
    
    echo p."Balance: " . hijau1 . number_format($coins, 0, ',', '.');
}

// 1. AMBIL LIST VIDEO
// echo "[1] Ambil list video...\n";
$url_list = "https://earntycoon.com/api/video/list?tz=$tz";
$res_list = curl_get($url_list, head($token));

if (!$res_list['success']) {
    die(mr.p."Gagal ambil list: ".cl. json_encode($res_list). "\n");
}

$daily_limit = $res_list['data']['daily_limit'];
$claimed_today = $res_list['data']['claimed_today'];
echo p."     Daily: ".hijau1."$claimed_today/$daily_limit".cl.n;
while(true){
sleep(1);
$url_list = "https://earntycoon.com/api/video/list?tz=$tz";
$list = curl_get($url_list, head($token));
// Cari id yang claimed=false pertama
$idiklan = null;
foreach ($list['data']['playable'] as $v) {
    if ($v['claimed'] == false) {
        $idiklan = $v['id'];
        // echo "ID iklan ketemu: $idiklan\n";
        break;
    }
}

if (!$idiklan) {
    die("Semua iklan udah claimed hari ini\n");
}

// 2. AMBIL DETAIL VIDEO
// echo "\n[2] Ambil detail video...\n";
$url_detail = "https://earntycoon.com/api/video/detail?id=$idiklan&tz=$tz";
$res_detail = curl_get($url_detail, head($token));

if (!$res_detail['success']) {
    die("Gagal detail: ". json_encode($res_detail). "\n");
}

// Ambil id buat variabel $id
$id = $res_detail['data']['id'];
$duration = $res_detail['data']['duration_seconds'];
// echo "ID: $id | Durasi: {$duration}s\n";
g();
// 3. START VIDEO
// echo "\n[3] Start video...\n";
$url_start = "https://earntycoon.com/api/video/start";
$post_start = [
    "video_id" => $id,
    "tz" => $tz
];
$res_start = curl_post($url_start, $post_start, head($token));

if (!$res_start['success']) {
    die("Gagal start: ". json_encode($res_start). "\n");
}

// Ambil token + timer
$start_token = $res_start['data']['start_token'];
$timr = $res_start['data']['duration_required'];
// echo "Start token dapet\n";
timer($timr);
// 4. TUNGGU DURASI
// echo "\n[4] Nunggu durasi...\n";

// echo "\nSelesai nunggu\n";

// 5. CLAIM REWARD
// echo "\n[5] Claim reward...\n";
$url_claim = "https://earntycoon.com/api/video/claim";
$post_claim = [
    "video_id" => $id,
    "start_token" => $start_token
];
$res_claim = curl_post($url_claim, $post_claim, head($token));

if ($res_claim['success']) {
    echo og.p."✅ Claim sukses!".cl.n.n;
    // echo "Response: ". json_encode($res_claim['data']). "\n";
} else {
    echo "❌ Claim gagal: ";
    // json_encode($res_claim). "\n";
}

$url_balance = "https://earntycoon.com/api/wallet/balance";
$res_bal = curl_get($url_balance, head($token));

// Cek response
if ($res_bal['success']) {
    // Ambil coins dari data
    $coins = $res_bal['data']['coins'] ?? 0;
    $level = $res_bal['data']['level'] ?? 1;
    
    echo p."💰 Coins: " . hijau1 . number_format($coins, 0, ',', '.') . "       ";
}

$daily_limit = $res_list['data']['daily_limit'];
$claimed_today = $res_list['data']['claimed_today'];
echo p."Sisa ".hijau1."$claimed_today/$daily_limit".cl.n;
}
            
            break;

        case '3':
            break;

        default:
            echo "Pilihan nggak valid. Coba lagi ya\n";
            break;
    }
}