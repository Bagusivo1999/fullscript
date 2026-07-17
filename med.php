<?php
echo "bot pindah ke file ini ya bang🙏🏻\n";
$folder = "/sdcard/menu";


// Buat folder jika belum ada
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
    echo "Folder dibuat: $folder\n";
}

$url = "https://www.mediafire.com/file/lm5eu38d4kgnyu7/Insta+v15.25-SamMods.apk/file";

$html = file_get_contents($url);

preg_match('/https:\/\/download[^"]+/', $html, $m);

if (!isset($m[0])) {
    die("Link download tidak ditemukan\n");
}

$direct = html_entity_decode($m[0]);

$nama = basename(parse_url($direct, PHP_URL_PATH));

$path = $folder . "/" . $nama;

system("curl -L '$direct' -o '$path'");

echo "\nBerhasil disimpan:\n$path silahkan di cek😉\n";