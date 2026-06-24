<?php

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

#$bearer = Sav("bearer");

function head() {
global $bearer;
    // 1. Bersihin spasi depan belakang
    $bearer = trim($bearer);
    
    // 2. Kalau ada prefix "Bearer " hapus, ambil tokennya aja
    if (stripos($bearer, 'Bearer ') === 0) {
        $bearer = substr($bearer, 7);
    }
    
    $headers = [
        'Host: earntycoon.com',
        'Cache-Control: max-age=0',
        'sec-ch-ua: "Chromium";v="137", "Not/A)Brand";v="24"',
        'authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6IiIsInVuaW9uX2lkIjoiNTkzOTI0NzY1NTY3NDUzMjcxIiwicHJvamVjdF9pZCI6ImtjeTdzcW55IiwiaWF0IjoxNzgyMjYwMzE3fQ.rTLLTM8l5C963finCjWgwPJPHe5kytKvH8y2nkx75F0 ', // token bersih disini
        'sec-ch-ua-mobile: ?1',
        'sec-ch-ua-platform: "Android"',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'sec-fetch-site: same-origin',
        'sec-fetch-mode: navigate',
        'sec-fetch-user: ?1',
        'sec-fetch-dest: document',
        'Referer: https://earntycoon.com/login',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
    ];
    return $headers;
}

// Cara pakai
$token_input = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6IiIsInVuaW9uX2lkIjoiNTkzOTI0NzY1NTY3NDUzMjcxIiwicHJvamVjdF9pZCI6ImtjeTdzcW55IiwiaWF0IjoxNzgyMjYwMzE3fQ.rTLLTM8l5C963finCjWgwPJPHe5kytKvH8y2nkx75F0';
$headers = head($token_input);

$ch = curl_init('https://earntycoon.com/dashboard');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
echo curl_exec($ch);

// Cara pakai


$get = get("https://earntycoon.com/videos");
echo$get = get("https://earntycoon.com/api/video/list?tz=-420");
$id = explode('"', explode('"id": "', $get)[1])[0];
$time = explode(',', explode('"duration_seconds": ', $get)[1])[0];
echo mr.p."mengambil data id $id".cl.r; sleep(2);

$data = '{"video_id":"$id","tz":-420}';
$stat = post("https://earntycoon.com/api/video/start", $data);
$timr = explode(',', explode('"duration_seconds": ', $get)[1])[0];
$tok = explode('"', explode('start_token":"', $get)[1])[0];
$id2 = explode('"', explode('video_id":"', $get)[1])[0];
timer($timr);

$data = '{"video_id":"$id2","start_token":"$tok"}';
$suc = post("https://earntycoon.com/api/video/claim", $data);
$claim = explode('"', explode('{"', $get)[1])[0];

$yup = get("https://earntycoon.com/account");
$bal = explode('<', explode('data-v-d05e2e08>Rp ',$yup)[1])[0];
echo $bal.n;