<?php

echo "=== Downloader MediaFire (aria2) ===\n\n";

echo "Masukkan link MediaFire: ";
$url = trim(readline());

if (empty($url)) {
    exit("URL tidak boleh kosong!\n");
}

$folder = "/sdcard/menu";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// Ambil HTML halaman MediaFire
$context = stream_context_create([
    "http" => [
        "header" => "User-Agent: Mozilla/5.0\r\n"
    ]
]);

$html = @file_get_contents($url, false, $context);

if (!$html) {
    exit("Gagal mengambil halaman MediaFire.\n");
}

// Cari direct download link
preg_match('/https:\/\/download[^"]+/', $html, $match);

if (!isset($match[0])) {
    exit("Direct download link tidak ditemukan.\n");
}

$direct = html_entity_decode($match[0]);

// Ambil nama file
$path = parse_url($direct, PHP_URL_PATH);
$filename = basename($path);

echo "\nNama File : $filename\n";
echo "Mengunduh...\n\n";

// Jalankan aria2
$cmd = "aria2c -x16 -s16 -k1M -c "
     . "-d " . escapeshellarg($folder)
     . " -o " . escapeshellarg($filename)
     . " " . escapeshellarg($direct);

passthru($cmd, $status);

if ($status == 0) {
    echo "\n✅ Selesai!\n";
    echo "Lokasi: $folder/$filename\n";
} else {
    echo "\n❌ Download gagal.\n";
}