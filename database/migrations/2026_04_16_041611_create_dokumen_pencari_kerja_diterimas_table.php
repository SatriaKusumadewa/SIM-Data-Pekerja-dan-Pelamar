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
        Schema::create('dokumen_pencari_kerja_diterimas', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->string('nik');
            $table->string('ktp')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('foto')->nullable();
            $table->string('rekening')->nullable();
            $table->timestamps();

            $table->foreign('nik')
                ->references('nik')
                ->on('data_pencari_kerja_diterimas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
        public function down(): void
    {
        Schema::dropIfExists('dokumen_pencari_kerja_diterimas');
    }
};
