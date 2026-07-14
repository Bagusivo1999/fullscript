<?php
error_reporting(0);

// ========== FUNGSI TIMER ==========
function timerr($detik){
    while($detik > 0){
        $jam = floor($detik / 3600);
        $menit = floor(($detik % 3600) / 60);
        $second = $detik % 60;
        echo "\rTunggu : "
        .str_pad($jam, 2, "0", STR_PAD_LEFT).":"
        .str_pad($menit, 2, "0", STR_PAD_LEFT).":"
        .str_pad($second, 2, "0", STR_PAD_LEFT)." ";
        sleep(1);
        $detik--;
    }
    echo "\rLanjut proses...             \n";
}

const script = "vitsplay";

// ========== AMBIL CURL FUNCTION ==========
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);
bn();

// ========== AMBIL BEARER TOKEN ==========
$bearer = Sav("bearer vitsplay");
$bearer = trim($bearer);
$bearer = preg_replace('/^Bearer\s+/i', '', $bearer);

// ========== PROXY LIST WEBSHARE KAMU ==========
$proxyList = [
    'http://ovowmtjr:6b0k02su6xfc@31.59.20.176:6754',
    'http://ovowmtjr:6b0k02su6xfc@31.56.127.193:7684',
    'http://ovowmtjr:6b0k02su6xfc@45.38.107.97:6014',
    'http://ovowmtjr:6b0k02su6xfc@198.105.121.200:6462',
    'http://ovowmtjr:6b0k02su6xfc@64.137.96.74:6641',
    'http://ovowmtjr:6b0k02su6xfc@198.23.243.226:6361',
    'http://ovowmtjr:6b0k02su6xfc@38.154.185.97:6370',
    'http://ovowmtjr:6b0k02su6xfc@84.247.60.125:6095',
    'http://ovowmtjr:6b0k02su6xfc@142.111.67.146:5611',
    'http://ovowmtjr:6b0k02su6xfc@191.96.254.138:6185'
];

// ========== FUNGSI CURL DENGAN PROXY ==========
function curlWithProxy($url, $headers, $postData = null, $proxy = null) {
    $ch = curl_init($url);
    if(!empty($proxy)) curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if($postData !== null){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    }
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

bn();

// ========== MENU UTAMA ==========
echo an(p."1. No timer (resiko ban)".cl.n);
echo an(p."2. Timer custom".cl.n);
echo an(p."3. Exit".cl.n);
g();

$pilih = readline(p."Pilih Menu : ".hijau1);
g();

switch($pilih){
    case 1:
        $timer = 0;
        break;
    case 2:
        $menit = readline("Masukkan timer (detik): ");
        $timer = (int)$menit;
        break;
    case 3:
        exit;
    default:
        exit("Menu tidak valid\n");
}

// ========== TANYA PAKAI PROXY ATAU TIDAK ==========
echo "\nGunakan proxy? (y/n) : ";
$useProxy = (strtolower(trim(fgets(STDIN))) == 'y');

if($useProxy){
    echo "✅ Akan menggunakan proxy acak dari list.\n";
} else {
    echo "❌ Akan menggunakan IP asli.\n";
}
sleep(1);
bn();

// ========== LOOP UTAMA ==========
while(true){
    vpn();

    // --- CEK PROFIL ---
    $url = "https://vitsplay.id/api/auth.php?action=me";
    $headers = [
        "Authorization: Bearer $bearer",
        "User-Agent: Mozilla/5.0",
        "Accept: */*"
    ];

    $proxy = null;
    if($useProxy) $proxy = $proxyList[array_rand($proxyList)];

    $response = curlWithProxy($url, $headers, null, $proxy);
    $data = json_decode($response, true);

    if(isset($data['user'])){
        $id     = $data['user']['id'];
        $name   = $data['user']['name'];
        $email  = $data['user']['email'];
        $points = $data['user']['points'];
         
        echo hijau1;
        echo "\n";
        echo "User ID : $id\n";
        echo "Nama    : $name\n";
        echo "Email   : $email\n";
        echo "Points  : $points\n";
        echo n;
        if($useProxy) echo "Proxy   : $proxy\n";
    } else {
        echo "Data user tidak ditemukan\n";
    }
    g();
    vpn();

    // --- CLAIM REWARD ---
    $url = "https://vitsplay.id/api/user.php?action=add_rewards";
    $postData = [
        "points" => 500,
        "diamonds" => 0,
        "questions" => 1
    ];

    $headers = [
        "Authorization: Bearer $bearer",
        "Content-Type: application/json",
        "Origin: https://vitsplay.id",
        "Referer: https://vitsplay.id/home.html",
        "User-Agent: Mozilla/5.0",
        "Accept: */*"
    ];

    $response = curlWithProxy($url, $headers, $postData, $proxy);
    $result = json_decode($response, true);

    // === PERBAIKAN DETEKSI RESPON ===
    if(isset($result['ok']) && $result['ok'] == 1){
        echo hijau1."✅ Claim berhasil! +500 Points\n".n;
    } else {
        echo merah."❌ Claim gagal! Cek response:\n".n;
        print_r($result);
    }

    // --- TIMER ---
    if($timer > 0){
        echo "Menunggu ".$timer." detik...\n";
        timerr($timer);
    }
}
?>