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

// --- CEK USER ---
if ($CURRENT_USER !== $ADMIN_ID) {
    maintenanceMode();
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
];

//MENU TOOLS HURUF
$menu_tools = [
    "aio" => "aio.php",
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
#animasiLoading(3);
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

    // CEK FAUCET (ANGKA)
    $found = false;
    $nomor = 1;
    foreach($menu_faucet as $nama => $file){
        if($input == $nomor){
            $found = true;
            $fileTujuan = $file;
            break;
        }
        $nomor++;
    }

    // CEK TOOLS (TEKS)
    if(!$found){
        foreach($menu_tools as $key => $desc){
            if($input === $key){
                $found = true;
                $fileTujuan = $key . ".php"; // aio.php, youtube.php, ig.php
                break;
            }
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
            echo "\033[1;33mMenjalankan script dari URL...\033[0m\n\n";
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