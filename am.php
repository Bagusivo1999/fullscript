<?php
// URL endpoint API
$url = "https://api.haidarxd.my.id/api/v1/alight-motion/auto?apikey=haidarapis-faba421cd1193de5ad880d53";

// Inisialisasi cURL
$ch = curl_init();

// Set opsi cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
]);

// Eksekusi request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error    = curl_error($ch);

curl_close($ch);

// Cek error
if ($error) {
    die("cURL Error: " . $error);
}

if ($httpCode !== 200) {
    die("HTTP Error: " . $httpCode);
}

// Decode JSON
$data = json_decode($response, true);

// Cek hasil decode
if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Error: " . json_last_error_msg());
}

// Tampilkan hasil
echo "=== Hasil API ===\n";
echo "Status     : " . $data['status'] . "\n";
echo "ApiCreator : " . $data['ApiCreator'] . "\n";
echo "Email      : " . $data['data']['email'] . "\n";
echo "Inbox URL  : " . $data['data']['inboxUrl'] . "\n";
echo "Expires At : " . $data['data']['expiresAt'] . "\n";

// Kalau mau format JSON rapi:
// echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);