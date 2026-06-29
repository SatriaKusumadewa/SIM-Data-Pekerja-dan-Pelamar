<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
    {
        Schema::create('data_pencari_kerja_diterimas', function (Blueprint $table) {
            $table->string('nik')->primary();
            $table->unsignedBigInteger('pelamar_id')->nullable();

            $table->string('nama_karyawan');
            $table->string('nama_bank');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->text('alamat');
            $table->string('no_telepon');
            $table->string('email')->unique();
            $table->string('jabatan');
            $table->string('divisi');
            $table->date('tgl_masuk');
            $table->string('no_rekening');
            $table->timestamps();

            $table->foreign('pelamar_id')->references('id')->on('pelamars')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
        public function down(): void
    {
        Schema::dropIfExists('data_pencari_kerja_diterimas');
    }
};
