<?php

// ============================================
// MIGRATION: add_rata_rata_gaji_to_data_anggota
// database/migrations/xxxx_xx_xx_add_rata_rata_gaji_to_data_anggota_table.php
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('data_anggota', function (Blueprint $table) {
            $table->decimal('rata_rata_gaji', 15, 2)->default(0)->after('jumlah_laki_laki');
        });
    }

    public function down()
    {
        Schema::table('data_anggota', function (Blueprint $table) {
            $table->dropColumn('rata_rata_gaji');
        });
    }
};