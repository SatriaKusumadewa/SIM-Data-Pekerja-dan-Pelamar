<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->string('jenis_kelamin', 50)->nullable()->after('nama');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tgl_lahir')->nullable()->after('tempat_lahir');
        });
    }

    public function down(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'tempat_lahir',
                'tgl_lahir',
            ]);
        });
    }
};