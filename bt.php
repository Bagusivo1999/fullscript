
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
const 
script = "NATICCRYPTO",
url = "naticrypto.com",
cookie = 1;
const
func_ver = "5.0",
res = "\033[0m",
hitam = "\033[0;30m",
abu2 = "\033[1;30m",
putih = "\033[0;37m",
putih2 = "\033[1;37m",
red2 = "\033[1;31m",
green = "\033[0;32m",
green2 = "\033[1;32m",
yellow = "\033[0;33m",
yellow2 = "\033[1;33m",
blue = "\033[0;34m",
blue2 = "\033[ 1;34m",
lblue = "\033[0;36m",
lblue2 = "\033[1;36m",
hijau  =  "\33[0;32m",
hijau1  =  "\33[32;1m",
biru  =  "\33[0;36m",
biru1  =  "\33[36;1m",
merah  =  "\33[31;1m",
merah2  =  "\e[1;31m",
putih1  =  "\e[1;37m",
kuning  =  "\33[33;1m",
kuning1  =  "\33[1;33m",
kuning2  =  "\e[1;33m",
cyan  =  "\e[0;36m",
cyan1  =  "\e[1;36m",
ungu  =  "\e[0;35m",
ungu2  =  "\e[1;35m",
abu  = 	"\e[0;33m",
abu1  =  "\e[0;37m",
p = "\033[1;37m",
red = "\033[0;31m",
h = "\033[1;32m",
k = "\033[1;33m",
purple = "\033[0;35m",
purple2 = "\033[1;35m",
off  =  "\033[102m",
cl = "\033[0m",      
Black = "\033[0;30m",                   
Cyan = "\033[0;36m",       
White = "\033[0;37m",       
IYellow = "\033[0;93m",      
IRed = "\033[0;91m",         
BIRed = "\033[1;91m",   
oc = "\033[46m",
BIWhite = "\033[1;97m",    
BICyan = "\033[1;96m",       
BIBlack = "\033[1;90m",     
BBlack = "\033[1;30m",
IBlack = "\033[0;90m",  
ow = "\033[47m",     
BIBlue = "\033[1;94m",
On_IRed = "\033[0;101m",
mr  =  "\033[41m",   
ob = "\033[44m",
og  = "\033[42m",  
IGreen = "\033[0;92m", 
oy = "\033[43m",  
ou = "\033[45m",  
// Underline
UBlack = "\033[4;30m",
URed = "\033[4;31m",
UGreen = "\033[4;32m",
UYellow = "\033[4;33m",
UBlue = "\033[4;34m",
UPurple = "\033[4;35m",
UCyan = "\033[4;36m",
UWhite = "\033[4;37m",
//red to yellow shade ↓
r3 = "\033[01;38;5;196m",
r2 = "\033[01;38;5;202m",
r1 = "\033[01;38;5;208m",
ry = "\033[01;38;5;214m",
y1 = "\033[01;38;5;220m",
y2 = "\033[01;38;5;226m",
y3 = "\033[01;38;5;228m",
ireng  = "\033[0;100m",   # Black
ired = "\033[0;101m",     # Red
igreen = "\033[0;102m",   # Green
ikuning = "\033[0;103m",  # Yellow
ibiru = "\033[0;104m",    # Blue
iungu = "\033[10;95m",  # Purple
icyan = "\033[0;106m",    # Cyan
iputih = "\033[0;107m", # White
t = "\t",
r = "\r                                             \r",
n = "\n";


function Sav($namadata){
     if(file_exists($namadata)){
       $data = file_get_contents($namadata);
      }else{
        $data = readline(p."Input ".$namadata." :  ".h);
        file_put_contents($namadata,$data);
      }
      return $data;
    }

function slow($str,$t){
$arr = str_split($str);
foreach ($arr as $az){
echo $az;
usleep($t);
}
}

function timer($t){
     $timr=time()+$t;
      while(true):
      echo "\r                                                    \r";
      $res=$timr-time();
      if($res < 1){break;}
if($res==$res){
//  $str= str_repeat("\033[1;92m◼",$res)."              \r";
}
      echo "\033[1;97mPlease Wait \033[1;91m".date('i:s',$res)." ";
      sleep(1);
      endwhile;
}

function curl1($url, $post = 0, $httpheader = 0, $proxy = 0){
vpn();
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_DOH_URL, 'https://dns.google/dns-query');        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
#curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_COOKIE,TRUE);
        curl_setopt($ch, CURLOPT_TCP_KEEPALIVE, true);
curl_setopt($ch, CURLOPT_TCP_KEEPIDLE, 60); // Waktu dalam detik sebelum mengirim pesan PING
curl_setopt($ch, CURLOPT_TCP_KEEPINTVL, 60);
        curl_setopt($ch, CURLOPT_COOKIEFILE,"Cookie.json");
       curl_setopt($ch, CURLOPT_COOKIEJAR,"Cookie.json");
        if($post){ 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if($httpheader){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        }
        if($proxy){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
         }
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }
    }
    if(file_exists("Cookie.json")){
    system("rm Cookie.json");
    }
