#!/bin/sh

# Memberikan jeda waktu 5 detik agar database cloud siap
sleep 5

# Jalankan MIGRATED FRESH untuk membersihkan sisa error duplikasi tabel sebelumnya
echo "Menjalankan migrasi database (Fresh)..."
php artisan migrate:fresh --force

# Menyalakan service utama (Nginx dan PHP-FPM)
echo "Menyalakan Nginx dan PHP-FPM..."
service nginx start && php-fpm