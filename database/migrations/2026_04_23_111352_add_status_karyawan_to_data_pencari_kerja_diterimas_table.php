<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_pencari_kerja_diterimas', function (Blueprint $table) {
            $table->string('status_karyawan')->default('aktif')->after('tgl_masuk');
        });
    }

    public function down(): void
    {
        Schema::table('data_pencari_kerja_diterimas', function (Blueprint $table) {
            $table->dropColumn('status_karyawan');
        });
    }
};