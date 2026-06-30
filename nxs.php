<?php

const script = "NXS MINING";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

function head() {
    return [
        'method' => 'GET',
        'url' => '/dashboard',
        'headers' => [
            'Host' => 'nxskoins.nxs.web.id',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Referer' => 'https://nxskoins.nxs.web.id/ads',
            'Sec-Ch-Ua' => '"Chromium";v="137", "Not/A)Brand";v="24"',
            'Sec-Ch-Ua-Mobile' => '?1',
            'Sec-Ch-Ua-Platform' => '"Android"',
            'Sec-Fetch-Site' => 'same-origin',
            'Sec-Fetch-Mode' => 'navigate',
            'Sec-Fetch-User' => '?1',
            'Sec-Fetch-Dest' => 'document',
            'Upgrade-Insecure-Requests' => '1'
        ]
    ];
}

$url= "https://nxskoins.nxs.web.id/dashboard";


print$dash = get($url);