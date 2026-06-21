

system('stty -icanon -echo');

$menu = [
    "Penghasil Ton",
    "Vitsplay",
    "Clipapp",
    "Exit"
];

$selected = 0;

function tampil($menu, $selected){
    system('clear');

    echo "\033[1;36m";
    echo "╔══════════════════════════════╗\n";
    echo "║      MENU MODE GRATIS        ║\n";
    echo "╚══════════════════════════════╝\n\n";

    foreach($menu as $i => $item){

        if($i == $selected){
            echo "\033[42;30m ➤ $item \033[0m\n";
        }else{
            echo "   $item\n";
        }
    }

    echo "\n↑ ↓ = Navigasi | ENTER = Pilih\n";
}

while(true){

    tampil($menu, $selected);

    $key = fread(STDIN, 3);

    if($key == "\033[A"){ // UP
        $selected--;
        if($selected < 0){
            $selected = count($menu)-1;
        }
    }

    elseif($key == "\033[B"){ // DOWN
        $selected++;
        if($selected >= count($menu)){
            $selected = 0;
        }
    }

    elseif(trim($key) == ''){ // ENTER

        system('clear');

        switch($selected){

            case 0:
                $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/tron.php");
                eval($function);
            break;

            case 1:
                $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/vits.php");
                eval($function);
            break;

            case 2:
                $function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/cash.php");
                eval($function);
            break;

            case 3:
                system('stty sane');
                exit("Sampai Jumpa!\n");
        }

        echo "\n\nTekan Enter Untuk Kembali...";
        fgets(STDIN);
    }
}