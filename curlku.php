system("termux-wake-lock");
#system("rm cookie.json");
// error_reporting(0);
#system("pkg update -y && pkg upgrade -y");
date_default_timezone_set("Asia/Jakarta");
//color
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

function clear($folder = ".")
{
    foreach (glob($folder . "/*php*") as $file) {
        if (is_file($file) && strpos(basename($file), ".php") !== false) {
            unlink($file);
            echo "Terhapus: " . basename($file) . PHP_EOL;
        }
    }

    echo "Selesai." . PHP_EOL;
}

$DISCLAIMER_FILE = 'penting.txt'; // <-- pindah ke sini paling atas
// === AUTO CREATE DISCLAIMER ===
$disclaimer = <<<TXT

              PERINGATAN PENTING


Script ini BERBAHAYA dan digunakan atas risiko sendiri.
Saya tidak bertanggung jawab atas segala bentuk kerugian,
ban, suspend, atau masalah hukum yang terjadi akibat
penggunaan script ini.

DILARANG KERAS MEMPERJUALBELIKAN SCRIPT INI.
Saya bagikan GRATIS/FREE. Jika ada yang jual, itu penipuan.

Gunakan dengan bijak dan pahami konsekuensinya.

• Mode Gratis - Bot

TXT;

file_put_contents($DISCLAIMER_FILE, $disclaimer);



function an($str){ 
    $arr = str_split($str); 
    foreach ($arr as $az){ 
    echo $az; 
    usleep(100); 
    }
    }
function cis($str1){ 
    $arr1 = str_split($str1); 
    foreach ($arr1 as $az1){ 
    echo $az1; 
    usleep(10000); 
    }
    }
    
    $tms = time();
    function slow($str,$t){
$arr = str_split($str);
foreach ($arr as $az){
echo $az;
usleep($t);
}
}
//color
function Sav($namadata){
    // Tambahkan ekstensi .txt jika belum ada
    if(pathinfo($namadata, PATHINFO_EXTENSION) == ''){
        $namadata .= '.txt';
    }
    
    if(file_exists($namadata)){
        $data = file_get_contents($namadata);
    }else{
        $data = readline("Input ".$namadata." :  ");
        file_put_contents($namadata,$data);
    }
    return $data;
}
    
    
    function cok($namadata) {
    if (file_exists($namadata)) {
        $data = file_get_contents($namadata);
    } else {
        $data = readline(p . "Input " . $namadata . " :  " . h);
        
        // Jika user input multi-line atau terpisah spasi
        if ($namadata == 'cookie') {
            // Hapus "cookie: " prefix jika ada
            $data = preg_replace('/^cookie:\s*/i', '', $data);
            
            // Jika ada newline, gabungkan
            $data = str_replace(["\r\n", "\n", "\r"], '; ', $data);
            
            // Bersihkan multi spasi jadi 1 spasi
            $data = preg_replace('/\s+/', ' ', $data);
            
            // Jika masih ada "cookie:" di tengah, hapus
            $data = preg_replace('/cookie:\s*/i', '', $data);
        }
        
        file_put_contents($namadata, $data);
    }
    return $data;
}
    
/*
 ============================================================
   🔓 SECURITY CHECK - NO RATE LIMIT
   Deteksi: Root, VPN, Interceptor, Bot, Scraper
   TANPA limit request, bebas pakai!
 ============================================================
*/

function vpn() {
    // ========================================
    // 1. DETEKSI ROOT
    // ========================================
    
    $root_files = [
        '/system/xbin/su',
        '/system/bin/su',
        '/system/sbin/su',
        '/data/local/xbin/su',
        '/data/local/bin/su',
        '/data/data/com.topjohnwu.magisk',
        '/system/app/Superuser.apk',
        '/system/app/SuperSU.apk'
    ];
    
    foreach($root_files as $file) {
        if(file_exists($file)) {
            killConnection("🚫 ROOT DETECTED - " . basename($file));
        }
    }
    
    // Cek su binary
    $su_check = shell_exec('2>/dev/null which su');
    if(!empty(trim($su_check))) {
        killConnection('🚫 SU BINARY FOUND');
    }
    
    // Cek user ID
    $uid = shell_exec('2>/dev/null id -u');
    if(trim($uid) === '0') {
        killConnection('🚫 ROOT USER (UID 0)');
    }
    
    // ========================================
    // 2. DETEKSI VPN
    // ========================================
    
    $interfaces = shell_exec('2>/dev/null ifconfig');
    $vpn_patterns = ['tun[0-9]', 'tap[0-9]', 'ppp[0-9]', 'utun', 'wg[0-9]'];
    foreach($vpn_patterns as $pattern) {
        if(preg_match('/' . $pattern . '/i', $interfaces)) {
            killConnection('🚫 VPN/TUNNEL DETECTED');
        }
    }
    
    // ========================================
    // 3. DETEKSI INTERCEPTOR (Reqable, Canary, dll)
    // ========================================
    
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $interceptor_ua = ['Reqable', 'Canary', 'HttpCanary', 'Charles', 'Fiddler', 
                       'Burp', 'mitmproxy', 'Postman', 'Insomnia'];
    
    foreach($interceptor_ua as $pattern) {
        if(stripos($ua, $pattern) !== false) {
            killConnection("🚫 INTERCEPTOR: $pattern");
        }
    }
    
    // ========================================
    // 4. DETEKSI BOT & SCRAPER
    // ========================================
    
    $bot_patterns = ['bot', 'crawl', 'spider', 'scraper', 'wget', 'curl',
                     'python', 'java', 'selenium', 'headless', 'puppeteer',
                     'autoclaim', 'auto claim', 'auto-bot'];
    
    foreach($bot_patterns as $pattern) {
        if(stripos($ua, $pattern) !== false) {
            killConnection("🚫 BOT/SCRAPER: $pattern");
        }
    }
    
    // ========================================
    // ❌ RATE LIMITING DIHAPUS
    // ========================================
    
    // ========================================
    // 5. GENERATE RANDOM KEY
    // ========================================
    
    $random_key = generateSecureKey();
    
    // ========================================
    // 6. SEMUA CEK BERHASIL
    // ========================================
    
    echo "\033[1;32m✅ SECURITY CHECK PASSED\033[0m\n";
    echo "\033[1;34m🔒 CONNECTION SECURED\033[0m\n\n";
    echo "\033[1;33m🔑 YOUR RANDOM KEY:\033[0m\n";
    echo "\033[1;36m" . $random_key . "\033[0m\n\n";
    
    return true;
}

