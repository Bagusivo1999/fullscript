<?php
error_reporting(0);

function sock(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    sock();


function cekDanInstallFiglet() {
    // Cek apakah perintah figlet sudah ada
    $check = shell_exec("command -v figlet 2>/dev/null");
    if (empty($check)) {
        // echo "\033[1;33m[INFO] Figlet belum terinstall. Menginstall otomatis...\033[0m\n";
        // Install figlet via pkg (karena ini Termux)
        system("pkg update -y > /dev/null 2>&1");
        system("pkg install figlet -y > /dev/null 2>&1");
        // echo "\033[1;32m[SUKSES] Figlet berhasil diinstall!\033[0m\n\n";
    } else {
        // echo "\033[1;32m[INFO] Figlet sudah terinstall. Melewati install...\033[0m\n\n";
    }
}

cekDanInstallFiglet();

function maintenanceMode() {
    cekDanInstallFiglet(); // Pastikan figlet terinstall

    system('clear');

    // --- KOTAK BAGIAN ATAS (GARIS TEGAK) ---
    echo "\033[1;32m"; // Warna hijau terang
    echo "╔══════════════════════════════════════════════════════════════════════╗\n";
    echo "║          SISTEM SEDANG DALAM PERBAIKAN / MAINTENANCE                 ║\n";
    echo "╚══════════════════════════════════════════════════════════════════════╝\n";
    echo "\033[0m";

    // --- TULISAN "MAINTENANCE" BESAR KOTAK (NGEBLOCK) ---
    // Gunakan font 'block' (kotak tebal) + warna hijau neon
    echo "\033[1;92m";
    system("figlet -f smslant 'MAINTENANCE'");
    echo "\033[0m";

    // --- KOTAK STATUS DI TENGAH ---
    echo "\033[1;33m"; // Warna kuning
    echo "╔═══════════════════════════════════════════════════════╗\n";
    echo "║  STATUS : \033[1;31m[ MAINTENANCE ]\033[1;33m   │   SERVER : \033[1;31m[ OFFLINE ]\033[1;33m  ║\n";
    echo "╚═══════════════════════════════════════════════════════╝\n";
    echo "\033[0m";

    // --- GARIS PEMISAH ---
    echo "\033[1;35m"; // Warna ungu/magenta
    echo "════════════════════════════════════════════════════════════════════════\n";
    echo "\033[0m";

    // --- PESAN INFO ---
    echo "\033[1;37m"; // Warna putih
    echo " • Developer   : \033[1;32mMode Gratis - Bot\033[0m\n";
    echo " \033[1;37m• Alasan      : \033[1;33mUpdate Sistem & Perbaikan Bug\033[0m\n";

    // --- GARIS BAWAH ---
    echo "\033[1;35m";
    echo "════════════════════════════════════════════════════════════════════════\n";
    echo "\033[0m";

    // --- FOOTER ---
    echo "\033[1;31m";
    echo "  [ ! ] MOHON MAAF ATAS KETIDAKNYAMANANNYA.
    TERIMA KASIH ATAS PENGERTIANNYA ! [ ! ]\n";
    echo "\033[0m\n";

    exit;
}



// --- SETUP AWAL ---
system('clear');
maintenanceMode();
system('stty sane');

// --- MENU UTAMA ---
$menu = [
    "\033[1;37m=== SCRIPT FAUCET ===" => [
        "Penghasil Ton" => "tron1.php",
        "Vitsplay" => "vits.php",
        "Cryptoharvest" => "cryptoharvest.php",
        "Aruble" => "arub.php",
        "BTC" => "btc.py",
        "Gamerlee" => "gamerlee.py",
    ],
    
];

$base = "https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/";

// --- FUNGSI TAMPILAN MENU ---
function tampilMenu($menu, $totalMenu){
    system('clear');
    echo "\033[1;36m";
    echo "╔════════════════════════════╗\n";
    echo "║      MENU MODE GRATIS      ║\n";
    echo "╚════════════════════════════╝\n\n";
    echo "\033[0m";

    $nomor = 1;
    foreach($menu as $cat => $items){
        echo "\033[90m   $cat \033[0m\n";
        if(is_array($items)){
            foreach($items as $nama => $file){
                echo "   $nomor. $nama\n";
                $nomor++;
            }
        }
    }
    echo "   0. Keluar\n";
    
    echo "\n\033[1;33mKetik angka (0-$totalMenu) lalu ENTER:\033[0m ";
}

// --- LOOPING UTAMA ---
while(true){
    // Hitung total menu
    $totalMenu = 0;
    foreach($menu as $cat => $items){
        if(is_array($items)){
            $totalMenu += count($items);
        }
    }

    tampilMenu($menu, $totalMenu);
    
    // BACA INPUT ANGKA DARI USER
    $input = trim(fgets(STDIN));

    // CARI MENU BERDASARKAN ANGKA
    $pilihan = null;
    $fileTujuan = null;
    $nomor = 1;
    foreach($menu as $cat => $items){
        if(is_array($items)){
            foreach($items as $nama => $file){
                if($input == $nomor){
                    $pilihan = $nama;
                    $fileTujuan = $file;
                    break 2;
                }
                $nomor++;
            }
        }
    }

    // JIKA INPUT 0 -> KELUAR
    if($input === "0"){
        exit("\n\033[1;36mSampai Jumpa! 🚀\033[0m\n");     
    }

    // JIKA INPUT KOSONG ATAU TIDAK DITEMUKAN
    if(!$pilihan){
        echo "\n\033[1;31mPilihan tidak valid. (Ketik angka 0-$totalMenu)\033[0m";
        echo "\nTekan Enter untuk lanjut...";
        fgets(STDIN);
        continue;
    }

    // CLEAR SCREEN & RESET TERMINAL
    system('clear');
    system('stty sane');

    // AMBIL FILE
    $file = $fileTujuan ?? null;

    if ($file) {

        // 1. JALANKAN PHP
        if (str_ends_with($file, ".php")) {
            $function = file_get_contents($base . $file);
            if ($function !== false) {
                $function = preg_replace('/^\xEF\xBB\xBF/', '', $function);
                $function = preg_replace('/^\s*<\?(php)?\s*/i', '', $function);
                eval($function);
            } else {
                echo "Gagal load $file\n";
            }
        }

        // 2. JALANKAN PYTHON (TANPA DOWNLOAD, INTERAKTIF)
        elseif (str_ends_with($file, ".py")) {
            $url = $base . $file;
            
            echo "\033[1;33mMenjalankan script dari URL...\033[0m\n\n";
            system('stty sane');
            passthru("bash -c 'python <(curl -s " . escapeshellarg($url) . ")'");
            echo "\n\033[1;32mSelesai. (Kembali ke menu)\033[0m\n";
        }

        else {
            echo "Format file tidak didukung: $file\n";
        }

    } else {
        echo "Menu tidak ditemukan\n";
    }

    // KEMBALI KE MENU
    system('stty sane');
    echo "\n\n\033[1;33mTekan Enter untuk kembali ke menu...\033[0m";
    fgets(STDIN);
}