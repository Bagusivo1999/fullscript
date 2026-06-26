<?php
// Warna ANSI
$WHITE = "\033[1;37m";
$GREEN = "\033[1;92m";
$RED = "\033[1;31m";
$RESET = "\033[0m";

$password = "admin123"; // ganti password di sini

// Prompt putih + input hijau cerah
echo $WHITE . "Password: " . $GREEN;

// Baca input dari user
$input = trim(fgets(STDIN));

// Reset warna biar output normal
echo $RESET;

if ($input === $password) {
    echo $GREEN . "Login berhasil. Selamat datang admin" . $RESET . PHP_EOL; sleep(3);
    
    // taruh script admin di bawah sini
    
} else {
    echo $RED . "Gagal. Password salah" . $RESET . PHP_EOL; exit;
}

system('stty -icanon -echo');

$menu = [
    "=== SCRIPT FAUCET===" => [
        "Penghasil Ton" => "tron1.php",
        "Vitsplay" => "vits.php",
        "Cashclip" => "cash.php",
        "Cashclip 2" => "cash1.php",
        "BTC (comingsoon)" => ""
    ],
    "=== TOOLS SELAIN FAUCET ===" => [
        "AIO downloader (tiktok,soundcloud dll" => "aio.php"
    ],
    "Keluar" => "exit"
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

        if($pilihan === "Keluar"){
            exit("Sampai Jumpa!\n");
        }

        // Ambil file dari mapping, terus eval
        $function = file_get_contents($base . $file);

if ($function !== false) {

    // Hapus BOM (jika ada)
    $function = preg_replace('/^\xEF\xBB\xBF/', '', $function);

    // Hapus tag pembuka PHP
    $function = preg_replace('/^\s*<\?php\s*/i', '', $function);

    eval($function);

} else {
    echo "Gagal load $file\n";
}

        system('stty -icanon -echo');
        echo "Tekan Enter Untuk Kembali...";
        fgets(STDIN);
    }
}