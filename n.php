<?php

const script = "Kryptopulse";
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);
bn();

function head() {
    $url = 'https://kryptapulse.site/';
    
    $headers = [
        'Cache-Control: max-age=0',
        'Sec-Ch-Ua: "Chromium";v="137", "Not/A)Brand";v="24"',
        'Sec-Ch-Ua-Mobile: ?1',
        'Sec-Ch-Ua-Platform: "Android"',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'Sec-Fetch-Site: same-origin',
        'Sec-Fetch-Mode: navigate',
        'Sec-Fetch-User: ?1',
        'Sec-Fetch-Dest: document',
        'Referer: https://kryptapulse.site/',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cookie: $cookie'
    ];
    
    return [
        'url' => $url,
        'headers' => $headers
    ];
}