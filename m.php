<?php

function h($password, $saveFile) {
    $WHITE = "\033[1;37m";
    $GREEN = "\033[1;92m";
    $RED   = "\033[1;31m";
    $RESET = "\033[0m";

    $password = "jawapride99";
    $saveFile = "pw.txt";

    // Jika sudah pernah login
    if (file_exists($saveFile) && trim(file_get_contents($saveFile)) === $password) {
        return;
    }

    // Minta password
    echo $WHITE . "Password: " . $GREEN;
    $input = trim(fgets(STDIN));
    echo $RESET;

    if ($input === $password) {

        // Simpan password ke pw.txt
        file_put_contents($saveFile, $password);

        echo $GREEN . "Login berhasil. Selamat datang admin" . $RESET . PHP_EOL;
        sleep(3);

    } else {

        echo $RED . "Gagal. Password salah" . $RESET . PHP_EOL;
        exit;

    }
}

#h($password, $saveFile);

system('stty -icanon -echo');

$menu = [
    "=== SCRIPT FAUCET===" => [
        "Penghasil Ton" => "tron1.php",
        "Vitsplay" => "vits.php",
        "Cashclip" => "cash.php",
        "Cashclip 2" => "cash1.php",
        "Earntycoon" => "ty.php",
        "ngetes" => "tele.py"
        // "Earn Ltc Bot (comingsoon)" => ""
    ],
    "=== TOOLS SELAIN FAUCET ===" => [
        "AIO downloader (tiktok,soundcloud dll)" => "aio.php",
        "Tempmail (generate email)" => "email.php"
    ],
    "Exit" => "exit"
];

$flatMenu = [];
$fileMap = []; // mapping nama menu -> file

foreach($menu as $cat => $items){
    $flatMenu[] = $cat;
    if(is_array($items)){
        foreach($items as $nama => $file){
            $flatMenu[] = $nama;
            $fileMap[$nama] = $file; // simpan mappingnya
        }
    } else {
        $flatMenu[] = $cat;
        $fileMap[$cat] = $items; // untuk Exit
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
    $key = fread(STDIN, 3);

    if($key == "\033[A"){ // UP
        $selected--;
        if($selected < 0) $selected = count($flatMenu)-1;
    }
    elseif($key == "\033[B"){ // DOWN
        $selected++;
        if($selected >= count($flatMenu)) $selected = 0;
    }
    elseif(trim($key) == ''){ // ENTER
        $pilihan = $flatMenu[$selected];

        // Skip header kategori
        if(str_starts_with($pilihan, "===")){
            continue;
        }

        system('clear');
        system('stty sane');

        if($pilihan === "Exit"){
            exit("Sampai Jumpa!\n");
        }

        // Ambil file dari mapping, terus eval
        $file = $fileMap[$pilihan] ?? null;

if ($file) {

    // Jalankan file PHP
    if (str_ends_with($file, ".php")) {

        $function = file_get_contents($base . $file);

        if ($function !== false) {

            // Hapus BOM (jika ada)
            $function = preg_replace('/^\xEF\xBB\xBF/', '', $function);

            // Hapus tag <?php atau <?
            $function = preg_replace('/^\s*<\?(php)?\s*/i', '', $function);

            eval($function);

        } else {
            echo "Gagal load $file\n";
        }

    }

    // Jalankan file Python
    elseif (str_ends_with($file, ".py")) {

        $url = $base . $file;

        system("curl -s " . escapeshellarg($url) . " | python");

    }

    // Format tidak didukung
    else {
        echo "Format file tidak didukung: $file\n";
    }

} else {
    echo "Menu tidak ditemukan\n";
}

        system('stty -icanon -echo');
        echo "\n\nTekan Enter Untuk Kembali...";
        fgets(STDIN);
    }
}
