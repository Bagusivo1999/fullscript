#!/usr/bin/php
<?php
// Contoh skrip untuk cek status API publik (legal)
echo "Masukkan nomor tujuan (untuk validasi format): ";
$nomor = trim(fgets(STDIN));

// Validasi sederhana (hanya contoh)
if (!preg_match('/^[0-9]{10,15}$/', $nomor)) {
    echo "Format nomor tidak valid!\n";
    exit;
}

// Contoh cek API publik (misal, cek nomor internasional)
$url = "https://api.cmnty.web.id/tools/spam-otp?nomer=" . urlencode($nomor);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
#curl_close($ch);

$data = json_decode($response, true);

// Ambil data
$author = $data['author'] ?? 'Tidak ada';
$status = $data['status'] ? 'Sukses' : 'Gagal';
$totalRounds = $data['result']['totalRounds'] ?? 0;

// Tampilkan
echo "Author: $author\n";
echo "Status: $status\n";
echo "Total Rounds: $totalRounds\n";
?>