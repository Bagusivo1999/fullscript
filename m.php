<?php
error_reporting(0);

/*
 ============================================================
   🔓 SECURITY CHECK - NO RATE LIMIT
   Deteksi: Root, VPN, Interceptor, Bot, Scraper
   TANPA limit request, bebas pakai!
 ============================================================
*/

function ultimateSecurityCheck() {
    // ========================================
    // 1. DETEKSI ROOT
    // ========================================
    
    $root_files = [
        '/system/xbin/su',
        '/system/bin/su',
        '/system/sbin/su',
        '/data/local/xbin/su',
        '/data/local/bin/su',
        '/data/data/com.topjohnwu.magisk',
        '/system/app/Superuser.apk',
        '/system/app/SuperSU.apk'
    ];
    
    foreach($root_files as $file) {
        if(file_exists($file)) {
            killConnection("🚫 ROOT DETECTED - " . basename($file));
        }
    }
    
    // Cek su binary
    $su_check = shell_exec('2>/dev/null which su');
    if(!empty(trim($su_check))) {
        killConnection('🚫 SU BINARY FOUND');
    }
    
    // Cek user ID
    $uid = shell_exec('2>/dev/null id -u');
    if(trim($uid) === '0') {
        killConnection('🚫 ROOT USER (UID 0)');
    }
    
    // ========================================
    // 2. DETEKSI VPN
    // ========================================
    
    $interfaces = shell_exec('2>/dev/null ifconfig');
    $vpn_patterns = ['tun[0-9]', 'tap[0-9]', 'ppp[0-9]', 'utun', 'wg[0-9]'];
    foreach($vpn_patterns as $pattern) {
        if(preg_match('/' . $pattern . '/i', $interfaces)) {
            killConnection('🚫 VPN/TUNNEL DETECTED');
        }
    }
    
    // ========================================
    // 3. DETEKSI INTERCEPTOR (Reqable, Canary, dll)
    // ========================================
    
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $interceptor_ua = ['Reqable', 'Canary', 'HttpCanary', 'Charles', 'Fiddler', 
                       'Burp', 'mitmproxy', 'Postman', 'Insomnia'];
    
    foreach($interceptor_ua as $pattern) {
        if(stripos($ua, $pattern) !== false) {
            killConnection("🚫 INTERCEPTOR: $pattern");
        }
    }
    
    // ========================================
    // 4. DETEKSI BOT & SCRAPER
    // ========================================
    
    $bot_patterns = ['bot', 'crawl', 'spider', 'scraper', 'wget', 'curl',
                     'python', 'java', 'selenium', 'headless', 'puppeteer',
                     'autoclaim', 'auto claim', 'auto-bot'];
    
    foreach($bot_patterns as $pattern) {
        if(stripos($ua, $pattern) !== false) {
            killConnection("🚫 BOT/SCRAPER: $pattern");
        }
    }
    
    // ========================================
    // ❌ RATE LIMITING DIHAPUS
    // ========================================
    
    // ========================================
    // 5. GENERATE RANDOM KEY
    // ========================================
    
    $random_key = generateSecureKey();
    
    // ========================================
    // 6. SEMUA CEK BERHASIL
    // ========================================
    
    echo "\033[1;32m✅ SECURITY CHECK PASSED\033[0m\n";
    echo "\033[1;34m🔒 CONNECTION SECURED\033[0m\n\n";
    echo "\033[1;33m🔑 YOUR RANDOM KEY:\033[0m\n";
    echo "\033[1;36m" . $random_key . "\033[0m\n\n";
    
    return true;
}

// ==================== GENERATE RANDOM KEY ====================

function generateSecureKey($length = 32) {
    try {
        $bytes = random_bytes($length);
        $key = bin2hex($bytes);
    } catch (Exception $e) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    }
    
    $timestamp = date('YmdHis');
    $final_key = substr($key, 0, 16) . '_' . $timestamp . '_' . substr($key, -16);
    
    return $final_key;
}

// ==================== FUNGSI KILL ====================