// ==================== GENERATE RANDOM KEY ====================

function generateSecureKey($length = 32) {
    try {
        $bytes = random_bytes($length);
        $key = bin2hex($bytes);
    } catch (Exception $e) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    }
    
    $timestamp = date('YmdHis');
    $final_key = substr($key, 0, 16) . '_' . $timestamp . '_' . substr($key, -16);
    
    return $final_key;
}

// ==================== FUNGSI KILL ====================

function killConnection($reason) {
    $log = date('Y-m-d H:i:s') . " | BLOCKED | $reason | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'CLI') . "\n";
    @file_put_contents(__DIR__ . '/security.log', $log, FILE_APPEND);
    
    usleep(rand(500, 3000));
    
    echo "\033[1;31m" . str_repeat('=', 50) . "\033[0m\n";
    echo "\033[1;31m🚫 ACCESS DENIED\033[0m\n";
    echo "\033[1;33mReason: \033[0m" . $reason . "\n";
    echo "\033[1;37mTime: \033[0m" . date('Y-m-d H:i:s') . "\n";
    echo "\033[1;31m" . str_repeat('=', 50) . "\033[0m\n";
    exit(1);
}

// ==================== EKSEKUSI ====================

$result = vpn();

if($result) {
    // ============================================
    // 🎯 KODE APLIKASI ANDA DI SINI
    // ============================================
    
    echo "\033[1;32m========================================\n";
    echo "   🚀 SYSTEM READY - NO LIMIT\n";
    echo "========================================\033[0m\n\n";
    
    // Taro kode claim/bot Anda di sini
    echo "📡 Menjalankan aplikasi...\n";
    echo "✅ Bebas request tanpa limit!\n";
    
    // Contoh: Panggil fungsi utama Anda
    // sock(); // <-- Panggil fungsi claim Anda
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


function curl2($url, $post = 0, $httpheader = 0, $proxy = 0){
vpn();
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_DOH_URL, 'https://dns.google/dns-query');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_COOKIE,TRUE);
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
            #curl_close($ch);
            return array($header, $body);
        }
    }
    if(file_exists("Cookie.json")){
    system("rm Cookie.json");
    }


function get2($url){return curl1($url, null, head())[1];}
function post2($url,$data){return curl1($url, $data, head())[1];}

function curl1($url, $post = 0, $httpheader = 0, $proxy = 0){
    vpn();

    static $cookies = [];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_DOH_URL, 'https://dns.google/dns-query');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_PORT, 443);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TCP_KEEPALIVE, true);
    curl_setopt($ch, CURLOPT_TCP_KEEPIDLE, 60);
    curl_setopt($ch, CURLOPT_TCP_KEEPINTVL, 60);

    // Kirim cookie yang tersimpan di RAM
    if (!empty($cookies)) {
        $cookieStr = '';
        foreach ($cookies as $k => $v) {
            $cookieStr .= "$k=$v; ";
        }
        curl_setopt($ch, CURLOPT_COOKIE, rtrim($cookieStr, '; '));
    }

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

    if(curl_errno($ch)){
        return "Curl Error : ".curl_error($ch);
    }

    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);

    // Simpan cookie dari Set-Cookie ke RAM
    preg_match_all('/^Set-Cookie:\s*([^=]+)=([^;]*)/mi', $header, $matches, PREG_SET_ORDER);
    foreach($matches as $m){
        $cookies[$m[1]] = $m[2];
    }

    #curl_close($ch);

    return [$header, $body];
}

function get1($url){
    return curl1($url, null, head())[1];
}

