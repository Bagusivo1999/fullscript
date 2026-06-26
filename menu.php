

$folder = __DIR__; // Folder tempat bot.php berada

$url = "https://www.mediafire.com/file/py6valn7pmagjlp/bot.php/file";

$html = file_get_contents($url);

preg_match('/https:\/\/download[^"]+/', $html, $m);

if (!isset($m[0])) {
    die("Link download tidak ditemukan\n");
}

$direct = html_entity_decode($m[0]);

// Simpan dengan nama bot.php agar menimpa file lama
$path = $folder . "/bot.php";

system("curl -L " . escapeshellarg($direct) . " -o " . escapeshellarg($path));

echo "\nBerhasil update:\n$path\n";