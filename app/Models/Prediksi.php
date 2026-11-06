<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;

    protected $table = 'prediksi';

    protected $fillable = [
        'instansi_id',
        'bulan',
        'tahun',
        'prediksi_perempuan',
        'prediksi_laki_laki',
        'prediksi_gaji',
        'confidence_score',
        'is_dummy' // Flag untuk menandai prediksi dummy
    ];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
        'prediksi_perempuan' => 'integer',
        'prediksi_laki_laki' => 'integer',
        'prediksi_gaji' => 'decimal:2',
        'confidence_score' => 'decimal:2',
        'is_dummy' => 'boolean'
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function getTotalPrediksiAttribute()
    {
        return $this->prediksi_perempuan + $this->prediksi_laki_laki;
    }

    public function getPrediksiBelanjaAttribute()
    {
        return $this->total_prediksi * $this->prediksi_gaji;
    }

    public function getNamaBulanAttribute()
    {
        $bulanIndonesia = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulanIndonesia[$this->bulan] ?? '';
    }
}