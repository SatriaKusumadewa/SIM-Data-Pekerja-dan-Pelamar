<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->string('nik')->unique()->after('id');
            $table->string('nama')->after('nik');
            $table->text('alamat')->after('nama');
            $table->string('no_telepon')->after('alamat');
            $table->string('email')->unique()->after('no_telepon');
            $table->string('pendidikan')->after('email');
            $table->string('posisi_dilamar')->after('pendidikan');
            $table->date('tgl_melamar')->nullable()->after('posisi_dilamar');
            $table->string('cv')->nullable()->after('tgl_melamar');
            $table->enum('status_pelamar', ['diproses', 'diterima', 'ditolak'])
                  ->default('diproses')
                  ->after('cv');
        });
    }

    public function down(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'nama',
                'alamat',
                'no_telepon',
                'email',
                'pendidikan',
                'posisi_dilamar',
                'tgl_melamar',
                'cv',
                'status_pelamar',
            ]);
        });
    }
};