<?php

error_reporting(E_ALL);

if (file_exists("Cookie.json")) {
    unlink("Cookie.json");
}

function head()
{
    return [
        'Connection: keep-alive',
        'sec-ch-ua: "Chromium";v="137", "Not/A)Brand";v="24"',
        'sec-ch-ua-mobile: ?1',
        'sec-ch-ua-platform: "Android"',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'Sec-Fetch-Site: cross-site',
        'Sec-Fetch-Mode: navigate',
        'Sec-Fetch-User: ?1',
        'Sec-Fetch-Dest: iframe',
        'Referer: https://web.telegram.org/',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
    ];
}

function curl1($url, $post = null, $httpheader = null, $proxy = null)
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HEADER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_COOKIEFILE => 'Cookie.json',
        CURLOPT_COOKIEJAR => 'Cookie.json',
        CURLOPT_TCP_KEEPALIVE => 1,
        CURLOPT_TCP_KEEPIDLE => 60,
        CURLOPT_TCP_KEEPINTVL => 60,
        CURLOPT_DOH_URL => 'https://dns.google/dns-query'
    ]);

    if ($post !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    if (!empty($httpheader)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    }

    if (!empty($proxy)) {
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
    }

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            'success' => false,
            'error' => $error
        ];
    }

    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

    $result = [
        'success' => true,
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        'headers' => substr($response, 0, $headerSize),
        'body' => substr($response, $headerSize)
    ];

    curl_close($ch);

    return $result;
}

function get1($url)
{
    $res = curl1($url, null, head());
    return $res['body'] ?? null;
}

function post1($url, $data)
{
    $res = curl1($url, $data, head());
    return $res['body'] ?? null;
}

/*
|--------------------------------------------------------------------------
| Contoh penggunaan
|--------------------------------------------------------------------------
*/
while(true){
$html = curl1(
    'https://clipapp1.com/?id=1820443547',
    null,
    head()
)['body'];

preg_match('/src="\/video\?id=(\d+)"/', $html, $match);

if (!isset($match[1])) {
    die("ID video tidak ditemukan\n");
}

$videoId = $match[1];

echo "Video ID: $videoId\n";

$videoResponse = curl1(
    "https://clipapp1.com/video?id={$videoId}",
    null,
    head()
);

 sleep(15);

$html = curl1(
    'https://clipapp1.com/seen?id=1820443547',
    null,
    head()
)['body'];

echo $html;
}