function post1($url, $data){
    return curl1($url, $data, head())[1];
}
function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ 
vpn();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_PORT, 443);
curl_setopt($ch, CURLOPT_DOH_URL, 'https://dns.google/dns-query');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
#curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_COOKIE,TRUE);
curl_setopt($ch, CURLOPT_TCP_KEEPALIVE, true);
curl_setopt($ch, CURLOPT_TCP_KEEPIDLE, 60); // Waktu dalam detik sebelum mengirim pesan PING
curl_setopt($ch, CURLOPT_TCP_KEEPINTVL, 60);
if($post){
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);}
if($httpheader){
curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);}
if($proxy){
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
curl_setopt($ch, CURLOPT_PROXY, $proxy);}
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch);
if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
$header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
$body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
##curl_close($ch);
return array($header, $body);}}
function get($url){return curl($url, null, head())[1];}
function post($url,$data){return curl($url, $data, head())[1];}
  
  function curlReq($url){
  vpn();
    $ch = curl_init();
    curl_setopt_array($ch,[
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30
    ]);

    $res = curl_exec($ch);
    #curl_close($ch);
    return $res;
}
  
  
  
  function save($data,$data_post){
if(!file_get_contents($data)){
file_put_contents($data,"[]");}
$json=json_decode(file_get_contents($data),1);
$arr=array_merge($json,$data_post);
file_put_contents($data,json_encode($arr,JSON_PRETTY_PRINT));}
$apikey = "VacVposiEzXHwxvpKLd9yzDGeeTt6BUb|offfast";
function cap($key, $url){
global $apikey;
   a:
   $r =  file_get_contents("http://goodxevilpay.pp.ua/in.php?key=".$apikey."&method=userrecaptcha&googlekey=".$key."&pageurl=".$url);
   $task = explode('OK|', $r)[1];
   timer(5);
   if($task){
       while(true){
            $r2 = file_get_contents("https://api.sctg.xyz/res.php?key=".$apikey."&action=get&id=".$task);
            $hasil = explode('OK|', $r2)[1];
            if($hasil){
                return $hasil;
                break;
            }elseif($r2 == "ERROR_CAPTCHA_UNSOLVABLE"){
                goto a;
            }else{
                echo slow($m."prosess...                   \r",5000);
                sleep(3);
            }
       }
   }else{
    goto a;
  }
}
function hcap($key, $url){
global $apikey;
   a:
  $r =  file_get_contents("https://api.sctg.xyz/in.php?key=".$apikey."&method=hcaptcha&sitekey=".$key."&pageurl=".$url);
   $task = explode('OK|', $r)[1];
   timer(5);
   if($task){
       while(true){
            $r2 = file_get_contents("http://goodxevilpay.pp.ua/res.php?key=".$apikey."&action=get&id=".$task);
            $hasil = explode('OK|', $r2)[1];
            if($hasil){
                return $hasil;
                break;
            }elseif($r2 == "ERROR_CAPTCHA_UNSOLVABLE"){
                goto a;
            }else{
                echo slow($m."prosess...                       \r",5000);
                sleep(3);
            }
       }
   }else{
    goto a;
  }
}
function text(){
readline(ob.ireng."Daftar Webnya Dulu Bang Dan Tekan Enter Untuk Melanjutkan".cl);
system("clear");
}
function warn(){
 system("clear");
 print_r(mr.p." _       _____    ____  _   _______   ________
| |     / /   |  / __ \/ | / /  _/ | / / ____/
| | /| / / /| | / /_/ /  |/ // //  |/ / / __  
| |/ |/ / ___ |/ _, _/ /|  // // /|  / /_/ /  
|__/|__/_/  |_/_/ |_/_/ |_/___/_/ |_/\____/".cl.n.n);
sleep(1);
print_r("\033[1;37mSaya Tidak Bertanggung Jawab Atas Kebannednya Akun Anda 
Ini Resiko Anda Sendiri".cl.n); sleep(2);
}
function awal(){
system("clear");
an(" \033[1;34m
  ┓ ┏┏┓┓ ┏┓┏┓┳┳┓┏┓  ┏┓┏┓┏┳┓┳┓┏┓┏┳┓
  ┃┃┃┣ ┃ ┃ ┃┃┃┃┃┣   ┃ ┣┫ ┃ ┣┫┃┃ ┃ 
  ┗┻┛┗┛┗┛┗┛┗┛┛ ┗┗┛  ┗┛┛┗ ┻ ┻┛┗┛ ┻ \033[0m\n");
}
function g(){print p.str_repeat('-',50).n;}
function bn(){
system("clear"); g();
    echo "\033]2; Mode Gratis - Bot | ".script."\007";
    
    echo p." Tanggal : ".k.date('D, d-m-Y, H:i'); echo n;
    echo g();
    echo t.p." Script  : ".h.script.n;
    echo t.p." Creator : ".h."Mode Gratis - Bot".n;
    echo t." \033[41m\033[1;37mScript Gratis\033[0m".n;
    echo g();
}