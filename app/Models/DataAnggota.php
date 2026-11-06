<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnggota extends Model
{
    use HasFactory;

    protected $table = 'data_anggota';

    protected $fillable = [
        'instansi_id',
        'bulan',
        'tahun',
        'jumlah_perempuan',
        'jumlah_laki_laki',
        'rata_rata_gaji'
    ];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
        'jumlah_perempuan' => 'integer',
        'jumlah_laki_laki' => 'integer',
        'rata_rata_gaji' => 'decimal:2',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function getTotalAnggotaAttribute()
    {
        return $this->jumlah_perempuan + $this->jumlah_laki_laki;
    }

    public function getTotalBelanjaAttribute()
    {
        return $this->total_anggota * $this->rata_rata_gaji;
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