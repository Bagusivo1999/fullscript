<?php
// ========== KONFIGURASI ==========
const script = "Diaxr.shop";

// ========== AMBIL CURL FUNCTION ==========
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);
// HANYA 1 KALI PANGGIL bn() DI SINI
bn();

// ========== PROXY LIST ==========
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

// ========== GLOBAL COOKIE / SESSION ==========
$globalCookie = null;

// ========== FUNGSI HEADER (MINING) ==========
function headMining($cookie = null) {
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
    if ($cookie) {
        $header[] = "cookie: $cookie";
    } else {
        // Default cookie kalau belum ada
        $header[] = 'cookie: PHPSESSID=blbcktu971malr6idbemle7fj1';
    }
    return $header;
}

// ========== FUNGSI GET ==========
function getWithHeader($url, $cookie = null, $proxy = null) {
    $header = headMining($cookie);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true); // Ambil header response untuk cookie baru
    if ($proxy) curl_setopt($ch, CURLOPT_PROXY, $proxy);
    $response = curl_exec($ch);
    // curl_close($ch);
    
    // Pisahkan header dan body
    list($headerRaw, $body) = explode("\r\n\r\n", $response, 2);
    return ['header' => $headerRaw, 'body' => $body];
}

// ========== FUNGSI POST ==========
function postWithHeader($url, $data, $cookie = null, $proxy = null) {
    $header = headMining($cookie);
    $header[] = 'content-type: application/x-www-form-urlencoded';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    if ($proxy) curl_setopt($ch, CURLOPT_PROXY, $proxy);
    $response = curl_exec($ch);
    // curl_close($ch);
    return $response;
}

// ========== FUNGSI AMBIL COOKIE DARI RESPONSE HEADER ==========
function extractCookie($headerRaw) {
    preg_match('/Set-Cookie: PHPSESSID=([^;]+)/', $headerRaw, $match);
    if (isset($match[1])) {
        return "PHPSESSID=" . $match[1];
    }
    return null;
}

// ========== FUNGSI MINING ==========
function getBalance($html) {
    preg_match('/<div class="col bal_coin">([0-9]+)<\/div>/', $html, $match);
    return $match[1] ?? 0;
}

function getMiningBalance($html) {
    preg_match('/<span id="tik" class="tik notranslate">([0-9.]+)<\/span>/', $html, $match);
    return $match[1] ?? 0;
}

function getKeyFromHtml($html) {
    preg_match('/name="key" value="([^"]+)"/', $html, $match);
    return $match[1] ?? null;
}

// ========== FUNGSI TAMBAH AKUN MANUAL ==========
function tambahAkunManual() {
    while (true) {
        echo "\n--- TAMBAH AKUN MANUAL ---\n";
        echo "Masukkan Username/Email (akun yang sudah terdaftar): ";
        $user = trim(fgets(STDIN));
        echo "Masukkan Password: ";
        $pass = trim(fgets(STDIN));
        
        $dataAkun = "$user|$user|$pass\n";
        file_put_contents("akun.txt", $dataAkun, FILE_APPEND);
        echo "✅ Akun berhasil disimpan ke akun.txt!\n";
        
        echo "\nTambah akun lagi? (y/n): ";
        $lagi = strtolower(trim(fgets(STDIN)));
        if ($lagi != 'y') {
            break;
        }
    }
}

// ========== FUNGSI DAFTAR VIA REFERRAL (BUKA BROWSER) ==========
function daftarViaReferral() {
    $refLink = "https://diaxr.shop/?ref=9851";
    
    bn();

    echo "      DAFTAR AKUN BARU    \n";
    g();
    echo "🔗 Link Referral: $refLink\n";
    echo "\n📢 Silakan daftar manual di browser Anda!\n";
    
    // Buka link di browser default (Windows/Linux/Mac)
    if (PHP_OS_FAMILY === 'Windows') {
        pclose(popen("start $refLink", "r"));
    } elseif (PHP_OS_FAMILY === 'Darwin') { // Mac
        system("open $refLink");
    } else { // Linux
        system("xdg-open $refLink");
    }
    
    echo "\n✅ Browser telah terbuka.\n";
    echo "📝 Setelah registrasi berhasil, gunakan Menu 3 untuk input akun Anda.\n";
    echo "\nTekan Enter untuk kembali ke menu utama...";
    fgets(STDIN);
}