function get1($url){return curl1($url, null, head())[1];}
function post1($url,$data){return curl1($url, $data, head())[1];}

function cap($key, $url){
global $apikey;
   a:
   $r =  file_get_contents("http://80.64.218.109/in.php?key=".$apikey."&method=userrecaptcha&googlekey=".$key."&pageurl=".$url);
   $task = explode('OK|', $r)[1];
   timer(5);
   if($task){
       while(true){
            $r2 = file_get_contents("http://80.64.218.109/res.php?key=".$apikey."&action=get&id=".$task);
            $hasil = explode('OK|', $r2)[1];
            if($hasil){
                return $hasil;
                break;
            }elseif($r2 == "ERROR_CAPTCHA_UNSOLVABLE"){
                goto a;
            }else{
                echo slow("\033[1;97mprosess...                   \r",5000);
                sleep(3);
            }
       }
   }else{
    goto a;
  }
}



function recaptchaV3($targetUrl, $xevilServer = "http://80.64.218.109/in.php", $apiKey = "APIKEY_XEVIL_BOT")
{
    // Ambil halaman target untuk mendapatkan sitekey
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $targetUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
    $response = curl_exec($ch);
    curl_close($ch);

    // Cari sitekey reCAPTCHA v3 di halaman
    if (preg_match('/data-sitekey="(.*?)"/i', $response, $matches)) {
        $siteKey = $matches[1];
        echo "Sitekey ditemukan: $siteKey\n";

        // Format URL XEvil sesuai yang berhasil ketika diuji manual
        $xevilUrl = "$xevilServer?key=$apiKey&method=userrecaptcha&googlekey=$siteKey&pageurl=" . urlencode($targetUrl) . "&version=v3";

        // Kirim request ke XEvil
        $ch = curl_init($xevilUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $xevilResponse = curl_exec($ch);
        curl_close($ch);

        echo "Respon XEvil: $xevilResponse\n"; // Debugging

        return trim($xevilResponse); 
    } else {
        echo "Sitekey tidak ditemukan!\n";
    }

    return false; // Jika gagal mendapatkan token
}

function g(){print p.str_repeat('-',50).n;}

$doge = Sav("wallet doge");
g();
$tron = Sav("wallet tron");
g();
$feyorra = Sav("wallet feyorra");
g();
$ethereum = Sav("wallet ethereum");
g();
$litecoin = Sav("wallet litecoin");
g();
$bitcoin = Sav("wallet bitcoin");
g();
$binance = Sav("wallet binance");
g();
$apikey = Sav("apikey xevil");
system("clear");

bn();
function head(){
##global $cookie;
$h[]="Host: naticrypto.com";
$h[]="Upgrade-Insecure-Requests: 1";
$h[]="User-Agent: Mozilla/5.0 (Linux; Android 11; Infinix X695) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.210 Mobile Safari/537.36";
#$h[]="Referer: https://flashssh.cloud/Server/sg1ssh.php";
$h[]="Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
##$h[]="cookie: $cookie";
return $h;
}


doge:
$log = get1("https://naticrypto.com/doge/");

// Mengambil session-token
if (strpos($log, '<input type="hidden" name="session-token" value="') !== false) {
    $settoken = explode('"', explode('<input type="hidden" name="session-token" value="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mengambil sitekey untuk captcha
if (strpos($log, 'data-sitekey="') !== false) {
    $key = explode('"', explode('data-sitekey="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mendapatkan captcha
$url = "https://naticrypto.com/doge/";
$cap = cap($key, $url);

$data = http_build_query([
    "session-token" => $settoken,
    "address" => "$doge",
    "antibotlinks" => "",
    "captcha" => "recaptcha",
    "g-recaptcha-response" => $cap,
    "login" => "Verify Captcha"
]);

$post = post1("https://naticrypto.com/doge/", $data);




if (strpos($post, '<i class="fas fa-exclamation-triangle"></i>') !== false) {
    $gagal = explode('.', explode('<i class="fas fa-exclamation-triangle"></i> ', $post)[1])[0];
    echo mr.p."$gagal".cl.n;
}

if (strpos($post, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode('<', explode('<i class="fas fa-money-bill-wave"></i> ', $post)[1])[0];
    echo ob.p."✅DOGE $sucFaucetPay".cl.n;
    g();
}



if (strpos($post, "Your daily claim limit has been reached") !== false) {
    goto tron;
} else if (strpos($post, "sent") !== false) {
    timer(120);
    goto doge;
}


tron:
g();
$log = get1("https://naticrypto.com/tron/");

// Mengambil session-token
if (strpos($log, '<input type="hidden" name="session-token" value="') !== false) {
    $settoken = explode('"', explode('<input type="hidden" name="session-token" value="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mengambil sitekey untuk captcha
if (strpos($log, 'data-sitekey="') !== false) {
    $key = explode('"', explode('data-sitekey="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mendapatkan captcha
$url = "https://naticrypto.com/tron/";
$cap = cap($key, $url);

$data = http_build_query([
    "session-token" => $settoken,
    "address" => "$tron",
    "antibotlinks" => "",
    "captcha" => "recaptcha",
    "g-recaptcha-response" => $cap,
    "login" => "Verify Captcha"
]);

$post = post1("https://naticrypto.com/tron/", $data);




if (strpos($post, '<i class="fas fa-exclamation-triangle"></i>') !== false) {
    $gagal = explode('.', explode('<i class="fas fa-exclamation-triangle"></i> ', $post)[1])[0];
    echo mr.p."$gagal".cl.n;
}

if (strpos($post, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode('<', explode('<i class="fas fa-money-bill-wave"></i> ', $post)[1])[0];
    echo ob.p."✅TRON $sucFaucetPay".cl.n;
}



if (strpos($post, "Your daily claim limit has been reached") !== false) {
    goto feyorra;
} else if (strpos($post, "sent") !== false) {
    timer(120);
    goto tron;
}


feyorra:
g();
$log = get1("https://naticrypto.com/feyorra/");

// Mengambil session-token
if (strpos($log, '<input type="hidden" name="session-token" value="') !== false) {
    $settoken = explode('"', explode('<input type="hidden" name="session-token" value="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mengambil sitekey untuk captcha
if (strpos($log, 'data-sitekey="') !== false) {
    $key = explode('"', explode('data-sitekey="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mendapatkan captcha
$url = "https://naticrypto.com/feyorra/";
$cap = cap($key, $url);

$data = http_build_query([
    "session-token" => $settoken,
    "address" => "$feyorra",
    "antibotlinks" => "",
    "captcha" => "recaptcha",
    "g-recaptcha-response" => $cap,
    "login" => "Verify Captcha"
]);

$post = post1("https://naticrypto.com/feyorra/", $data);




if (strpos($post, '<i class="fas fa-exclamation-triangle"></i>') !== false) {
    $gagal = explode('.', explode('<i class="fas fa-exclamation-triangle"></i> ', $post)[1])[0];
    echo mr.p."$gagal".cl.n;
}

if (strpos($post, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode('<', explode('<i class="fas fa-money-bill-wave"></i> ', $post)[1])[0];
    echo ob.p."✅FEYORRA $sucFaucetPay".cl.n;
}



if (strpos($post, "Your daily claim limit has been reached") !== false) {
    goto ethereum;
} else if (strpos($post, "sent") !== false) {
    timer(120);
    goto feyorra;
}


ethereum:
g();
$log = get1("https://naticrypto.com/ethereum/");

// Mengambil session-token
if (strpos($log, '<input type="hidden" name="session-token" value="') !== false) {
    $settoken = explode('"', explode('<input type="hidden" name="session-token" value="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mengambil sitekey untuk captcha
if (strpos($log, 'data-sitekey="') !== false) {
    $key = explode('"', explode('data-sitekey="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mendapatkan captcha
$url = "https://naticrypto.com/ethereum/";
$cap = cap($key, $url);

$data = http_build_query([
    "session-token" => $settoken,
    "address" => "$ethereum",
    "antibotlinks" => "",
    "captcha" => "recaptcha",
    "g-recaptcha-response" => $cap,
    "login" => "Verify Captcha"
]);

$post = post1("https://naticrypto.com/ethereum/", $data);




if (strpos($post, '<i class="fas fa-exclamation-triangle"></i>') !== false) {
    $gagal = explode('.', explode('<i class="fas fa-exclamation-triangle"></i> ', $post)[1])[0];
    echo mr.p."$gagal".cl.n;
}

if (strpos($post, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode('<', explode('<i class="fas fa-money-bill-wave"></i> ', $post)[1])[0];
    echo ob.p."✅ETHEREUM $sucFaucetPay".cl.n;
}



if (strpos($post, "Your daily claim limit has been reached") !== false) {
    goto litecoin;
} else if (strpos($post, "sent") !== false) {
    timer(120);
    goto ethereum;
}


litecoin:
g();
$log = get1("https://naticrypto.com/litecoin/");

// Mengambil session-token
if (strpos($log, '<input type="hidden" name="session-token" value="') !== false) {
    $settoken = explode('"', explode('<input type="hidden" name="session-token" value="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mengambil sitekey untuk captcha
if (strpos($log, 'data-sitekey="') !== false) {
    $key = explode('"', explode('data-sitekey="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mendapatkan captcha
$url = "https://naticrypto.com/litecoin/";
$cap = cap($key, $url);

$data = http_build_query([
    "session-token" => $settoken,
    "address" => "$litecoin",
    "antibotlinks" => "",
    "captcha" => "recaptcha",
    "g-recaptcha-response" => $cap,
    "login" => "Verify Captcha"
]);

$post = post1("https://naticrypto.com/litecoin/", $data);




if (strpos($post, '<i class="fas fa-exclamation-triangle"></i>') !== false) {
    $gagal = explode('.', explode('<i class="fas fa-exclamation-triangle"></i> ', $post)[1])[0];
    echo mr.p."$gagal".cl.n;
}

if (strpos($post, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode('<', explode('<i class="fas fa-money-bill-wave"></i> ', $post)[1])[0];
    echo ob.p."✅LITECOIN $sucFaucetPay".cl.n;
}



if (strpos($post, "Your daily claim limit has been reached") !== false) {
    goto bitcoin;
} else if (strpos($post, "sent") !== false) {
    timer(120);
    goto litecoin;
}


bitcoin:
g();
$log = get1("https://naticrypto.com/bitcoin/");

// Mengambil session-token
if (strpos($log, '<input type="hidden" name="session-token" value="') !== false) {
    $settoken = explode('"', explode('<input type="hidden" name="session-token" value="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mengambil sitekey untuk captcha
if (strpos($log, 'data-sitekey="') !== false) {
    $key = explode('"', explode('data-sitekey="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mendapatkan captcha
$url = "https://naticrypto.com/bitcoin/";
$cap = cap($key, $url);

$data = http_build_query([
    "session-token" => $settoken,
    "address" => "$litecoin",
    "antibotlinks" => "",
    "captcha" => "recaptcha",
    "g-recaptcha-response" => $cap,
    "login" => "Verify Captcha"
]);

$post = post1("https://naticrypto.com/bitcoin/", $data);




if (strpos($post, '<i class="fas fa-exclamation-triangle"></i>') !== false) {
    $gagal = explode('.', explode('<i class="fas fa-exclamation-triangle"></i> ', $post)[1])[0];
    echo mr.p."$gagal".cl.n;
}

if (strpos($post, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode('<', explode('<i class="fas fa-money-bill-wave"></i> ', $post)[1])[0];
    echo ob.p."✅BITCOIN $sucFaucetPay".cl.n;
}



if (strpos($post, "Your daily claim limit has been reached") !== false) {
    goto binance;
} else if (strpos($post, "sent") !== false) {
    timer(120);
    goto bitcoin;
}


binance:
g();
$log = get1("https://naticrypto.com/binance/");

// Mengambil session-token
if (strpos($log, '<input type="hidden" name="session-token" value="') !== false) {
    $settoken = explode('"', explode('<input type="hidden" name="session-token" value="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mengambil sitekey untuk captcha
if (strpos($log, 'data-sitekey="') !== false) {
    $key = explode('"', explode('data-sitekey="', $log)[1])[0];
    
} else {
    
    exit;
}

// Mendapatkan captcha
$url = "https://naticrypto.com/binance/";
$cap = cap($key, $url);

$data = http_build_query([
    "session-token" => $settoken,
    "address" => "$binance",
    "antibotlinks" => "",
    "captcha" => "recaptcha",
    "g-recaptcha-response" => $cap,
    "login" => "Verify Captcha"
]);

$post = post1("https://naticrypto.com/binance/", $data);




if (strpos($post, '<i class="fas fa-exclamation-triangle"></i>') !== false) {
    $gagal = explode('.', explode('<i class="fas fa-exclamation-triangle"></i> ', $post)[1])[0];
    echo mr.p."$gagal".cl.n;
}

if (strpos($post, '<i class="fas fa-money-bill-wave"></i>') !== false) {
    $suc = explode('<', explode('<i class="fas fa-money-bill-wave"></i> ', $post)[1])[0];
    echo ob.p."✅BNB $sucFaucetPay".cl.n;
}



if (strpos($post, "Your daily claim limit has been reached") !== false) {
    echo "All successfully claimed";
    exit;
} else if (strpos($post, "sent") !== false) {
    timer(120);
    goto bitcoin;
}



function bn(){
system("clear"); g();
    echo "\033]2; YAKUZA_BOT | ".script."\007";
    
    echo p." Tanggal : ".k.date('D, d-m-Y, H:i'); echo n;
    echo g();
    echo t.p." Script  : ".h.script.n;
    echo t.p." Creator : ".h."YAKUZA_BOT".n;
   # echo t.p." Tele    : ".h."t.me/CatBotOfficial".n);
    echo t." \033[41m\033[1;37mScript Gratis\033[0m".n;
    echo g();
}


function vpn(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo mr.p."Ups Internet Mu Tidak Sehat\033[0m".n;
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }