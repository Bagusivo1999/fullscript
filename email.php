
error_reporting(0);
set_time_limit(0);
const script = "Tempmail";
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

$CHECK_INTERVAL = 10;
$EXPIRE_TIME = 86400; // 24 jam

$processed = [];
$start = time();

function createMail(){
    return json_decode(
        curlReq("https://api.synoxcloud.xyz/tempmail/tempmail-create"),
        true
    );
}

function getInbox($visitor){
    return json_decode(
        curlReq("https://api.synoxcloud.xyz/tempmail/tempmail-inbox?id=".$visitor),
        true
    );
}

$mail = createMail();

if(!$mail['status']){
    die("❌ Gagal membuat tempmail\n");
}
bn();
$email   = $mail['result']['address'];
$visitor = $mail['result']['visitor_id'];

echo "Salin email dibawah ini untuk otp".n;
echo "Email      : $email\n"; g();

while(true){

    if(time() - $start >= $EXPIRE_TIME){
        echo "⌛ Email expired\n";
        break;
    }

    $inbox = getInbox($visitor);

    if(
        isset($inbox['result']['messages']) &&
        is_array($inbox['result']['messages'])
    ){

        foreach($inbox['result']['messages'] as $msg){

            $id = $msg['id'];

            if(in_array($id,$processed)){
                continue;
            }
            echo "\n📥 PESAN MASUK\n";
            echo "From    : ".$msg['from']."\n";
            echo "Subject : ".$msg['subject']."\n";
            echo "Date    : ".$msg['date']."\n";
            echo "--------------------------\n";
            echo $msg['content']."\n";

            if(preg_match('/\b\d{4,8}\b/',$msg['content'],$otp)){
                echo "\n🔐 OTP : ".$otp[0]."\n";
            }

            echo "==========================\n";

            $processed[] = $id;
        }
    }

    sleep($CHECK_INTERVAL);
}