// ========== FUNGSI MINING DARI AKUN (FIX LOGIKA PEKERJA) ==========
function gasMining($login, $pass, $proxy = null) {
    global $globalCookie;
    
    echo "🔐 LOGIN dengan $login...\n";
    
    // 1. GET halaman awal untuk ambil key dan cookie baru
    $getResult = getWithHeader("https://diaxr.shop", null, $proxy);
    $htmlAwal = $getResult['body'];
    $headerAwal = $getResult['header'];
    
    // Ambil cookie dari response header
    $cookie = extractCookie($headerAwal);
    if (!$cookie) {
        $cookie = "PHPSESSID=blbcktu971malr6idbemle7fj1"; // fallback
    }
    $globalCookie = $cookie;
    echo "✅ Cookie awal: $cookie\n";
    
    // Ambil key
    $key = getKeyFromHtml($htmlAwal);
    if (!$key) {
        echo "❌ Gagal ambil key login!\n";
        return;
    }
    echo "✅ Key login: $key\n";
    
    // 2. POST login
    $data = "email=$login&pass=$pass&sub_aut=&key=$key";
    $log = postWithHeader("https://diaxr.shop?pages=aut", $data, $cookie, $proxy);
    
    // 3. Cek login dengan mengambil balance
    $htmlGames = getWithHeader("https://diaxr.shop?pages=games", $cookie, $proxy);
    $cekBalance = getBalance($htmlGames['body']);
    
    if ($cekBalance == 0 && strpos($log, "Logout") === false) {
        echo "❌ LOGIN GAGAL! Akun tidak valid atau password salah.\n";
        echo "Response login: " . substr($log, 0, 200) . "...\n";
        return;
    }
    
    echo "✅ Login berhasil! Balance: $cekBalance\n";
    
    // ===== DATA PEKERJA (Sesuai screenshot) =====
    $personPrices = [
        'Alpha'     => 10,
        'Dragon'    => 20,
        'Hawk'      => 30,
        'Killer'    => 40,
        'Pugilist'  => 50,
        'Romeo'     => 75,
        'Shooter'   => 50,
        'Warrior'   => 150,
        'Casanova'  => 200,
        'Chieftain' => 250,
        'Detector'  => 500,
        'Beast'     => 1000
    ];
    
    // File status pekerja untuk akun ini
    $statusFile = "status_$login.txt";
    if (!file_exists($statusFile)) {
        $initStatus = [];
        foreach ($personPrices as $name => $price) {
            $initStatus[$name] = 0;
        }
        file_put_contents($statusFile, json_encode($initStatus));
    }
    bn();
    echo "⛏️ MULAI MINING OTOMATIS untuk $login...\n";
    g();
    
    while (true) {
        // Ambil data terbaru (pakai cookie yang sama)
        $htmlResult = getWithHeader("https://diaxr.shop?pages=games", $globalCookie, $proxy);
        $html = $htmlResult['body'];
        $key1 = getKeyFromHtml($html);
        $balance = getBalance($html);
        $miningBalance = getMiningBalance($html);
        
        echo "💰 Balance: " . number_format($balance) . "\n";
        echo "⛏️ Mining Balance: " . number_format($miningBalance, 4) . "\n";
        
        // ========== AUTO CLAIM MINING ==========
        if ($miningBalance >= 2.8) {
            echo "🚀 Collect mining...\n";
            $collectData = "key=$key1&games_sbor=1";
            $collectResult = postWithHeader("https://diaxr.shop?pages=games", $collectData, $globalCookie, $proxy);
            $htmlResult = getWithHeader("https://diaxr.shop?pages=games", $globalCookie, $proxy);
            $balance = getBalance($htmlResult['body']);
            $miningBalance = getMiningBalance($htmlResult['body']);
            echo "✅ Collect berhasil! Balance: $balance\n";
        }
        
        // ========== BACA STATUS PEKERJA ==========
        $statusData = file_get_contents($statusFile);
        $status = json_decode($statusData, true);
        
        $allOwned = true;
        foreach ($status as $name => $level) {
            if ($level < 1) {
                $allOwned = false;
                break;
            }
        }
        
        if ($allOwned) {
            echo "✅ SEMUA PEKERJA SUDAH DIBELI (Level >= 1)!\n";
            echo "💰 Fokus mengumpulkan uang untuk upgrade Beast (Harga 1000) jika belum.\n";
            echo "⏳ Tunggu 60 detik...\n";
            sleep(60);
            continue;
        }
        
        // ========== CARI PEKERJA TERMURAH YANG BELUM DIBELI ==========
        $targetName = null;
        $targetPrice = null;
        
        foreach ($personPrices as $name => $price) {
            if ($status[$name] < 1) {
                if ($targetPrice === null || $price < $targetPrice) {
                    $targetName = $name;
                    $targetPrice = $price;
                }
            }
        }
        
        if ($targetName !== null) {
            echo "🎯 Target beli: $targetName (Harga: $targetPrice)\n";
            
            if ($balance >= $targetPrice) {
                $buyData = "person=" . strtolower($targetName) . "&key=$key1&person_buy=true";
                $buyResult = postWithHeader("https://diaxr.shop?pages=games", $buyData, $globalCookie, $proxy);
                
                $status[$targetName] = 1;
                file_put_contents($statusFile, json_encode($status));
                
                echo "✅ Berhasil membeli $targetName!\n";
                
                $htmlResult = getWithHeader("https://diaxr.shop?pages=games", $globalCookie, $proxy);
                $balance = getBalance($htmlResult['body']);
                echo "💰 Sisa balance: " . number_format($balance) . "\n";
            } else {
                echo "⚠️ Balance tidak cukup untuk $targetName (Butuh: $targetPrice, Punya: $balance)\n";
                echo "⏳ Tunggu 30 detik...\n";
                sleep(30);
                continue;
            }
        }
        
        if ($status['Beast'] >= 1) {
            echo "🏆 BEAST SUDAH DIBELI! Misi selesai untuk akun ini.\n";
            echo "⏳ Tunggu 60 detik...\n";
            sleep(60);
            continue;
        }
        
        echo str_repeat("-", 60) . "\n";
        echo "⏳ Tunggu 30 detik ke iterasi berikutnya...\n";
        sleep(30);
    }
}

