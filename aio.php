

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
const script = "Aio Downloader";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

bn();


function namaFileAman($path)
{
    if (!file_exists($path)) {
        return $path;
    }

    $info = pathinfo($path);

    $i = 1;

    while (file_exists($info['dirname']."/".$info['filename']."_".$i.".".$info['extension'])) {
        $i++;
    }

    return $info['dirname']."/".$info['filename']."_".$i.".".$info['extension'];
}

function downloadFile($url, $path)
{
    $fp = fopen($path, 'w');

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_FILE => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0'
    ]);

    curl_exec($ch);

    #curl_close($ch);
    fclose($fp);
}

while (true) {
bn();

$link = readline(p."Masukkan URL : ".cl.g);

$api = "https://api.synoxcloud.xyz/download/all-in-one?url=" . urlencode($link);

echo og.p."Mengambil data...".cl.n;

$res = file_get_contents($api);

if (!$res) {
    exit(mr.p."Gagal mengambil data API".cl.n);
}

$json = json_decode($res, true);

if (!isset($json['status']) || !$json['status']) {
    exit("Link tidak valid atau API error\n");
}

$data = $json['result']['data'];

$id = $data['id'] ?? time();

$base = "/sdcard/aiodownloader";

if (!is_dir($base)) {
    mkdir($base, 0777, true);
}

$folder = $base;

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

echo "Author : " . hijau1 . ($data['author'] ?? '-') . cl . PHP_EOL;
echo "Title  : " . hijau1 . ($data['title'] ?? '-') .cl . PHP_EOL;
echo "Source : " . hijau1 . ($data['source'] ?? '-') . cl . PHP_EOL;
echo PHP_EOL;

/*
|--------------------------------------------------------------------------
| DOWNLOAD FOTO
|--------------------------------------------------------------------------
*/

$foto = 1;

foreach ($data['medias'] as $media) {

    if (($media['type'] ?? '') == 'image') {

        $file = namaFileAman($folder . "/foto_" . $foto . ".jpg");

        echo "[PHOTO] Download foto {$foto}\n";

        downloadFile($media['url'], $file);

        echo og.p."Tersimpan : $file".cl.n;

        $foto++;
    }
}

/*
|--------------------------------------------------------------------------
| DOWNLOAD VIDEO (HD NO WATERMARK PRIORITAS)
|--------------------------------------------------------------------------
*/

$videoUrl = null;

foreach ($data['medias'] as $media) {

    if (
        ($media['type'] ?? '') == 'video' &&
        ($media['quality'] ?? '') == 'hd_no_watermark'
    ) {
        $videoUrl = $media['url'];
        break;
    }
}

if (!$videoUrl) {

    foreach ($data['medias'] as $media) {

        if (
            ($media['type'] ?? '') == 'video' &&
            ($media['quality'] ?? '') == 'no_watermark'
        ) {
            $videoUrl = $media['url'];
            break;
        }
    }
}

if ($videoUrl) {

    $file = namaFileAman($folder . "/video.mp4");

    echo "[VIDEO] Download HD No Watermark\n";

    downloadFile($videoUrl, $file);

    echo oy.p."Tersimpan : $file".cl.n;
}

/*
|--------------------------------------------------------------------------
| DOWNLOAD AUDIO
|--------------------------------------------------------------------------
*/

$audio = 1;

foreach ($data['medias'] as $media) {

    if (($media['type'] ?? '') == 'audio') {

        $file = namaFileAman($folder . "/audio_" . $audio . ".mp3");

        echo "[AUDIO] Download audio {$audio}\n";

        downloadFile($media['url'], $file);

        echo ob.p."Tersimpan : $file".cl.n;

        $audio++;
    }
}

echo PHP_EOL;
echo "====================================\n";
echo og.p."SELESAI".cl.n;
echo oy.p."Lokasi : $folder".cl.n;
echo "====================================\n";


$ulang = strtolower(readline(mr.p."Ada lagi yang ingin diunduh? (y/n) :".cl." "));

if ($ulang != "y") {
    
    break;
}

echo PHP_EOL;
}