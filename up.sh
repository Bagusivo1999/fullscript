#!/data/data/com.termux/files/usr/bin/bash

# Setup credential (cukup sekali, tapi aman diulang)
git config --global credential.helper store

# Set identity
git config user.name "Bagus Ivo"
git config user.email "bagusfildhonfatoni8@gmail.com"

git add .
git commit -m "update all $(date '+%Y-%m-%d %H:%M')"
git push -f origin main

echo "✅ Selesai!"