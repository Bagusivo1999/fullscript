<?php

const script = "freebonk";

function head() {
global $cookie;
    return [
        'headers' => [
            'Host' => 'free-bonk.com',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
            'Referer' => 'https://free-bonk.com/login',
            'Content-Type' => 'application/x-www-form-urlencoded', // untuk POST, opsional untuk GET
            'Cookie' => $cookie
        ],
        'method' => 'GET',
        'path' => '/dashboard',
        'protocol' => 'HTTP/2'
    ];
}

$url = "https://free-bonk.com/dashboard";


$dash = get($url);
print$bal = explodr(' ', explode'<h2 class="f-w-600">',$dash)[1])[0];

