#!/bin/sh

# Memberikan jeda waktu 5 detik agar koneksi database siap
sleep 5

# Jalankan migrasi database cloud secara otomatis tanpa prompt konfirmasi
echo "Menjalankan migrasi database..."
php artisan migrate --force

# Menyalakan service utama (Nginx dan PHP-FPM)
echo "Menyalakan Nginx dan PHP-FPM..."
service nginx start && php-fpm