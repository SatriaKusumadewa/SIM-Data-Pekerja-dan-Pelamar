#!/bin/sh

# Memberikan jeda waktu 5 detik agar database cloud siap
sleep 5

# 1. Jalankan MIGRATED FRESH (Tanpa --seed langsung agar tidak tabrakan)
echo "Menjalankan migrasi database bersih..."
php artisan migrate:fresh --force

# 2. Jalankan Seeder secara terpisah dan abaikan jika data sudah ada
echo "Mengisi data seeder bawaan..."
php artisan db:seed --force || echo "Seeder dilewati karena data sudah terisi."

# 3. Menyalakan service utama (Nginx dan PHP-FPM)
echo "Menyalakan Nginx dan PHP-FPM..."
service nginx start && php-fpm