function killConnection($reason) {
    $log = date('Y-m-d H:i:s') . " | BLOCKED | $reason | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'CLI') . "\n";
    @file_put_contents(__DIR__ . '/security.log', $log, FILE_APPEND);
    
    usleep(rand(500, 3000));
    
    echo "\033[1;31m" . str_repeat('=', 50) . "\033[0m\n";
    echo "\033[1;31m🚫 ACCESS DENIED\033[0m\n";
    echo "\033[1;33mReason: \033[0m" . $reason . "\n";
    echo "\033[1;37mTime: \033[0m" . date('Y-m-d H:i:s') . "\n";
    echo "\033[1;31m" . str_repeat('=', 50) . "\033[0m\n";
    exit(1);
}

// ==================== EKSEKUSI ====================

$result = ultimateSecurityCheck();

if($result) {
    // ============================================
    // 🎯 KODE APLIKASI ANDA DI SINI
    // ============================================
    
    echo "\033[1;32m========================================\n";
    echo "   🚀 SYSTEM READY - NO LIMIT\n";
    echo "========================================\033[0m\n\n";
    
    // Taro kode claim/bot Anda di sini
    echo "📡 Menghubungi server\n";
    
    // Contoh: Panggil fungsi utama Anda
    // sock(); // <-- Panggil fungsi claim Anda
     sleep(3);
}



ultimateSecurityCheck();

$ADMIN_ID = "u0_a474"; 
$CURRENT_USER = trim(shell_exec("whoami"));

function cekDanInstallFiglet() {
    $check = shell_exec("command -v figlet 2>/dev/null");
    if (empty($check)) {
        system("pkg update -y > /dev/null 2>&1");
        system("pkg install figlet -y > /dev/null 2>&1");
    }
}
cekDanInstallFiglet();

// --- MAINTENANCE MODE (KEMBALIKAN) ---
function maintenanceMode() {
    cekDanInstallFiglet();
    system('clear');

    echo "\033[1;32m";
    echo "╔══════════════════════════════════════════════════════════════════════╗\n";
    echo "║          SISTEM SEDANG DALAM PERBAIKAN / MAINTENANCE                 ║\n";
    echo "╚══════════════════════════════════════════════════════════════════════╝\n";
    echo "\033[0m";

    echo "\033[1;92m";
    system("figlet -f smslant 'MAINTENANCE'");
    echo "\033[0m";

    echo "\033[1;33m";
    echo "╔═══════════════════════════════════════════════════════╗\n";
    echo "║  STATUS : \033[1;31m[ MAINTENANCE ]\033[1;33m   │   SERVER : \033[1;31m[ OFFLINE ]\033[1;33m  ║\n";
    echo "╚═══════════════════════════════════════════════════════╝\n";
    echo "\033[0m";

    echo "\033[1;35m";
    echo "════════════════════════════════════════════════════════════════════════\n";
    echo "\033[0m";

    echo "\033[1;37m";
    echo " • Developer   : \033[1;32mMode Gratis - Bot\033[0m\n";
    echo " \033[1;37m• Alasan      : \033[1;33mUpdate Sistem & Perbaikan Bug\033[0m\n";

    echo "\033[1;35m";
    echo "════════════════════════════════════════════════════════════════════════\n";
    echo "\033[0m";

    echo "\033[1;31m";
    echo "  [ ! ] MOHON MAAF ATAS KETIDAKNYAMANANNYA. TERIMA KASIH ATAS PENGERTIANNYA ! [ ! ]\n";
    echo "\033[0m\n";

    exit;
}


