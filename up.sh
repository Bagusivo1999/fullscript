#!/data/data/com.termux/files/usr/bin/bash

# Set identity (cukup sekali, tapi biar aman)
git config user.name "Bagusivo1999"
git config user.email "bagusfildhonfatoni8@gmail.com"

# Add, commit, push (langsung dari folder repo)
git add .
git commit -m "update all $(date '+%Y-%m-%d %H:%M')"
git push -f origin main

echo "✅ Selesai!"