# ================= WARNA PYTHON (SAMA SEPERTI PHP) =================
# Reset
cl = "\033[0m"

# Warna dasar
hitam = "\033[0;30m"
abu2 = "\033[1;30m"
putih = "\033[0;37m"
putih2 = "\033[1;37m"
red2 = "\033[1;31m"
green = "\033[0;32m"
green2 = "\033[1;32m"
yellow = "\033[0;33m"
yellow2 = "\033[1;33m"
blue = "\033[0;34m"
blue2 = "\033[1;34m"
lblue = "\033[0;36m"
lblue2 = "\033[1;36m"

# Warna alternative
hijau = "\033[0;32m"
hijau1 = "\033[32;1m"
biru = "\033[0;36m"
biru1 = "\033[36;1m"
merah = "\033[31;1m"
merah2 = "\033[1;31m"
putih1 = "\033[1;37m"
kuning = "\033[33;1m"
kuning1 = "\033[1;33m"
kuning2 = "\033[1;33m"
cyan = "\033[0;36m"
cyan1 = "\033[1;36m"
ungu = "\033[0;35m"
ungu2 = "\033[1;35m"
abu = "\033[0;33m"
abu1 = "\033[0;37m"

# Warna shortcut
p = "\033[1;37m"      # Putih terang
red = "\033[0;31m"    # Merah
h = "\033[1;32m"      # Hijau terang
k = "\033[1;33m"      # Kuning terang
purple = "\033[0;35m" # Ungu
purple2 = "\033[1;35m" # Ungu terang

# Background
off = "\033[102m"     # Background hijau muda
oc = "\033[46m"       # Background cyan
ow = "\033[47m"       # Background putih
mr = "\033[41m"       # Background merah
ob = "\033[44m"       # Background biru
og = "\033[42m"       # Background hijau
oy = "\033[43m"       # Background kuning
ou = "\033[45m"       # Background ungu
ireng = "\033[0;100m" # Background hitam
ired = "\033[0;101m"  # Background merah
igreen = "\033[0;102m" # Background hijau
ikuning = "\033[0;103m" # Background kuning
ibiru = "\033[0;104m"  # Background biru
iungu = "\033[10;95m"  # Background ungu
icyan = "\033[0;106m"  # Background cyan
iputih = "\033[0;107m" # Background putih

# Warna terang (Bright)
Black = "\033[0;30m"
Cyan = "\033[0;36m"
White = "\033[0;37m"
IYellow = "\033[0;93m"
IRed = "\033[0;91m"
BIRed = "\033[1;91m"
BIWhite = "\033[1;97m"
BICyan = "\033[1;96m"
BIBlack = "\033[1;90m"
BBlack = "\033[1;30m"
IBlack = "\033[0;90m"
BIBlue = "\033[1;94m"
IGreen = "\033[0;92m"
On_IRed = "\033[0;101m"

# Underline (Garis bawah)
UBlack = "\033[4;30m"
URed = "\033[4;31m"
UGreen = "\033[4;32m"
UYellow = "\033[4;33m"
UBlue = "\033[4;34m"
UPurple = "\033[4;35m"
UCyan = "\033[4;36m"
UWhite = "\033[4;37m"

# Red to Yellow shade (Gradasi)
r3 = "\033[01;38;5;196m"
r2 = "\033[01;38;5;202m"
r1 = "\033[01;38;5;208m"
ry = "\033[01;38;5;214m"
y1 = "\033[01;38;5;220m"
y2 = "\033[01;38;5;226m"
y3 = "\033[01;38;5;228m"

# Shortcut
t = "\t"
r = "\r                                             \r"
n = "\n"



import os
from datetime import datetime
#!/usr/bin/env python3
import os
from datetime import datetime

# ===== KONSTANTA (Ganti di sini aja) =====
   # <-- Ganti ini, banner otomatis berubah
CREATOR = "Mode Gratis - Bot"
CONTACT = "https://t.me/modegratis19"

# ===== WARNA =====
cl = "\033[0m"
p = "\033[1;37m"
h = "\033[1;32m"
k = "\033[1;33m"
mr = "\033[41m"
n = "\n"
t = "\t"

# ===== BANNER =====
def banner():
    os.system("clear")
    print(f"{p}Tanggal : {k}{datetime.now().strftime('%A, %d-%m-%Y, %H:%M')}{cl}")
    print(f"{mr}{p}═══════════════════════════════════════════════{cl}")
    print(f"{t}Script  : {h}{SCRIPT_NAME}{cl}")     # Pakai variabel
    print(f"{t}Creator : {h}{CREATOR}{cl}")         # Pakai variabel
    print(f"{t}Contact : {mr}{p}{CONTACT}{cl}")     # Pakai variabel
    print(f"{mr}{p}═══════════════════════════════════════════════{cl}")

# ===== MAIN =====
