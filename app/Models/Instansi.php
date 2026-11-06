<?php

// ============================================
// MODEL 1: Instansi.php
// app/Models/Instansi.php
// ============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi';

    protected $fillable = [
        'nama_instansi',
        'keterangan'
    ];

    public function dataAnggota()
    {
        return $this->hasMany(DataAnggota::class);
    }

    public function prediksi()
    {
        return $this->hasMany(Prediksi::class);
    }
}