

system('clear');
function menu(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    
menu();
function menu() {
    echo "\n";
    echo "╔══════════════════════════════╗\n";
    echo "║      SCRIPT TERMUX MENU      ║\n";
    echo "╠══════════════════════════════╣\n";
    echo "║ [1] Login Akun              ║\n";
    echo "║ [2] Multi Claim             ║\n";
    echo "║ [3] Cek Balance             ║\n";
    echo "║ [4] Setting Timer           ║\n";
    echo "║ [5] Hapus Data              ║\n";
    echo "║ [0] Exit                    ║\n";
    echo "╚══════════════════════════════╝\n";
}

while (true) {

    menu();

    $pilih = readline("\nPilih Menu : ");

    switch ($pilih) {

        case "1":
            $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/tron.php");
eval($function);
            // kode login
        break;

        case "2":
            echo "\n[✓] Menu Multi Claim Dipilih\n";
            // kode claim
        break;

        case "3":
            echo "\n[✓] Menu Cek Balance Dipilih\n";
            // kode balance
        break;

        case "4":
            echo "\n[✓] Menu Setting Timer Dipilih\n";
            // kode timer
        break;

        case "5":
            echo "\n[✓] Data Berhasil Dihapus\n";
            // unlink dll
        break;

        case "0":
            echo "\nSampai Jumpa!\n";
            exit;

        default:
            echo "\n[×] Menu Tidak Tersedia\n";
        break;
    }

    readline("\nTekan Enter Untuk Kembali...");
    system('clear');
}