function serverExpired() {
    cekDanInstallFiglet();
    system('clear');

    echo "\033[1;31m";
    echo "╔══════════════════════════════════════════════════════════════════════╗\n";
    echo "║              ⚠️  MASA SEWA SERVER TELAH BERAKHIR  ⚠️                 ║\n";
    echo "╚══════════════════════════════════════════════════════════════════════╝\n";
    echo "\033[0m";

    echo "\033[1;91m";
    system("figlet -f smslant 'EXPIRED'");
    echo "\033[0m";

    echo "\033[1;33m";
    echo "╔═════════════════════════════════════════════════════╗\n";
    echo "║  STATUS : \033[1;31m[ EXPIRED ]\033[1;33m   │   SERVER : \033[1;31m[ NONAKTIF ]\033[1;33m   ║\n";
    echo "║  SISA    : \033[1;31m[ 0 HARI ]\033[1;33m   │   AKTIF   : \033[1;31m[ TIDAK ]\033[1;33m     ║\n";
    echo "╚═════════════════════════════════════════════════════╝\n";
    echo "\033[0m";

    echo "\033[1;31m";
    echo "════════════════════════════════════════════════════════════════════════\n";
    echo "\033[0m";

    // Informasi detail
    echo "\033[1;37m";
    echo " ┌─────────────────────────────────────────────────────────────────┐\n";
    echo " │  📅 TANGGAL EXPIRED  : \033[1;31m" . date('Y-m-d H:i:s') . "\033[0m\n";
    echo " \033[1;37m│  ⏰ MASA AKTIF       : \033[1;33m" . hitungMasaAktif() . "\033[0m\n";
    echo " \033[1;37m│  💰 STATUS           : \033[1;31mBELUM DIPERPANJANG\033[0m\n";
    // echo " \033[1;37m│  📞 KONTAK          : \033[1;36m+62 812-3456-7890\033[0m\n";
    echo " \033[1;37m└─────────────────────────────────────────────────────────────────┘\n";
    echo "\033[0m";

    echo "\033[1;33m";
    echo "════════════════════════════════════════════════════════════════════════\n";
    echo "\033[0m";

    // Peringatan dengan efek berkedip (simulasi)
    echo "\033[1;31m";
    echo "  ⚡⚡⚡  PERINGATAN !!!  ⚡⚡⚡\n";
    echo "\033[0m";
    echo "\033[1;33m";
    echo "  SERVER TIDAK DAPAT DIAKSES KARENA MASA SEWA TELAH HABIS\n";
    echo "  SEGERA LAKUKAN PERPANJANGAN UNTUK MENGAKTIFKAN KEMBALI\n";
    echo "\033[0m";

    echo "\033[1;31m";
    echo "════════════════════════════════════════════════════════════════════════\n";
    echo "\033[0m";

    // Tombol aksi (simulasi)
    // echo "\033[1;32m";
    // echo "  [ 1 ] 🔄 PERPANJANG SEWA\n";
    // echo "  [ 2 ] 📞 HUBUNGI ADMIN\n";
    // echo "  [ 3 ] 🚪 KELUAR\n";
    // echo "\033[0m";

    // echo "\033[1;33m";
    // echo "  Pilih opsi (1-3): ";
    // echo "\033[0m";

    // // Simulasi input (opsional)
    // $input = trim(fgets(STDIN));
    
    // switch($input) {
        // case '1':
            // echo "\033[1;32m\n  Mengarahkan ke halaman perpanjangan...\n\033[0m";
            // // redirectToPerpanjangan();
            // break;
        // case '2':
            // echo "\033[1;36m\n  Menghubungi admin...\n\033[0m";
            // // hubungiAdmin();
            // break;
        // case '3':
        // default:
            // echo "\033[1;31m\n  Keluar dari sistem...\n\033[0m";
            // break;
    // }

    // // Catat ke log
    // logExpired("Server expired pada " . date('Y-m-d H:i:s'));

    exit;
}

// Fungsi tambahan untuk menghitung masa aktif
function hitungMasaAktif() {
    // Contoh: hitung dari tanggal aktivasi (misal 30 hari)
    $tanggalAktif = strtotime('2026-06-19'); // Contoh tanggal aktif
    $tanggalSekarang = time();
    $selisih = floor(($tanggalSekarang - $tanggalAktif) / (60 * 60 * 24));
    
    if ($selisih < 0) {
        return "Aktif (sisa " . abs($selisih) . " hari)";
    } else {
        return "Kedaluwarsa (" . $selisih . " hari)";
    }
}

// Fungsi log expired
function logExpired($message) {
    $logFile = "expired_log.txt";
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] $message\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}



// --- CEK USER ---
if ($CURRENT_USER !== $ADMIN_ID) {
    #serverExpired();
}

function wal(){
    system("clear");
    echo "\033[1;36m";
    echo "╔════════════════════════════╗\n";
    echo "║      MENU MODE GRATIS      ║\n";
    echo "╚════════════════════════════╝\n\n";
    echo "\033[0m";
}

