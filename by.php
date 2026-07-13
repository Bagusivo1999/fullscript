<?php
// ================================================================
// FINAL AUTO-BYPASS CAPTCHA SEO-TASK (Seo Images via Xevil API)
// SEMUA REQUEST MENGGUNAKAN cURL (TANPA file_get_contents)
// ================================================================

// --- KONFIGURASI ---
$html = 'https://seo-task.com/users_statistics";
$targetUrl = 'https://seo-task.com/job_youtube?area=view';
$apiKey    = 'pl2MZmkl6czGa3zkec2oLCR8IjVLZNor'; // <-- GANTI DENGAN API KEY ANDA
$cookieFile = 'proverca=1; partner=77971; ref_from=youtube.com; _ym_uid=1783683197844018705; _ym_d=1783683197; menu[users_adv]=0; menu[users_job]=1; hash_ref=747d5c07ec7d13fb79b13f7ba2d291b3; PHPSESSID=n639o7mqvt0pv1t7lj1jgn6v85; googtrans=null; googtrans=null';
$userAgent  = 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 Chrome/137.0.0.0 Mobile Safari/537.36';
$maxAttempts = 50; // 0 = tak terbatas
$delay       = 5;  // Jeda antar percobaan (detik)

// --- FUNGSI: GET HTML (dengan cookie) ---
function getHtml($url, $cookieFile, $userAgent) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $html = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    if (!$html) return false;
    return ['html' => $html, 'url' => $info['url']];
}

// --- FUNGSI: KIRIM GAMBAR KE API XEVIL (menggunakan cURL) ---
function sendToXevil($apiKey, $images) {
    $postFields = [
        'key'    => $apiKey,
        'method' => 'seoimages',
        'json'   => 1
    ];
    foreach ($images as $i => $b64) {
        $postFields["images[$i]"] = $b64;
    }

    // GANTI URL INI SESUAI DOKUMENTASI BOT ANDA
    $apiUrl = 'https://api.sctg.xyz/in.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $resp = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo "[!] cURL Error (send): $error\n";
        return false;
    }

    $data = json_decode($resp, true);
    if (!$data || !isset($data['request']) || $data['status'] != 1) {
        echo "[!] API Response (send): " . ($resp ?: "Empty") . "\n";
        return false;
    }
    return $data['request']; // Return Task ID
}

// --- FUNGSI: POLLING HASIL DARI API XEVIL (menggunakan cURL) ---
function pollXevil($apiKey, $taskId) {
    // GANTI URL INI SESUAI DOKUMENTASI BOT ANDA
    $apiUrl = "https://api.sctg.xyz/res.php";

    while (true) {
        sleep(3); // Jeda 3 detik setiap polling

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . "?key=" . $apiKey . "&action=get&id=" . $taskId . "&json=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            echo "[!] cURL Error (poll): $error\n";
            return false;
        }

        $data = json_decode($resp, true);
        if ($data['status'] == 1) {
            // Berhasil!
            return explode(',', $data['request']);
        } elseif ($data['status'] == 0) {
            echo ".";
            continue;
        } else {
            echo "\n[!] API Poll Gagal: " . ($data['request'] ?? 'Unknown') . "\n";
            return false;
        }
    }
}

// --- FUNGSI: SOLVE SEO IMAGES (Gabungan send + poll) ---
function solveSeoImages($html, $apiKey) {
    // 1. Ekstrak 6 gambar base64 dari HTML
    preg_match_all('/background-image:url\(data:image\/jpg;base64,([^)]+)\)/', $html, $matches);
    if (empty($matches[1])) return false;
    $images = $matches[1];

    // 2. Kirim ke API
    echo "[*] Mengirim 6 gambar ke API Xevil...\n";
    $taskId = sendToXevil($apiKey, $images);
    if (!$taskId) return false;
    echo "[+] Task ID: $taskId\n";

    // 3. Polling hasil
    echo "[*] Menunggu hasil...";
    $result = pollXevil($apiKey, $taskId);
    echo " SELESAI!\n";
    return $result;
}

