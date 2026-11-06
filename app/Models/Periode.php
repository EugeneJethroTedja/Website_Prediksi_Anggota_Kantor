<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';

    protected $fillable = [
        'nama_periode',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function dataAnggotaLengkap()
    {
        return $this->hasMany(DataAnggotaLengkap::class, 'periode_id');
    }

    public function prediksiLengkap()
    {
        return $this->hasMany(PrediksiLengkap::class, 'periode_id');
    }

    // Accessor: Get date range dari data yang ada
    public function getDateRangeAttribute()
    {
        $minMax = $this->dataAnggotaLengkap()
            ->selectRaw('MIN(tahun * 100 + bulan) as min_date, MAX(tahun * 100 + bulan) as max_date')
            ->first();

        if (!$minMax || !$minMax->min_date) {
            return 'Belum ada data';
        }

        $bulanList = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $minTahun = floor($minMax->min_date / 100);
        $minBulan = $minMax->min_date % 100;
        $maxTahun = floor($minMax->max_date / 100);
        $maxBulan = $minMax->max_date % 100;

        return ($bulanList[$minBulan] ?? '') . ' ' . $minTahun . ' - ' . 
               ($bulanList[$maxBulan] ?? '') . ' ' . $maxTahun;
    }

    // Scope: Only active periods
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}