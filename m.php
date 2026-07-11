<?php
error_reporting(0);

// --- SETUP TERMINAL AGAR NAVIGASI BERHASIL DI TERMUX ---
system('stty cbreak -echo');
system('clear');

// Tampilkan header
echo "\033[1;36m";
echo "╔════════════════════════════╗\n";
echo "║      MENU MODE GRATIS      ║\n";
echo "╚════════════════════════════╝\n\n";
echo "\033[0m";

// --- MENU ---
$menu = [
    "=== SCRIPT FAUCET===" => [
        "Penghasil Ton" => "tron1.php",
        "Vitsplay" => "vits.php",
        "Cryptoharvest" => "cryptoharvest.php",
        "Aruble" => "arub.php",
        "BTC" => "btc.py",
    ],
    "=== TOOLS SELAIN FAUCET ===" => [
        "AIO downloader (tiktok,soundcloud dll)" => "aio.php",
        "Tempmail (generate email)" => "email.php"
    ],
    "=== SCRIPT OPEN SOURCE ===" => [
        "Tubepay script" => "menu.php"
    ],
    "Keluar" => "exit"
];

$flatMenu = [];
$fileMap = []; 

foreach($menu as $cat => $items){
    $flatMenu[] = $cat;
    if(is_array($items)){
        foreach($items as $nama => $file){
            $flatMenu[] = $nama;
            $fileMap[$nama] = $file;
        }
    } else {
        $flatMenu[] = $cat;
        $fileMap[$cat] = $items;
    }
}

$selected = 0;
$base = "https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/";

function tampil($flatMenu, $selected){
    system('clear');
    echo "\033[1;36m";
    echo "╔════════════════════════════╗\n";
    echo "║      MENU MODE GRATIS      ║\n";
    echo "╚════════════════════════════╝\n\n";
    echo "\033[0m";

    foreach($flatMenu as $i => $item){
        if($i == $selected){
            echo "\033[42;30m ➤ $item \033[0m\n";
        }else{
            if(str_starts_with($item, "===")){
                echo "\033[90m   $item \033[0m\n";
            } else {
                echo "   $item\n";
            }
        }
    }
    echo "\n↑ ↓ = Navigasi | ENTER = Pilih\n";
}

while(true){
    tampil($flatMenu, $selected);
    
    // --- FIX NAVIGASI TERMUX (BACA 3 KARAKTER SEQUENTIAL) ---
    $key = '';
    $char = fread(STDIN, 1);
    if ($char === "\033") { // ESC
        $key .= $char;
        $char = fread(STDIN, 1);
        if ($char === '[') { // [
            $key .= $char;
            $char = fread(STDIN, 1);
            $key .= $char; // A atau B
        }
    } else {
        $key = $char; // ENTER biasanya karakter kosong atau \n
    }

    // Proses navigasi
    if($key === "\033[A"){ // UP
        $selected--;
        if($selected < 0) $selected = count($flatMenu)-1;
    }
    elseif($key === "\033[B"){ // DOWN
        $selected++;
        if($selected >= count($flatMenu)) $selected = 0;
    }
    elseif(trim($key) === '' || $key === "\n"){ // ENTER
        $pilihan = $flatMenu[$selected];

        if(str_starts_with($pilihan, "===")){
            continue;
        }

        system('clear');
        system('stty sane');

        if($pilihan === "Keluar"){
            exit("Sampai Jumpa!\n");     
        }

        $file = $fileMap[$pilihan] ?? null;

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

            // 2. JALANKAN PYTHON (FIX: DOWNLOAD DULU BIAR INTERAKTIF)
            elseif (str_ends_with($file, ".py")) {
                $url = $base . $file;
                $localFile = basename($file);

                echo "\033[1;33mMengunduh script $localFile...\033[0m\n";
                system("curl -s -o " . escapeshellarg($localFile) . " " . escapeshellarg($url));

                if (file_exists($localFile)) {
                    echo "\033[1;32mBerhasil, menjalankan Python...\033[0m\n\n";
                    system("python " . escapeshellarg($localFile));
                    unlink($localFile);
                } else {
                    echo "\033[1;31mGagal mengunduh file $localFile\033[0m\n";
                }
            }

            else {
                echo "Format file tidak didukung: $file\n";
            }

        } else {
            echo "Menu tidak ditemukan\n";
        }

        // Kembali ke menu
        system('stty cbreak -echo');
        echo "\n\nTekan Enter Untuk Kembali...";
        fgets(STDIN);
    }
}