// --- FUNGSI: POST JAWABAN KE SITUS (menggunakan cURL) ---
function postAnswer($url, $cookieFile, $userAgent, $checkedValues) {
    $postData = http_build_query(['capcha' => $checkedValues]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// --- FUNGSI: CEK APAKAH CAPTCHA SUDAH BERHASIL ---
function isSuccess($response) {
    if (strpos($response, 'out-capcha') === false) return true;
    if (strpos($response, 'Спасибо') !== false) return true;
    if (strpos($response, 'berhasil') !== false) return true;
    return false;
}

// ================================================================
// --- EKSEKUSI UTAMA (LOOP SAMPAI BERHASIL) ---
// ================================================================

echo "========================================\n";
echo "  AUTO-BYPASS SEOTASK (Seo Images) - cURL version\n";
echo "  Max attempts: " . ($maxAttempts ?: "Tak terbatas") . "\n";
echo "  Delay: $delay detik\n";
echo "========================================\n";


// --- CONTOH PENGGUNAAN DI LOOP UTAMA ANDA ---

// 1. Ambil halaman statistics (bisa url berbeda, tapi pakai fungsi getHtml yang sama)
$statUrl = 'https://seo-task.com/users_statistics';
$resultStats = getHtml($statUrl, $cookieFile, $userAgent);

if ($resultStats) {
    $userData = getUserData($resultStats['html']);
    
    if ($userData) {
        echo "[+] Username: " . $userData['username'] . "\n";
        echo "[+] User ID : " . $userData['user_id'] . "\n";
    } else {
        echo "[!] Gagal mendeteksi username/ID di halaman.\n";
    }
} else {
    echo "[!] Gagal mengambil halaman users_statistics.\n";
}

$attempt = 1;
while (true) {
    echo "\n[" . date('H:i:s') . "] Percobaan ke-$attempt\n";

    // 1. GET halaman
    echo "[*] Mengambil halaman...\n";
    $result = getHtml($targetUrl, $cookieFile, $userAgent);
    if (!$result) {
        echo "[!] Gagal mengambil halaman. Coba lagi...\n";
        sleep($delay);
        $attempt++;
        continue;
    }
    $html = $result['html'];
    $currentUrl = $result['url'];

    // 2. Cek apakah CAPTCHA masih ada
    if (strpos($html, 'out-capcha') === false) {
        echo "\n✅ CAPTCHA sudah tidak ada (mungkin sudah bypass sebelumnya).\n";
        break;
    }

    // 3. Kirim gambar ke API Xevil
    $apiResult = solveSeoImages($html, $apiKey);
    if (!$apiResult || empty($apiResult)) {
        echo "[!] API gagal atau timeout. Coba ulang...\n";
        sleep($delay);
        $attempt++;
        continue;
    }

    // 4. Ambil VALUE checkbox dari HTML
    preg_match_all('/<input[^>]+value="([^"]+)"[^>]+class="out-capcha-inp"[^>]*>/', $html, $inputs);
    $checkedValues = [];
    foreach ($apiResult as $idx) {
        $index = intval($idx) - 1; // API 1-based -> PHP 0-based
        if (isset($inputs[1][$index])) {
            $checkedValues[] = $inputs[1][$index];
            echo "[+] Akan mencentang gambar indeks ke-$idx (value: {$inputs[1][$index]})\n";
        }
    }

    if (empty($checkedValues)) {
        echo "[!] API mengembalikan indeks yang tidak valid. Coba ulang...\n";
        sleep($delay);
        $attempt++;
        continue;
    }

    // 5. POST jawaban
    echo "[*] Mengirim jawaban ke server target...\n";
    $response = postAnswer($currentUrl, $cookieFile, $userAgent, $checkedValues);

    // 6. Cek berhasil
    if (isSuccess($response)) {
        echo "\n✅ CAPTCHA BERHASIL DI-BYPASS pada percobaan ke-$attempt!\n";
        file_put_contents('success_response.html', $response);
        break;
    } else {
        echo "[!] Gagal. Server masih menampilkan CAPTCHA atau error.\n";
        file_put_contents("fail_response_$attempt.html", $response);
    }

    // 7. Batas percobaan
    $attempt++;
    if ($maxAttempts > 0 && $attempt > $maxAttempts) {
        echo "\n[!] Mencapai batas percobaan ($maxAttempts). Berhenti.\n";
        break;
    }

    echo "[*] Tunggu $delay detik sebelum percobaan berikutnya...\n";
    sleep($delay);
}

echo "\n===== SELESAI =====\n";
?>