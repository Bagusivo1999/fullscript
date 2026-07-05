<?php

const script = "punk";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

$cookie = Sav("cookie");

function head() {
    global $cookie;
    return [
        "host: litoshipay.com",
        "user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36",
        "content-type: application/x-www-form-urlencoded",
        "cookie: " . $cookie  // ✅ Bener: pake koma (,) soalnya masih di dalam array
    ];
}



$url = "https://litoshipay.com/dashboard";

$dash = get($url);
print $dash;