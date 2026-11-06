<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prediksi_lengkap', function (Blueprint $table) {
            // Tambah kolom prediction_method setelah tahun
            // Karena ini metadata tentang prediksi, letakkan bersama periode/bulan/tahun
            $table->string('prediction_method', 50)
                  ->default('combined')
                  ->after('tahun')  // ← UBAH INI, taruh setelah 'tahun'
                  ->comment('Metode prediksi: combined, exponential_smoothing, linear_trend, weighted_moving_average, arima');
        });
    }

    public function down(): void
    {
        Schema::table('prediksi_lengkap', function (Blueprint $table) {
            $table->dropColumn('prediction_method');
        });
    }
};