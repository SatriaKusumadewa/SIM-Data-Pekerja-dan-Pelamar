<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            if (!Schema::hasColumn('pelamars', 'scan_ktp')) {
                $table->text('scan_ktp')->nullable();
            }

            if (!Schema::hasColumn('pelamars', 'scan_ijazah')) {
                $table->text('scan_ijazah')->nullable();
            }

            if (!Schema::hasColumn('pelamars', 'foto')) {
                $table->text('foto')->nullable();
            }

            if (!Schema::hasColumn('pelamars', 'cv')) {
                $table->text('cv')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $columns = [];

            foreach (['scan_ktp', 'scan_ijazah', 'foto', 'cv'] as $column) {
                if (Schema::hasColumn('pelamars', $column)) {
                    $columns[] = $column;
                }
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};