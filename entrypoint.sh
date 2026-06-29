#!/bin/sh

# Memberikan jeda waktu 5 detik agar koneksi siap
sleep 5

# Memecah DATABASE_URL dari Render menjadi variabel yang dikenali Laravel
if [ -n "$DATABASE_URL" ]; then
    # Format URL: postgres://user:password@host:port/database
    # Menghapus skema postgres://
    URL="${DATABASE_URL#*://}"
    
    # Memisahkan user:password dan host:port/database
    CREDENTIALS="${URL%%@*}"
    DB_DETAILS="${URL#*@}"
    
    # Memisahkan user dan password
    export DB_USERNAME="${CREDENTIALS%%:*}"
    export DB_PASSWORD="${CREDENTIALS#*:}"
    
    # Memisahkan host:port dan database
    HOST_PORT="${DB_DETAILS%%/*}"
    export DB_DATABASE="${DB_DETAILS#*/}"
    
    # Memisahkan host dan port
    export DB_HOST="${HOST_PORT%%:*}"
    export DB_PORT="${HOST_PORT#*:}"
    
    # Jika tidak ada port khusus, gunakan default postgres
    if [ "$DB_PORT" = "$HOST_PORT" ]; then
        export DB_PORT=5432
    fi
    
    export DB_CONNECTION=pgsql
    echo "Database URL berhasil dikonfigurasi untuk Host: $DB_HOST"
fi

# Jalankan migrasi database
echo "Menjalankan migrasi database..."
php artisan migrate --force

# Menyalakan service utama (Nginx dan PHP-FPM)
echo "Menyalakan Nginx dan PHP-FPM..."
service nginx start && php-fpm