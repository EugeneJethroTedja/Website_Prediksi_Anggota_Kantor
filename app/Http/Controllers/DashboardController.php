<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\DataAnggota;
use App\Models\Prediksi;
use App\Services\PredictionService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $predictionService;

    public function __construct(PredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    public function index(Request $request)
    {
        $instansiId = $request->get('instansi_id');
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'nama');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $customBulan = $request->get('custom_bulan');
        $customTahun = $request->get('custom_tahun');

        $useCustomPrediction = $customBulan && $customTahun;

        // ✅ ALWAYS regenerate predictions on page load
        \Log::info("=== REGENERATE PREDIKSI ===");
        Prediksi::where('is_dummy', false)->delete();
        
        if (!$useCustomPrediction) {
            // MODE NORMAL: Generate prediksi untuk bulan berikutnya
            $this->predictionService->predictAllInstansiNextMonth();
        }

        $instansiQuery = Instansi::withCount('dataAnggota');

        if ($search) {
            $instansiQuery->where('nama_instansi', 'LIKE', "%{$search}%");
        }

        if ($sortBy === 'nama') {
            $instansiQuery->orderBy('nama_instansi', $sortOrder);
        } elseif ($sortBy === 'data') {
            $instansiQuery->withCount('dataAnggota')->orderBy('data_anggota_count', $sortOrder);
        }

        $instansiList = $instansiQuery->get();
        
        $prediksiTerbaru = collect();

        if ($useCustomPrediction) {
            \Log::info("=== MODE CUSTOM PREDIKSI: {$customBulan}/{$customTahun} ===");
            
            // ✅ Cari data terakhir absolut untuk menentukan starting point
            $absoluteLastData = DataAnggota::orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->first();

            if (!$absoluteLastData) {
                \Log::warning("Tidak ada data historis untuk custom prediksi");
            } else {
                foreach ($instansiList as $instansi) {
                    if ($instansiId && $instansi->id != $instansiId) {
                        continue;
                    }

                    $lastData = DataAnggota::where('instansi_id', $instansi->id)
                        ->orderBy('tahun', 'desc')
                        ->orderBy('bulan', 'desc')
                        ->first();

                    if (!$lastData) continue;

                    // ✅ Generate custom predictions menggunakan data terakhir absolut
                    $predictions = $this->predictionService->predictAndSaveToTargetMonth(
                        $instansi->id, 
                        $customBulan, 
                        $customTahun,
                        $absoluteLastData->bulan,
                        $absoluteLastData->tahun
                    );

                    // ✅ Semua predictions dari service sudah difilter sesuai periode
                    foreach ($predictions as $pred) {
                        $prediksiTerbaru->push($pred);
                    }
                }
            }
        } else {
            // ✅ MODE NORMAL: Ambil dari database
            \Log::info("=== MODE NORMAL: Ambil prediksi dari database ===");
            
            $prediksiQuery = Prediksi::where('is_dummy', false)
                ->with('instansi');

            if ($instansiId) {
                $prediksiQuery->where('instansi_id', $instansiId);
            }

            $allPrediksi = $prediksiQuery->get();

            \Log::info("Total prediksi di database: " . $allPrediksi->count());

            // ✅ Filter: Bulan cocok dengan nama periode (dengan handling typo)
            foreach ($allPrediksi as $pred) {
                $namaBulanPeriode = $this->extractBulanFromNamaInstansi($pred->instansi->nama_instansi);
                $namaBulanPrediksi = $this->getNamaBulan($pred->bulan);

                // ✅ Normalize untuk perbandingan
                $periodeBulanNormalized = $this->normalizeBulanName($namaBulanPeriode);
                $predBulanNormalized = $this->normalizeBulanName($namaBulanPrediksi);

                \Log::info("Cek: Periode={$pred->instansi->nama_instansi}, BulanPeriode={$namaBulanPeriode} (normalized: {$periodeBulanNormalized}), BulanPrediksi={$namaBulanPrediksi} (normalized: {$predBulanNormalized})");

                if ($periodeBulanNormalized === $predBulanNormalized) {
                    $prediksiTerbaru->push($pred);
                    \Log::info("✓ Prediksi ditampilkan: {$pred->instansi->nama_instansi} - {$namaBulanPrediksi} {$pred->tahun}");
                } else {
                    \Log::info("✗ Prediksi difilter (tidak sesuai periode)");
                }
            }

            \Log::info("Total prediksi yang ditampilkan: " . $prediksiTerbaru->count());
        }

        // ✅✅✅ SORTING LOGIC - PRIORITAS TERTINGGI UNTUK CUSTOM PREDICTION
        if ($useCustomPrediction) {
            // ✅ Untuk custom prediction, SELALU urutkan berdasarkan TAHUN lalu BULAN
            $prediksiTerbaru = $prediksiTerbaru->sort(function ($a, $b) {
                // 1. Bandingkan tahun terlebih dahulu
                if ($a->tahun != $b->tahun) {
                    return $a->tahun <=> $b->tahun; // Tahun kecil di atas
                }
                
                // 2. Jika tahun sama, bandingkan bulan
                return $a->bulan <=> $b->bulan; // Januari (1) di atas, Desember (12) di bawah
            })->values(); // Reset index
            
            \Log::info("Custom Prediction: Data diurutkan berdasarkan Tahun ASC -> Bulan ASC (Januari-Desember)");
        } else {
            // ✅ MODE NORMAL: Sort sesuai pilihan user
            if ($sortBy === 'total') {
                $prediksiTerbaru = $sortOrder === 'asc' 
                    ? $prediksiTerbaru->sortBy('total_prediksi')
                    : $prediksiTerbaru->sortByDesc('total_prediksi');
            } elseif ($sortBy === 'perempuan') {
                $prediksiTerbaru = $sortOrder === 'asc'
                    ? $prediksiTerbaru->sortBy('prediksi_perempuan')
                    : $prediksiTerbaru->sortByDesc('prediksi_perempuan');
            } elseif ($sortBy === 'laki') {
                $prediksiTerbaru = $sortOrder === 'asc'
                    ? $prediksiTerbaru->sortBy('prediksi_laki_laki')
                    : $prediksiTerbaru->sortByDesc('prediksi_laki_laki');
            } elseif ($sortBy === 'nama') {
                $prediksiTerbaru = $sortOrder === 'asc'
                    ? $prediksiTerbaru->sortBy(function($item) {
                        return $item->instansi->nama_instansi ?? '';
                    })
                    : $prediksiTerbaru->sortByDesc(function($item) {
                        return $item->instansi->nama_instansi ?? '';
                    });
            }
        }

        // Calculate totals
        $totalPrediksiPerempuan = $prediksiTerbaru->sum('prediksi_perempuan');
        $totalPrediksiLakiLaki = $prediksiTerbaru->sum('prediksi_laki_laki');
        $totalPrediksiSemua = $totalPrediksiPerempuan + $totalPrediksiLakiLaki;
        
        $totalBelanja = 0;
        foreach ($prediksiTerbaru as $pred) {
            $gaji = is_object($pred) && isset($pred->prediksi_gaji) ? $pred->prediksi_gaji : 0;
            $total = is_object($pred) && isset($pred->total_prediksi) ? $pred->total_prediksi : 0;
            // ✅ Total Belanja = Prediksi Gaji × Total Prediksi Anggota
            $totalBelanja += $gaji * $total;
        }

        // Chart data
        $chartData = $this->prepareChartData($instansiId, $useCustomPrediction, $customBulan, $customTahun);

        // Info bulan prediksi
        $dataAbsolutTerakhir = DataAnggota::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        if ($useCustomPrediction) {
            // ✅ Untuk custom prediction, cari range dari prediksi yang ditampilkan
            $firstPred = $prediksiTerbaru->sortBy([['tahun', 'asc'], ['bulan', 'asc']])->first();
            $lastPred = $prediksiTerbaru->sortBy([['tahun', 'desc'], ['bulan', 'desc']])->last();
            
            if ($firstPred && $lastPred && $firstPred->id !== $lastPred->id) {
                $infoBulanPrediksi = [
                    'bulan' => 'Custom Range',
                    'tahun' => '',
                    'bulan_angka' => 0,
                    'is_range' => true,
                    'range_text' => $this->getNamaBulan($firstPred->bulan) . ' ' . $firstPred->tahun . ' - ' . 
                                   $this->getNamaBulan($lastPred->bulan) . ' ' . $lastPred->tahun
                ];
            } else {
                $infoBulanPrediksi = [
                    'bulan' => $this->getNamaBulan($customBulan),
                    'tahun' => $customTahun,
                    'bulan_angka' => $customBulan,
                    'is_range' => false
                ];
            }
        } else {
            if ($dataAbsolutTerakhir) {
                $nextMonth = $dataAbsolutTerakhir->bulan + 1;
                $nextYear = $dataAbsolutTerakhir->tahun;
                
                if ($nextMonth > 12) {
                    $nextMonth = 1;
                    $nextYear++;
                }
                
                $infoBulanPrediksi = [
                    'bulan' => $this->getNamaBulan($nextMonth),
                    'tahun' => $nextYear,
                    'bulan_angka' => $nextMonth,
                    'is_range' => false
                ];
            } else {
                $nextMonth = Carbon::now()->addMonth();
                $infoBulanPrediksi = [
                    'bulan' => $this->getNamaBulan($nextMonth->month),
                    'tahun' => $nextMonth->year,
                    'bulan_angka' => $nextMonth->month,
                    'is_range' => false
                ];
            }
        }

        $allInstansi = Instansi::orderBy('nama_instansi')->get();
        
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('dashboard.index', compact(
            'instansiList', 
            'prediksiTerbaru', 
            'chartData',
            'infoBulanPrediksi',
            'totalPrediksiPerempuan',
            'totalPrediksiLakiLaki',
            'totalPrediksiSemua',
            'totalBelanja',
            'allInstansi',
            'bulanList',
            'useCustomPrediction'
        ));
    }

    private function extractBulanFromNamaInstansi($namaInstansi)
    {
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // ✅ Handle typo
        $typoMap = [
            'Febuari' => 'Februari',
            'Pebruari' => 'Februari'
        ];

        // Check typo first
        foreach ($typoMap as $typo => $correct) {
            if (stripos($namaInstansi, $typo) !== false) {
                return $correct;
            }
        }

        // Check nama bulan normal
        foreach ($bulanList as $bulan) {
            if (stripos($namaInstansi, $bulan) !== false) {
                return $bulan;
            }
        }

        return '';
    }

    private function normalizeBulanName($namaBulan)
    {
        $typoMap = [
            'Febuari' => 'Februari',
            'Pebruari' => 'Februari'
        ];

        return $typoMap[$namaBulan] ?? $namaBulan;
    }

    // ✅ TAMBAHAN: Method untuk convert nama bulan ke angka
    private function getBulanNumber($namaBulan)
    {
        // ✅ Normalize dulu
        $namaBulan = $this->normalizeBulanName($namaBulan);

        $bulanMap = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3,
            'April' => 4, 'Mei' => 5, 'Juni' => 6,
            'Juli' => 7, 'Agustus' => 8, 'September' => 9,
            'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        return $bulanMap[$namaBulan] ?? 999; // 999 untuk bulan tidak dikenal (akan di-sort ke belakang)
    }

    private function prepareChartData($instansiIdFilter, $useCustomPrediction, $customBulan, $customTahun)
    {
        $instansiQuery = Instansi::query();
        
        if ($instansiIdFilter) {
            $instansiQuery->where('id', $instansiIdFilter);
        }

        $instansi = $instansiQuery->get();
        $chartData = [];

        foreach ($instansi as $inst) {
            $historicalData = DataAnggota::where('instansi_id', $inst->id)
                ->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->get();

            // ✅ Ambil 6 data terakhir untuk chart
            $limitedHistoricalData = $historicalData->reverse()->take(6)->reverse();

            $labels = [];
            $dataPerempuan = [];
            $dataLakiLaki = [];
            $dataGaji = [];

            foreach ($limitedHistoricalData as $data) {
                $labels[] = $this->getNamaBulan($data->bulan) . ' ' . $data->tahun;
                $dataPerempuan[] = $data->jumlah_perempuan;
                $dataLakiLaki[] = $data->jumlah_laki_laki;
                $dataGaji[] = $data->rata_rata_gaji;
            }

            $namaBulanPeriode = $this->extractBulanFromNamaInstansi($inst->nama_instansi);

            // Ambil prediksi yang cocok dari database
            $predictions = Prediksi::where('instansi_id', $inst->id)
                ->where('is_dummy', false)
                ->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->get();

            $hasPrediction = false;

            foreach ($predictions as $pred) {
                $namaBulanPrediksi = $this->getNamaBulan($pred->bulan);
                
                // ✅ Normalize untuk perbandingan
                $periodeBulanNormalized = $this->normalizeBulanName($namaBulanPeriode);
                $predBulanNormalized = $this->normalizeBulanName($namaBulanPrediksi);
                
                // ✅ HANYA tambahkan ke chart jika bulan cocok
                if ($periodeBulanNormalized === $predBulanNormalized) {
                    $labels[] = $this->getNamaBulan($pred->bulan) . ' ' . $pred->tahun . ' (Prediksi)';
                    $dataPerempuan[] = round($pred->prediksi_perempuan);
                    $dataLakiLaki[] = round($pred->prediksi_laki_laki);
                    $dataGaji[] = round($pred->prediksi_gaji, 2);
                    $hasPrediction = true;
                }
            }

            $chartData[$inst->id] = [
                'labels' => $labels,
                'perempuan' => $dataPerempuan,
                'laki_laki' => $dataLakiLaki,
                'gaji' => $dataGaji,
                'nama_instansi' => $inst->nama_instansi,
                'has_prediction' => $hasPrediction
            ];
        }

        return $chartData;
    }

    private function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $namaBulan[$bulan] ?? $bulan;
    }
}