
<?php

function mem(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    mem();
// $folder = __DIR__; // Folder tempat bot.php berada

// $url = "https://www.mediafire.com/file/py6valn7pmagjlp/bot.php/file";

// $html = file_get_contents($url);

// preg_match('/https:\/\/download[^"]+/', $html, $m);

// if (!isset($m[0])) {
    // die("Link download tidak ditemukan\n");
// }

// $direct = html_entity_decode($m[0]);

// // Simpan dengan nama bot.php agar menimpa file lama
// $path = $folder . "/bot.php";

// system("curl -L " . escapeshellarg($direct) . " -o " . escapeshellarg($path));

// echo "\nBerhasil update:\n$path\n";


$folder = __DIR__; // Folder tempat bot.php berada

$url = "https://raw.githubusercontent.com/Bagusivo1999/fullscript/main/nxs.php";

// Langsung download, ga perlu preg_match
$path = $folder . "/tube.php"; // ganti nama file sesuai kebutuhan

system("curl -L " . escapeshellarg($url) . " -o " . escapeshellarg($path));

echo "\nBerhasil update:\n$path\n";