// ========== LOOP MENU UTAMA ==========
while (true) {
    // Tampilkan menu (tanpa memanggil bn() lagi agar tidak error)
    bn();
    echo "     DIAXR.SHOP AUTO TOOL\n";
    g();
    echo "1. Daftar Akun Baru (Buka Link Referral)\n";
    echo "2. Gas Mining (Login dari akun.txt)\n";
    echo "3. Tambah Akun Manual (Input Akun Sudah Terdaftar)\n";
    echo "4. Exit\n";
    g();
    echo "Pilih menu (1/2/3/4): ";
    $pilih = trim(fgets(STDIN));

    if ($pilih != '4') {
        echo "Gunakan proxy acak? (y/n): ";
        $useProxy = (strtolower(trim(fgets(STDIN))) == 'y');
        if ($useProxy) {
            $proxy = $proxyList[array_rand($proxyList)];
            echo "✅ Proxy: $proxy\n";
        } else {
            $proxy = null;
            echo "❌ IP asli\n";
        }
        echo "\n";
    }

    switch ($pilih) {
        case '1':
            daftarViaReferral();
            break;
        case '2':
            if (!file_exists("akun.txt")) {
                echo "❌ File akun.txt tidak ditemukan! Tambah akun dulu.\n"; sleep(2);
                break;
            }
            $akuns = file("akun.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (count($akuns) == 0) {
                echo "❌ Tidak ada akun di akun.txt!\n"; sleep(2);
                break;
            }
            echo "📋 Daftar akun:\n";
            foreach ($akuns as $i => $akun) {
                $data = explode("|", $akun);
                echo ($i + 1) . ". Username: " . $data[0] . "\n";
            }
            echo "\nPilih nomor akun (1 - " . count($akuns) . "): ";
            $no = (int)trim(fgets(STDIN));
            if ($no < 1 || $no > count($akuns)) {
                echo "❌ Nomor tidak valid!\n"; sleep(2);
                break;
            }
            $selected = explode("|", $akuns[$no - 1]);
            $login = trim($selected[0]);
            $pass = trim($selected[2]);
            echo "✅ Memilih akun: $login\n";
            gasMining($login, $pass, $proxy);
            break;
        case '3':
            tambahAkunManual();
            break;
        case '4':
            echo "Bye!\n";
            exit;
        default:
            echo "Menu tidak valid!\n";
            break;
    }
}
?>