// --- SETUP AWAL ---
system('clear');
system('stty sane');

// --- MENU FAUCET (ANGKA) ---
$menu_faucet = [
    "Penghasil Ton (PHP)" => "tron.php",
    "Vitsplay (PHP) with proxy" => "vits.php",
    "Aruble (PHP)" => "arub.php",
    "Voltly Earn (PYTHON)" => "voly.py",
    "Shard earn (PYTHON)" => "shard.py",
    "Pepe search (PHP)" => "pepe.php",
    
];

//MENU TOOLS HURUF
$menu_tools = [
    "aio" => "aio.php",
    "init" => "init.py",
];

$base = "https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/";

// --- ANIMASI LOADING CONNECTING TO SERVER ---


// --- FUNGSI TAMPILAN MENU ---
function tampilMenu($menu_faucet, $menu_tools){
system('clear');

    
    
    echo "\033[1;36m";
    echo "╔════════════════════════════╗\n";
    echo "║      MENU MODE GRATIS      ║\n";
    echo "╚════════════════════════════╝\n\n";
    echo "\033[0m";

    echo "\033[90m=== FAUCET / PENGHASIL ===\033[0m\n";
    $nomor = 1;
    foreach($menu_faucet as $nama => $file){
        echo "   $nomor. $nama\n";
        $nomor++;
    }
    echo "\n";
    
    echo "\033[90m=== TOOLS / DOWNLOADER ===\033[0m\n";
    echo "   aio  - Downloader All-in-One (TikTok, IG, dll)\n";
    echo "   init  - Init data extractor\n";
    
    echo "   0. Keluar\n";
    
    echo "\n\033[1;33mMasukkan pilihan (angka/teks) lalu ENTER:\033[0m ";
}

// --- LOOPING UTAMA ---
while(true){
    tampilMenu($menu_faucet, $menu_tools);
    
    $input = trim(fgets(STDIN));
    $input = strtolower($input);

    // KELUAR
    if($input === "0"){
        wal();
        exit("\n\033[1;38mSAMPAI JUMPA! 🚀\033[0m\n");     
    }

    // --- MENU TOOLS HURUF ---

// ... kode lain

// CEK FAUCET (ANGKA)
$found = false;
$fileTujuan = null;
$nomor = 1;
foreach($menu_faucet as $nama => $file){
    if($input == $nomor){
        $found = true;
        $fileTujuan = $file;
        break;
    }
    $nomor++;
}

// CEK TOOLS (TEKS) - BAGIAN INI YANG DIUBAH
if(!$found){
    if(isset($menu_tools[$input])){ // cek apakah input ada di key menu_tools
        $found = true;
        $fileTujuan = $menu_tools[$input]; // ambil nama file dari value array
    }
}

// JIKA TIDAK DITEMUKAN
if(!$found){
    echo "\n\033[1;31mPilihan tidak valid!\033[0m";
    echo "\nTekan Enter untuk lanjut...";
    fgets(STDIN);
    continue;
}

    // CLEAR SCREEN
    system('clear');
    system('stty sane');

    // JALANKAN SCRIPT
    if ($fileTujuan) {
        $url = $base . $fileTujuan;
        
        if (str_ends_with($fileTujuan, ".php")) {
            $function = file_get_contents($url);
            if ($function !== false) {
                $function = preg_replace('/^\xEF\xBB\xBF/', '', $function);
                $function = preg_replace('/^\s*<\?(php)?\s*/i', '', $function);
                eval($function);
            } else {
                echo "Gagal ambil data dari server\n";
            }
        }
        elseif (str_ends_with($fileTujuan, ".py")) {
            
            system('stty sane');
            passthru("bash -c 'python <(curl -s " . escapeshellarg($url) . ")'");
            echo "\n\033[1;32mSelesai. (Kembali ke menu)\033[0m\n";
        }
        else {
            echo "Format file tidak didukung: $fileTujuan\n";
        }
    }

    // KEMBALI KE MENU
    system('stty sane');
    echo "\n\n\033[1;33mTekan Enter untuk kembali ke menu...\033[0m";
    fgets(STDIN);
}