<?php
// Warna buat CLI biar keren
$green = "\e[92m";
$cyan = "\e[96m";
$yellow = "\e[93m";
$reset = "\e[0m";

function headerMenu() {
    global $cyan, $reset;
    echo $cyan . "╔══════════════════════════╗\n";
    echo "║   WELCOME TO MY TOOLBOX  ║\n";
    echo "╚══════════════════════════╝\n" . $reset;
}

function clipsapp() {
    echo "🚀 Menjalankan ClipsApp...\n";
    sleep(2);
    $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/bot1.php");
eval($function);
}

function blabla() {
    echo "💬 Menjalankan Blabla...\n";
    echo "Fitur: chatbot lokal, auto reply\n";
}

// Menu utama
headerMenu();
echo "Pilih menu:\n";
echo "1. ClipsApp\n";
echo "2. Blabla\n";
echo "0. Keluar\n";

$pilih = readline("Masukin pilihan: ");

switch ($pilih) {
    case 1:
        clipsapp();
        break;
    case 2:
        blabla();
        break;
    case 0:
        echo "Bye!\n";
        exit;
    default:
        echo "Pilihan nggak ada bang\n";
}