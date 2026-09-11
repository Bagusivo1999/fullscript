<?php

echo "=== Downloader MediaFire (aria2) + Random Proxy ===\n\n";

echo "Masukkan link MediaFire: ";
$url = trim(readline());

if (empty($url)) {
    exit("URL tidak boleh kosong!\n");
}

// LIST PROXY LU - NANTI DI-ACAK OTOMATIS
$proxy_list = [
    "31.59.20.176:6754",
    "31.56.127.193:7684",
    "45.38.107.97:6014",
    "198.105.121.200:6462",
    "64.137.96.74:6641",
    "198.23.243.226:6361",
    "38.154.185.97:6370",
    "84.247.60.125:6095",
    "142.111.67.146:5611",
    "191.96.254.138:6185"
];

// Ambil 1 acak
$proxy_input = $proxy_list[array_rand($proxy_list)];

$folder = "/sdcard/menu";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// 1. Ambil HTML MediaFire pake proxy acak
$http_options = [
    "header" => "User-Agent: Mozilla/5.0\r\n",
    "proxy" => "tcp://". $proxy_input,
    "request_fulluri" => true
];

$context = stream_context_create(["http" => $http_options]);
$html = @file_get_contents($url, false, $context);

if (!$html) {
    // kalo gagal, coba proxy lain otomatis
    echo "Proxy $proxy_input mati, coba proxy lain...\n";
    $proxy_input = $proxy_list[array_rand($proxy_list)];
    $http_options['proxy'] = "tcp://". $proxy_input;
    $context = stream_context_create(["http" => $http_options]);
    $html = @file_get_contents($url, false, $context);
}

if (!$html) {
    exit("Gagal ambil halaman, semua proxy mati. Coba lagi.\n");
}

preg_match('/https:\/\/download[^"]+/', $html, $match);
if (!isset($match[0])) {
    exit("Direct link tidak ditemukan.\n");
}

$direct = html_entity_decode($match[0]);
$filename = basename(parse_url($direct, PHP_URL_PATH));

echo "\nNama File : $filename\n";
echo "Proxy Terpilih (acak) : $proxy_input\n";
echo "Mengunduh...\n\n";

// 2. Download aria2 pake proxy yang sama
$proxy_url = "http://". $proxy_input;
$proxy_args = "--http-proxy='$proxy_url' --https-proxy='$proxy_url' --all-proxy='$proxy_url' ";

$cmd = "aria2c -x16 -s16 -k1M -c "
   . $proxy_args
   . "-d ". escapeshellarg($folder)
   . " -o ". escapeshellarg($filename)
   . " ". escapeshellarg($direct);

passthru($cmd, $status);

if ($status == 0) {
    echo "\n✅ Selesai! $folder/$filename\n";
} else {
    echo "\n❌ Gagal, coba jalanin lagi nanti ganti proxy acak lagi.\n";
}