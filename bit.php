


function timerr($detik){

    while($detik > 0){

        $jam = floor($detik / 3600);
        $menit = floor(($detik % 3600) / 60);
        $second = $detik % 60;

        echo "\rTunggu : "
        .str_pad($jam, 2, "0", STR_PAD_LEFT).":"
        .str_pad($menit, 2, "0", STR_PAD_LEFT).":"
        .str_pad($second, 2, "0", STR_PAD_LEFT)." ";

        sleep(1);
        $detik--;
    }

    echo "\rLanjut proses...             \n";
}

const script = "vitsplay";
  
  
  $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku");
eval($function);


$bearer = Sav("bearer");

$bearer = trim($bearer);

$bearer = preg_replace('/^Bearer\s+/i', '', $bearer);

system("xdg-open https://youtube.com/@mode-gratis8");

bn();

echo n;
echo an(p."1. no timer (resiko ban)".cl.n);
echo an(p."2. timer 2 menit".cl.n);
echo an(p."3. timer custom".cl.n);
g();

$pilih = readline(n.p."Pilih Menu : ".hijau1);
g();
switch($pilih){

case 1:
    $timer = 0;
break;

case 2:
    $timer = 120; // 2 menit
break;

case 3:
    $menit = readline("Masukkan timer (detik): ");
    $timer = (int)$menit;
break;

default:
    exit("Menu tidak valid\n");
}

while(true){
vpn();
    $url = "https://vitsplay.id/api/auth.php?action=me";

    $headers = [
        "Authorization: Bearer $bearer",
        "User-Agent: Mozilla/5.0",
        "Accept: */*"
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    
    // curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['user'])) {

        $id     = $data['user']['id'];
        $name   = $data['user']['name'];
        $email  = $data['user']['email'];
        $points = $data['user']['points'];
         
        echo hijau1;
        echo "\n";
        echo "User ID : $id\n";
        echo "Nama    : $name\n";
        echo "Email   : $email\n";
        echo "Points  : $points\n";
        echo n;

    } else {
        echo "Data user tidak ditemukan\n";
    }
    g();
vpn();
    $url = "https://vitsplay.id/api/user.php?action=add_rewards";

    $postData = [
        "points" => 500,
        "diamonds" => 0,
        "questions" => 1
    ];

    $headers = [
        "Authorization: Bearer $bearer",
        "Content-Type: application/json",
        "Origin: https://vitsplay.id",
        "Referer: https://vitsplay.id/home.html",
        "User-Agent: Mozilla/5.0",
        "Accept: */*"
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    // curl_close($ch);

    if($timer > 0){
        echo "Menunggu ".$timer." detik...\n";
        timerr($timer);
    }
}
