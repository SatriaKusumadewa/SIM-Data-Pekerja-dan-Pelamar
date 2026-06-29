<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_pencari_kerja_diterimas', function (Blueprint $table) {
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'ktp_path')) {
                $table->string('ktp_path')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'ktp_original_name')) {
                $table->string('ktp_original_name')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'ktp_mime')) {
                $table->string('ktp_mime')->nullable();
            }

            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'ijazah_path')) {
                $table->string('ijazah_path')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'ijazah_original_name')) {
                $table->string('ijazah_original_name')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'ijazah_mime')) {
                $table->string('ijazah_mime')->nullable();
            }

            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'foto_path')) {
                $table->string('foto_path')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'foto_original_name')) {
                $table->string('foto_original_name')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'foto_mime')) {
                $table->string('foto_mime')->nullable();
            }

            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'buku_rekening_path')) {
                $table->string('buku_rekening_path')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'buku_rekening_original_name')) {
                $table->string('buku_rekening_original_name')->nullable();
            }
            if (!Schema::hasColumn('dokumen_pencari_kerja_diterimas', 'buku_rekening_mime')) {
                $table->string('buku_rekening_mime')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_pencari_kerja_diterimas', function (Blueprint $table) {
            $columns = [
                'ktp_path',
                'ktp_original_name',
                'ktp_mime',
                'ijazah_path',
                'ijazah_original_name',
                'ijazah_mime',
                'foto_path',
                'foto_original_name',
                'foto_mime',
                'buku_rekening_path',
                'buku_rekening_original_name',
                'buku_rekening_mime',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('dokumen_pencari_kerja_diterimas', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};