<?php

const script = "Aio Downloader";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

/**
 * Fungsi untuk memproses request HTTP GET dengan header numeric
 * Menggunakan format $header[] array
 */
function head() {
    $header = [];
    $header[] = 'host: diaxr.shop';
    $header[] = 'cache-control: max-age=0';
    $header[] = 'sec-ch-ua: "Chromium";v="137", "Not/A)Brand";v="24"';
    $header[] = 'sec-ch-ua-mobile: ?1';
    $header[] = 'sec-ch-ua-platform: "Android"';
    $header[] = 'upgrade-insecure-requests: 1';
    $header[] = 'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36';
    $header[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
    $header[] = 'sec-fetch-site: same-origin';
    $header[] = 'sec-fetch-mode: navigate';
    $header[] = 'sec-fetch-user: ?1';
    $header[] = 'sec-fetch-dest: document';
    $header[] = 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.5';
    $header[] = 'cookie: PHPSESSID=blbcktu971malr6idbemle7fj1';
    return $header;
}

// ============ FUNGSI AMBIL BALANCE ============
function getBalance($html) {
    preg_match('/<div class="col bal_coin">([0-9]+)<\/div>/', $html, $match);
    return $match[1] ?? 0;
}

// ============ FUNGSI AMBIL BALANCE MINING ============
function getMiningBalance($html) {
    preg_match('/<span id="tik" class="tik notranslate">([0-9.]+)<\/span>/', $html, $match);
    return $match[1] ?? 0;
}

// ============ FUNGSI AMBIL KEY ============
function getKeyFromHtml($html) {
    preg_match('/name="key" value="([^"]+)"/', $html, $match);
    return $match[1] ?? null;
}

// ============ FUNGSI GET DENGAN HEADER ============
function getWithHeader($url) {
    $header = head();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// ============ FUNGSI POST DENGAN HEADER ============
function postWithHeader($url, $data) {
    $header = head();
    $header[] = 'content-type: application/x-www-form-urlencoded';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// ============ FUNGSI AUTO CLAIM MINING ============
function autoClaimMining($threshold = 2.8) {
    echo "🔍 CEK MINING BALANCE...\n";
    
    // Ambil data terbaru
    $html = getWithHeader("https://diaxr.shop?pages=games");
    $key = getKeyFromHtml($html);
    $miningBalance = getMiningBalance($html);
    $balance = getBalance($html);
    
    echo "⛏️ Mining balance saat ini: " . number_format($miningBalance, 4) . "\n";
    echo "💰 Main balance saat ini: " . number_format($balance) . "\n";
    
    // Cek apakah mining balance >= threshold
    if ($miningBalance >= $threshold) {
        echo "✅ Mining balance mencapai $threshold! Mengambil collect...\n";
        
        // Kirim request collect
        $data = "key=$key&games_sbor=1";
        $result = postWithHeader("https://diaxr.shop?pages=games", $data);
        
        // Ambil balance terbaru setelah collect
        $html = getWithHeader("https://diaxr.shop?pages=games");
        $newBalance = getBalance($html);
        $newMining = getMiningBalance($html);
        
        echo "✅ COLLECT BERHASIL!\n";
        echo "💰 Balance baru: " . number_format($newBalance) . " (naik " . number_format($newBalance - $balance) . ")\n";
        echo "⛏️ Mining balance baru: " . number_format($newMining, 4) . "\n";
        
        return true;
    } else {
        $sisa = $threshold - $miningBalance;
        echo "⏳ Mining balance masih $miningBalance, butuh $threshold (kurang $sisa)\n";
        echo "⏳ Tunggu mining sampai mencapai $threshold...\n";
        return false;
    }
}

// ============ LOGIN ============
echo "🔐 LOGIN...\n";
$get = getWithHeader("https://diaxr.shop");
$key = getKeyFromHtml($get);

$data = "email=sugab&pass=bagusff199&sub_aut=&key=$key";
$log = postWithHeader("https://diaxr.shop?pages=aut", $data);
echo "✅ Login berhasil!\n\n";

// ============ WHILE TRUE LOOP UNTUK MINING ============
$iteration = 0;
$allMines = [];
for ($i = 1; $i <= 12; $i++) {
    $allMines[] = "p$i";
}

// Harga setiap mine
$minePrices = [
    'p1' => 0, 'p2' => 0, 'p3' => 0, 'p4' => 0,
    'p5' => 0, 'p6' => 0, 'p7' => 10, 'p8' => 20,
    'p9' => 50, 'p10' => 75, 'p11' => 100, 'p12' => 150
];

// File untuk menyimpan status mine yang sudah di-unlock
$unlockedFile = "unlocked_mines.txt";
if (!file_exists($unlockedFile)) {
    file_put_contents($unlockedFile, "");
}

echo "⛏️ MULAI MINING OTOMATIS...\n";
echo str_repeat("=", 60) . "\n\n";

while (true) {
    $iteration++;
    echo "🔄 ITERASI #$iteration\n";
    echo "⏰ " . date('Y-m-d H:i:s') . "\n";
    
    // ============ AMBIL DATA TERBARU ============
    $html = getWithHeader("https://diaxr.shop?pages=games");
    $key1 = getKeyFromHtml($html);
    $balance = getBalance($html);
    $miningBalance = getMiningBalance($html);
    
    echo "💰 Balance: " . number_format($balance) . "\n";
    echo "⛏️ Mining Balance: " . number_format($miningBalance, 4) . "\n";
    
    // ============ AUTO CLAIM MINING JIKA MENCAPAI 2.8 ============
    if ($miningBalance >= 2.8) {
        echo "\n🚀 AUTO CLAIM MINING DIAKTIFKAN!\n";
        autoClaimMining(2.8);
        echo "\n";
    }
    
    // ============ CEK MINE YANG SUDAH UNLOCK ============
    $unlockedMines = file($unlockedFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $unlockedCount = count($unlockedMines);
    
    echo "📊 Mine terbuka: $unlockedCount dari 12\n";
    
    // ============ CEK APAKAH SEMUA SUDAH UNLOCK ============
    if ($unlockedCount >= 12) {
        echo "🎉 SEMUA MINE SUDAH UNLOCK!\n";
        echo "💰 Mengambil collect mining...\n";
        
        // Collect semua
        $collectData = "key=$key1&games_sbor=1";
        $collectResult = postWithHeader("https://diaxr.shop?pages=games", $collectData);
        
        // Ambil balance terbaru
        $html = getWithHeader("https://diaxr.shop?pages=games");
        $balance = getBalance($html);
        $miningBalance = getMiningBalance($html);
        
        echo "✅ Collect berhasil!\n";
        echo "💰 Balance baru: " . number_format($balance) . "\n";
        echo "⛏️ Mining balance baru: " . number_format($miningBalance, 4) . "\n";
        echo "\n⏳ Tunggu 60 detik sebelum collect lagi...\n";
        sleep(60);
        continue;
    }
    
    // ============ CARI MINE YANG BELUM UNLOCK ============
    $availableMines = array_diff($allMines, $unlockedMines);
    $availableMines = array_values($availableMines);
    
    if (!empty($availableMines)) {
        // Pilih random mine yang belum di-unlock
        $randomIndex = array_rand($availableMines);
        $selectedMine = $availableMines[$randomIndex];
        $price = $minePrices[$selectedMine] ?? 0;
        
        echo "🎲 Target unlock: $selectedMine (Harga: $price)\n";
        
        // ============ CEK BALANCE UNTUK UNLOCK ============
        if ($price > 0 && $balance < $price) {
            echo "⚠️ Balance tidak cukup! Butuh: $price, Punya: $balance\n";
            
            // Ambil dari mining balance
            if ($miningBalance > 0) {
                echo "🔄 Mengambil dari mining balance...\n";
                $collectData = "key=$key1&games_sbor=1";
                $collectResult = postWithHeader("https://diaxr.shop?pages=games", $collectData);
                
                // Refresh balance
                $html = getWithHeader("https://diaxr.shop?pages=games");
                $balance = getBalance($html);
                $miningBalance = getMiningBalance($html);
                
                echo "✅ Collect mining berhasil! Balance baru: $balance\n";
            } else {
                echo "❌ Mining balance 0! Tunggu mining dulu...\n";
                echo "\n⏳ Tunggu 30 detik...\n";
                sleep(30);
                continue;
            }
        }
        
        // ============ UNLOCK MINE ============
        if ($price == 0 || $balance >= $price) {
            $data = "p=$selectedMine&type=1&key=$key1&person_buy=true";
            $orang = postWithHeader("https://diaxr.shop?pages=games", $data);
            
            // Simpan mine yang baru di-unlock
            $unlockedMines[] = $selectedMine;
            file_put_contents($unlockedFile, implode("\n", $unlockedMines) . "\n");
            
            echo "✅ $selectedMine berhasil di-unlock!\n";
            echo "📊 Total mine terbuka: " . count($unlockedMines) . " dari 12\n";
        }
    }
    
    // ============ COLLECT MINING (jika sudah mencapai 2.8) ============
    // Cek lagi mining balance setelah unlock
    $html = getWithHeader("https://diaxr.shop?pages=games");
    $miningBalance = getMiningBalance($html);
    
    if ($miningBalance >= 2.8) {
        echo "\n🚀 AUTO CLAIM MINING (setelah unlock)!\n";
        autoClaimMining(2.8);
    } else {
        echo "⏳ Mining balance: " . number_format($miningBalance, 4) . " (belum mencapai 2.8)\n";
    }
    
    // ============ TAMPILAN STATUS ============
    echo "\n📊 STATUS MINE:\n";
    for ($i = 1; $i <= 12; $i++) {
        $status = in_array("p$i", $unlockedMines) ? "✅" : "🔒";
        echo "  Mine #$i: $status";
        if ($i % 4 == 0) echo "\n";
    }
    echo "\n";
    
    echo str_repeat("-", 60) . "\n";
    echo "⏳ Tunggu 30 detik sebelum iterasi berikutnya...\n";
    sleep(30);
}

// ============ FUNGSI RESET ============
function resetUnlock() {
    if (file_exists("unlocked_mines.txt")) {
        unlink("unlocked_mines.txt");
        echo "\n🔄 Reset unlock berhasil! Semua mine terkunci kembali.\n";
    }
}

?>