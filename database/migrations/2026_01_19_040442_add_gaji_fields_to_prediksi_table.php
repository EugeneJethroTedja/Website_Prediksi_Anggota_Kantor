<?php

// ============================================
// MIGRATION: add_gaji_fields_to_prediksi
// database/migrations/xxxx_xx_xx_add_gaji_fields_to_prediksi_table.php
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('prediksi', function (Blueprint $table) {
            $table->decimal('prediksi_gaji', 15, 2)->default(0)->after('prediksi_laki_laki');
            $table->boolean('is_dummy')->default(false)->after('confidence_score');
        });
    }

    public function down()
    {
        Schema::table('prediksi', function (Blueprint $table) {
            $table->dropColumn(['prediksi_gaji', 'is_dummy']);
        });
    }
};