<?php
error_reporting(0);

function innnnn(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    innnnn();

$ADMIN_ID = "u0_a574"; 
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
    echo "║              ⚠️  MASA SEWA SERVER TELAH BERAKHIR  ⚠️                  ║\n";
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
    serverExpired();
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
    
];

//MENU TOOLS HURUF
$menu_tools = [
    "aio" => "aio.php",
    "init" => "init.py",
];

$base = "https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/";

// --- ANIMASI LOADING CONNECTING TO SERVER ---
function animasiLoading($duration = 3){
    echo "\033[1;36mConnecting to server\033[0m";
    $dots = ['.', '..', '...', '....'];
    $start = time();
    $i = 0;
    
    while(time() - $start < $duration){
        echo "\r\033[1;36mConnecting to server\033[0m" . $dots[$i % 4];
        $i++;
        usleep(200000); // 0.2 detik
    }
    echo "\r\033[1;32mConnected to server!    \033[0m\n";
    usleep(500000); // jeda sebentar
}


// --- FUNGSI TAMPILAN MENU ---
function tampilMenu($menu_faucet, $menu_tools){
animasiLoading(3);
system('clear');
    
    $colors = [
        "\033[1;31m", // Merah
        "\033[1;33m", // Kuning
        "\033[1;32m", // Hijau
        "\033[1;36m", // Cyan
        "\033[1;34m", // Biru
        "\033[1;35m", // Ungu
    ];
    
    // Banner tanpa spasi di tengah
    $banner = [
        "╔════════════════════════════════════════════════════╗",
        "║                                                    ║",
        "║         S E L A M A T   D A T A N G   👋           ║",
       "║                                                    ║",
        "╚════════════════════════════════════════════════════╝"
    ];
    
    // Smooth looping warna (pergeseran)
    for($i=0; $i<count($colors)*2; $i++){
        system('clear');
        
        // Loop baris banner
        for($row=0; $row<count($banner); $row++){
            $colorIndex = ($i + $row) % count($colors);
            echo $colors[$colorIndex] . $banner[$row] . "\033[0m\n";
        }
        
        // Tambahan garis bawah
        
        usleep(150000); // 0.15 detik (lebih smooth)
    }
    
   

    
    
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