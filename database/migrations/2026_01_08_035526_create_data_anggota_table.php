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
    Schema::create('data_anggota', function (Blueprint $table) {
        $table->id();

        // Relasi ke instansi
        $table->foreignId('instansi_id')->constrained('instansi');

        // Periode data
        $table->integer('bulan');
        $table->integer('tahun');

        // Data jumlah anggota
        $table->integer('jumlah_laki_laki');
        $table->integer('jumlah_perempuan');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_anggota');
    }
};
