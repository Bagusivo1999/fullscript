
system('clear');
function jembut(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    
jembut();
function joglo() {
    echo "\n";
    echo "╔══════════════════════════════╗\n";
    echo "║    MENU MODE GRATIS - BOT    ║\n";
    echo "╠══════════════════════════════╣\n";
    echo "║ [1] Penghasil Ton            ║\n";
    echo "║ [2] Vitsplay                 ║\n";
    echo "║ [3] Clipapp                  ║\n";
    echo "║ [0] Exit                     ║\n";
    echo "╚══════════════════════════════╝\n";
}
while (true) {

    joglo();

    $pilih = readline("\nPilih Menu : ");

    switch ($pilih) {

        case "1":
            $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/tron.php");
eval($function);
            // kode login
        break;

        case "2":
            case "2":
    $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/vits.php");
    eval($function);
    // kode login
     // Tambahkan ini juga kalau mau bersihin laya
     // system("clear");
    break; 

        case "3":
            $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/bot1.php");
           eval($function);
            // kode timer
        break;
        
        case "0":
            echo "\nSampai Jumpa!\n";
            exit;

        default:
            echo "\n[×] Menu Tidak Tersedia\n";
        break;
    }

    
}