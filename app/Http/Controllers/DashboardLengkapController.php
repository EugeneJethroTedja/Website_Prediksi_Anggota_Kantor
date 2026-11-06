<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\DataAnggotaLengkap;
use App\Models\PrediksiLengkap;
use App\Services\PredictionLengkapService;
use Illuminate\Http\Request;

class DashboardLengkapController extends Controller
{
    protected $predictionService;

    public function __construct(PredictionLengkapService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    public function index(Request $request)
    {
        // Get filter parameters
        $bulanMulai = $request->get('bulan_mulai');
        $tahunMulai = $request->get('tahun_mulai');
        $bulanSelesai = $request->get('bulan_selesai');
        $tahunSelesai = $request->get('tahun_selesai');
        $predictionMethod = $request->get('prediction_method', 'combined');

        // Get available prediction methods
        $availableMethods = $this->predictionService->getAvailableMethods();

        // If filters provided, generate predictions for that range
        if ($bulanMulai && $tahunMulai && $bulanSelesai && $tahunSelesai) {
            // Validate date range
            $start = ($tahunMulai * 12) + $bulanMulai;
            $end = ($tahunSelesai * 12) + $bulanSelesai;

            if ($start <= $end) {
                $this->predictionService->predictDateRange(
                    $bulanMulai, $tahunMulai, $bulanSelesai, $tahunSelesai, $predictionMethod
                );
            }
        }

        // Get data for dashboard
        $periodeList = Periode::where('is_active', true)->withCount('dataAnggotaLengkap')->get();

        // Get predictions based on filters
        $prediksiQuery = PrediksiLengkap::with('periode');

        if ($bulanMulai && $tahunMulai) {
            $startMonth = ($tahunMulai * 12) + $bulanMulai;
            $prediksiQuery->whereRaw('(tahun * 12 + bulan) >= ?', [$startMonth]);
        }

        if ($bulanSelesai && $tahunSelesai) {
            $endMonth = ($tahunSelesai * 12) + $bulanSelesai;
            $prediksiQuery->whereRaw('(tahun * 12 + bulan) <= ?', [$endMonth]);
        }

        // Filter by prediction method if specified
        if ($request->filled('filter_method') && $request->get('filter_method') != 'all') {
            $prediksiQuery->where('prediction_method', $request->get('filter_method'));
        }

        $prediksiTerbaru = $prediksiQuery->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        // Calculate totals
        $totalPrediksiPerempuan = $prediksiTerbaru->sum('total_prediksi_perempuan');
        $totalPrediksiLakiLaki = $prediksiTerbaru->sum('total_prediksi_laki_laki');
        $totalPrediksiSemua = $totalPrediksiPerempuan + $totalPrediksiLakiLaki;

        // Summary by category
        $summaryPendidikan = $this->getSummaryPendidikan($prediksiTerbaru);
        $summaryGolongan = $this->getSummaryGolongan($prediksiTerbaru);
        $summaryJabatan = $this->getSummaryJabatan($prediksiTerbaru);
        $summaryAgama = $this->getSummaryAgama($prediksiTerbaru);
        
        // Summary JF
        $summaryJfTertentuPns = $this->getSummaryJfTertentuPns($prediksiTerbaru);
        $summaryJfTertentuPppk = $this->getSummaryJfTertentuPppk($prediksiTerbaru);
        $summaryJfPelaksanaPns = $this->getSummaryJfPelaksanaPns($prediksiTerbaru);
        $summaryJfPelaksanaPppk = $this->getSummaryJfPelaksanaPppk($prediksiTerbaru);

        // Chart data
        $chartData = $this->prepareChartData($request);

        $bulanList = $this->getBulanList();

        // Calculate prediction result info
        $predictionResultInfo = $this->calculatePredictionResultInfo($bulanMulai, $tahunMulai, $bulanSelesai, $tahunSelesai);

        return view('dashboard-lengkap.index', compact(
            'periodeList',
            'prediksiTerbaru',
            'totalPrediksiPerempuan',
            'totalPrediksiLakiLaki',
            'totalPrediksiSemua',
            'summaryPendidikan',
            'summaryGolongan',
            'summaryJabatan',
            'summaryAgama',
            'summaryJfTertentuPns',
            'summaryJfTertentuPppk',
            'summaryJfPelaksanaPns',
            'summaryJfPelaksanaPppk',
            'chartData',
            'bulanList',
            'availableMethods',
            'predictionMethod',
            'predictionResultInfo'
        ));
    }

    private function calculatePredictionResultInfo($bulanMulai, $tahunMulai, $bulanSelesai, $tahunSelesai)
    {
        if (!$bulanMulai || !$tahunMulai || !$bulanSelesai || !$tahunSelesai) {
            return null;
        }

        $bulanList = $this->getBulanList();
        
        return [
            'start' => $bulanList[$bulanMulai] . ' ' . $tahunMulai,
            'end' => $bulanList[$bulanSelesai] . ' ' . $tahunSelesai,
            'bulan_mulai' => $bulanMulai,
            'tahun_mulai' => $tahunMulai,
            'bulan_selesai' => $bulanSelesai,
            'tahun_selesai' => $tahunSelesai,
            'total_months' => (($tahunSelesai - $tahunMulai) * 12) + ($bulanSelesai - $bulanMulai) + 1
        ];
    }

    private function getSummaryPendidikan($prediksi)
    {
        $summary = [];
        $labels = ['SD', 'SLTP', 'SLTA', 'DI', 'DII', 'DIII', 'DIV', 'S1', 'S2', 'S3'];
        
        foreach ($labels as $label) {
            $field = 'pred_pend_' . strtolower($label);
            $summary[$label] = [
                'laki' => $prediksi->sum($field . '_laki'),
                'perempuan' => $prediksi->sum($field . '_perempuan'),
            ];
            $summary[$label]['total'] = $summary[$label]['laki'] + $summary[$label]['perempuan'];
        }

        return $summary;
    }

    private function getSummaryGolongan($prediksi)
    {
        $summary = [];
        // UPDATED: tambah golongan I-XII
        $golongan = [
            'IA', 'IB', 'IC', 'ID', 
            'IIA', 'IIB', 'IIC', 'IID', 
            'IIIA', 'IIIB', 'IIIC', 'IIID', 
            'IVA', 'IVB', 'IVC', 'IVD', 'IVE',
            'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
        ];
        
        foreach ($golongan as $gol) {
            $field = 'pred_gol_' . strtolower($gol);
            $summary[$gol] = [
                'laki' => $prediksi->sum($field . '_laki'),
                'perempuan' => $prediksi->sum($field . '_perempuan'),
            ];
            $summary[$gol]['total'] = $summary[$gol]['laki'] + $summary[$gol]['perempuan'];
        }

        return $summary;
    }

    private function getSummaryJabatan($prediksi)
    {
        $summary = [];
        $jabatan = ['2A', '2B', '3A', '3B', '4A', '4B', '5A'];
        
        foreach ($jabatan as $jab) {
            $field = 'pred_jab_' . strtolower($jab);
            $summary[$jab] = [
                'laki' => $prediksi->sum($field . '_laki'),
                'perempuan' => $prediksi->sum($field . '_perempuan'),
            ];
            $summary[$jab]['total'] = $summary[$jab]['laki'] + $summary[$jab]['perempuan'];
        }

        return $summary;
    }

    private function getSummaryAgama($prediksi)
    {
        $summary = [];
        $agama = ['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha'];
        
        foreach ($agama as $ag) {
            $field = 'pred_agama_' . strtolower($ag);
            $summary[$ag] = [
                'laki' => $prediksi->sum($field . '_laki'),
                'perempuan' => $prediksi->sum($field . '_perempuan'),
            ];
            $summary[$ag]['total'] = $summary[$ag]['laki'] + $summary[$ag]['perempuan'];
        }

        return $summary;
    }

    private function getSummaryJfTertentuPns($prediksi)
    {
        $summary = [];
        $jfList = ['I', 'II', 'III', 'IV'];
        
        foreach ($jfList as $jf) {
            $field = 'pred_jf_tertentu_pns_' . strtolower($jf);
            $summary[$jf] = $prediksi->sum($field);
        }

        return $summary;
    }

    private function getSummaryJfTertentuPppk($prediksi)
    {
        $summary = [];
        $jfList = ['V', 'VII', 'IX', 'X', 'XI'];
        
        foreach ($jfList as $jf) {
            $field = 'pred_jf_tertentu_pppk_' . strtolower($jf);
            $summary[$jf] = $prediksi->sum($field);
        }

        return $summary;
    }

    private function getSummaryJfPelaksanaPns($prediksi)
    {
        $summary = [];
        $jfList = ['I', 'II', 'III', 'IV'];
        
        foreach ($jfList as $jf) {
            $field = 'pred_jf_pelaksana_pns_' . strtolower($jf);
            $summary[$jf] = $prediksi->sum($field);
        }

        return $summary;
    }

    private function getSummaryJfPelaksanaPppk($prediksi)
    {
        $summary = [];
        $jfList = ['I', 'III', 'V', 'VII', 'IX', 'X'];
        
        foreach ($jfList as $jf) {
            $field = 'pred_jf_pelaksana_pppk_' . strtolower($jf);
            $summary[$jf] = $prediksi->sum($field);
        }

        return $summary;
    }

    private function prepareChartData($request)
    {
        $periodes = Periode::where('is_active', true)->get();
        $chartData = [];

        foreach ($periodes as $periode) {
            // Get historical data
            $historicalQuery = DataAnggotaLengkap::where('periode_id', $periode->id);
            
            // Apply date range filter if provided
            $bulanMulai = $request->get('bulan_mulai');
            $tahunMulai = $request->get('tahun_mulai');
            $bulanSelesai = $request->get('bulan_selesai');
            $tahunSelesai = $request->get('tahun_selesai');
            
            if ($bulanMulai && $tahunMulai) {
                $startMonth = ($tahunMulai * 12) + $bulanMulai;
                $historicalQuery->whereRaw('(tahun * 12 + bulan) >= ?', [$startMonth]);
            }
            
            if ($bulanSelesai && $tahunSelesai) {
                $endMonth = ($tahunSelesai * 12) + $bulanSelesai;
                $historicalQuery->whereRaw('(tahun * 12 + bulan) <= ?', [$endMonth]);
            }
            
            // If no filter, get last 12 months
            if (!$bulanMulai && !$tahunMulai) {
                $historicalQuery->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'desc')
                    ->limit(12);
            }
            
            $historicalData = $historicalQuery->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->get();

            // Get predictions in the same range
            $prediksiQuery = PrediksiLengkap::where('periode_id', $periode->id);
            
            if ($bulanMulai && $tahunMulai) {
                $startMonth = ($tahunMulai * 12) + $bulanMulai;
                $prediksiQuery->whereRaw('(tahun * 12 + bulan) >= ?', [$startMonth]);
            }
            
            if ($bulanSelesai && $tahunSelesai) {
                $endMonth = ($tahunSelesai * 12) + $bulanSelesai;
                $prediksiQuery->whereRaw('(tahun * 12 + bulan) <= ?', [$endMonth]);
            } else {
                // If no end filter, get predictions after last historical data
                if ($historicalData->isNotEmpty()) {
                    $lastHistorical = $historicalData->last();
                    $lastMonth = ($lastHistorical->tahun * 12) + $lastHistorical->bulan;
                    $prediksiQuery->whereRaw('(tahun * 12 + bulan) > ?', [$lastMonth]);
                }
            }
            
            // Filter by method if specified
            if ($request->filled('filter_method') && $request->get('filter_method') != 'all') {
                $prediksiQuery->where('prediction_method', $request->get('filter_method'));
            }
            
            $predictions = $prediksiQuery->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->get();

            $labels = [];
            $dataPerempuan = [];
            $dataLakiLaki = [];

            // Add historical data
            foreach ($historicalData as $data) {
                $labels[] = $data->nama_bulan . ' ' . $data->tahun;
                $dataPerempuan[] = $data->total_perempuan;
                $dataLakiLaki[] = $data->total_laki_laki;
            }

            // Add prediction data
            foreach ($predictions as $prediksi) {
                $methodLabel = $prediksi->prediction_method_name ?? 'Prediksi';
                $labels[] = $prediksi->nama_bulan . ' ' . $prediksi->tahun . ' (' . $methodLabel . ')';
                $dataPerempuan[] = round($prediksi->total_prediksi_perempuan);
                $dataLakiLaki[] = round($prediksi->total_prediksi_laki_laki);
            }

            $chartData[$periode->id] = [
                'labels' => $labels,
                'perempuan' => $dataPerempuan,
                'laki_laki' => $dataLakiLaki,
                'nama_periode' => $periode->nama_periode,
                'has_prediction' => $predictions->isNotEmpty(),
                'prediction_count' => $predictions->count(),
                'prediction_methods' => $predictions->pluck('prediction_method')->unique()->values()->toArray()
            ];
        }

        return $chartData;
    }

    private function getBulanList()
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    }
}