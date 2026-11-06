<?php

// ============================================
// MIGRATION: Simplify Periode Table
// database/migrations/xxxx_simplify_periode_table.php
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('periode', function (Blueprint $table) {
        $table->id();
        $table->string('nama_periode');

        // Dipakai di query: where is_active = 1
        $table->boolean('is_active')->default(false);

        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('periode');
}


};