<?php

const script = "makeyoutube";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

$cookie = Sav("cookie");

function head() {
global $cookie;
    return [
        "Host: makeyoutask.com",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36",
        "accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "cookie:" .$cookie
    ];
}


$dash = get("https://makeyoutask.com/youtubeviews");
print$timr = explode(' ', explode('Watch Time:', $dash)[1])[0];
$csrf = explode('"', explode('csrf-token" value="', $dash)[1])[0];
$sitekey = explode('"', explode('data-sitekey="', $dash)[1])[0];
echo $csrf; n;
echo $sitekey; n;
#timer($timr);

// $data = "
// $start = post('https://makeyoutask.com/youtubeviews/start_session', $data);