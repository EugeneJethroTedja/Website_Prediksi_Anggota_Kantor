<?php

namespace App\Services;

use App\Models\DataAnggota;
use App\Models\Prediksi;
use App\Models\Instansi;
use Carbon\Carbon;

class PredictionService
{
    /**
     * ✅ KONSTANTA KENAIKAN GAJI PER TAHUN
     */
    private const KENAIKAN_GAJI_TAHUNAN = 0.02; // 2% per tahun

    /**
     * ✅ Prediksi SEMUA instansi untuk bulan berikutnya dan SIMPAN ke database
     */
    public function predictAllInstansiNextMonth()
    {
        \Log::info("=== PREDIKSI SEMUA INSTANSI BULAN BERIKUTNYA ===");

        $absoluteLastData = DataAnggota::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        if (!$absoluteLastData) {
            \Log::warning("Tidak ada data sama sekali di database");
            return [];
        }

        $nextMonth = $absoluteLastData->bulan + 1;
        $nextYear = $absoluteLastData->tahun;
        
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }

        \Log::info("Data terakhir absolut: {$absoluteLastData->bulan}/{$absoluteLastData->tahun}");
        \Log::info("Target prediksi: Bulan {$nextMonth}/{$nextYear}");

        $namaBulanTarget = $this->getNamaBulan($nextMonth);
        
        $allInstansi = Instansi::all();
        $results = [];

        foreach ($allInstansi as $instansi) {
            $periodeBulan = $this->extractBulanFromNamaInstansi($instansi->nama_instansi);
            
            if (empty($periodeBulan)) {
                \Log::warning("Instansi {$instansi->id} ({$instansi->nama_instansi}): Tidak dapat mendeteksi bulan dari nama");
                continue;
            }

            $periodeBulanNormalized = $this->normalizeBulanName($periodeBulan);
            $targetBulanNormalized = $this->normalizeBulanName($namaBulanTarget);

            if ($periodeBulanNormalized !== $targetBulanNormalized) {
                \Log::info("Skip {$instansi->nama_instansi}: Bulan periode ({$periodeBulan}) != target ({$namaBulanTarget})");
                continue;
            }

            \Log::info("✓ Memproses {$instansi->nama_instansi}: Bulan cocok ({$periodeBulan})");

            $historicalData = DataAnggota::where('instansi_id', $instansi->id)
                ->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->get();

            if ($historicalData->isEmpty() || $historicalData->count() < 2) {
                \Log::info("Instansi {$instansi->id}: Data tidak cukup (< 2 bulan)");
                continue;
            }

            $existingData = DataAnggota::where('instansi_id', $instansi->id)
                ->where('bulan', $nextMonth)
                ->where('tahun', $nextYear)
                ->exists();

            if ($existingData) {
                \Log::info("Instansi {$instansi->id}: Data real {$nextMonth}/{$nextYear} sudah ada, skip");
                continue;
            }

            $existingPrediction = Prediksi::where('instansi_id', $instansi->id)
                ->where('bulan', $nextMonth)
                ->where('tahun', $nextYear)
                ->where('is_dummy', false)
                ->exists();

            if ($existingPrediction) {
                \Log::info("Instansi {$instansi->id}: Prediksi {$nextMonth}/{$nextYear} sudah ada, skip");
                continue;
            }

            $prediction = $this->generateAndSavePrediction($instansi->id, $historicalData, $nextMonth, $nextYear);
            
            if ($prediction) {
                $results[] = $prediction;
                \Log::info("✓ Prediksi untuk {$instansi->nama_instansi} berhasil: {$namaBulanTarget} {$nextYear}");
            }
        }

        \Log::info("=== TOTAL PREDIKSI DISIMPAN: " . count($results) . " ===");
        return $results;
    }

    /**
     * ✅ Prediksi multi-bulan CUSTOM dan SIMPAN ke database
     */
    public function predictAndSaveToTargetMonth($instansiId, $targetMonth, $targetYear, $lastBulan, $lastTahun)
    {
        \Log::info("=== CUSTOM PREDIKSI Instansi {$instansiId}: {$lastBulan}/{$lastTahun} → {$targetMonth}/{$targetYear} ===");

        $historicalData = DataAnggota::where('instansi_id', $instansiId)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        if ($historicalData->isEmpty() || $historicalData->count() < 2) {
            \Log::warning("Instansi {$instansiId}: Data tidak cukup");
            return collect();
        }

        $instansi = Instansi::find($instansiId);
        $targetBulanName = $this->extractBulanFromNamaInstansi($instansi->nama_instansi);
        $periodeBulan = $this->getBulanNumber($targetBulanName);

        \Log::info("Target bulan untuk periode {$instansi->nama_instansi}: {$targetBulanName} (#{$periodeBulan})");

        $currentMonth = $lastBulan + 1;
        $currentYear = $lastTahun;

        if ($currentMonth > 12) {
            $currentMonth = 1;
            $currentYear++;
        }

        \Log::info("Mulai prediksi dari: {$currentMonth}/{$currentYear}");

        // ✅ Get data terakhir untuk base gaji
        $lastHistoricalData = $historicalData->last();
        $baseGaji = $lastHistoricalData->rata_rata_gaji;
        $baseTahun = $lastHistoricalData->tahun;

        $allData = $historicalData->map(function ($item) {
            return [
                'bulan' => $item->bulan,
                'tahun' => $item->tahun,
                'perempuan' => $item->jumlah_perempuan,
                'laki_laki' => $item->jumlah_laki_laki,
                'gaji' => $item->rata_rata_gaji,
                'is_prediction' => false
            ];
        })->toArray();

        $savedPredictions = collect();
        $iteration = 0;

        while (true) {
            $iteration++;
            
            if ($iteration > 100) {
                \Log::warning("Mencapai batas maksimal iterasi");
                break;
            }

            if ($currentYear > $targetYear || ($currentYear == $targetYear && $currentMonth > $targetMonth)) {
                \Log::info("✓ Mencapai/melewati target: {$targetMonth}/{$targetYear}");
                break;
            }

            $existingData = DataAnggota::where('instansi_id', $instansiId)
                ->where('bulan', $currentMonth)
                ->where('tahun', $currentYear)
                ->first();

            if (!$existingData) {
                $recentData = array_slice($allData, -12);

                $predPerempuan = $this->predictNextValueAdvanced($recentData, 'perempuan', $currentMonth);
                $predLakiLaki = $this->predictNextValueAdvanced($recentData, 'laki_laki', $currentMonth);
                
                // ✅ HITUNG GAJI dengan kenaikan 2% per tahun
                $predGaji = $this->calculatePredictedGaji($baseGaji, $baseTahun, $currentYear);

                $prediksi = Prediksi::create([
                    'instansi_id' => $instansiId,
                    'bulan' => $currentMonth,
                    'tahun' => $currentYear,
                    'prediksi_perempuan' => round($predPerempuan),
                    'prediksi_laki_laki' => round($predLakiLaki),
                    'prediksi_gaji' => round($predGaji, 2),
                    'confidence_score' => $this->calculateAdvancedConfidenceScore($historicalData),
                    'is_dummy' => false
                ]);

                if ($currentMonth == $periodeBulan) {
                    $savedPredictions->push($prediksi);
                    \Log::info("✓ Prediksi {$currentMonth}/{$currentYear} disimpan - Gaji: Rp" . number_format($predGaji, 2));
                } else {
                    \Log::info("○ Prediksi {$currentMonth}/{$currentYear} dibuat tapi tidak disimpan ke result");
                }

                $allData[] = [
                    'bulan' => $currentMonth,
                    'tahun' => $currentYear,
                    'perempuan' => round($predPerempuan),
                    'laki_laki' => round($predLakiLaki),
                    'gaji' => round($predGaji, 2),
                    'is_prediction' => true
                ];
            } else {
                $allData[] = [
                    'bulan' => $currentMonth,
                    'tahun' => $currentYear,
                    'perempuan' => $existingData->jumlah_perempuan,
                    'laki_laki' => $existingData->jumlah_laki_laki,
                    'gaji' => $existingData->rata_rata_gaji,
                    'is_prediction' => false
                ];
                
                \Log::info("○ Bulan {$currentMonth}/{$currentYear} skip (data sudah ada)");
            }

            $currentMonth++;
            if ($currentMonth > 12) {
                $currentMonth = 1;
                $currentYear++;
            }
        }

        \Log::info("=== TOTAL CUSTOM PREDIKSI YANG SESUAI PERIODE: " . $savedPredictions->count() . " ===");
        
        return $savedPredictions;
    }

    /**
     * ✅ Generate prediksi dan SIMPAN ke database
     */
    private function generateAndSavePrediction($instansiId, $historicalData, $targetMonth, $targetYear)
    {
        $trendPerempuan = $this->calculateOverallTrend($historicalData, 'jumlah_perempuan');
        $trendLakiLaki = $this->calculateOverallTrend($historicalData, 'jumlah_laki_laki');
        $expSmoothPerempuan = $this->exponentialSmoothing($historicalData, 'jumlah_perempuan');
        $expSmoothLakiLaki = $this->exponentialSmoothing($historicalData, 'jumlah_laki_laki');
        $seasonalPerempuan = $this->detectSeasonalPattern($historicalData, 'jumlah_perempuan', $targetMonth);
        $seasonalLakiLaki = $this->detectSeasonalPattern($historicalData, 'jumlah_laki_laki', $targetMonth);
        $wmaPerempuan = $this->weightedMovingAverage($historicalData, 'jumlah_perempuan');
        $wmaLakiLaki = $this->weightedMovingAverage($historicalData, 'jumlah_laki_laki');
        
        $prediksiPerempuan = (
            ($expSmoothPerempuan * 0.35) +
            ($trendPerempuan * 0.25) +
            ($seasonalPerempuan * 0.20) +
            ($wmaPerempuan * 0.20)
        );
        
        $prediksiLakiLaki = (
            ($expSmoothLakiLaki * 0.35) +
            ($trendLakiLaki * 0.25) +
            ($seasonalLakiLaki * 0.20) +
            ($wmaLakiLaki * 0.20)
        );

        $prediksiPerempuan = max(0, round($prediksiPerempuan));
        $prediksiLakiLaki = max(0, round($prediksiLakiLaki));

        // ✅ HITUNG GAJI dengan kenaikan 2% per tahun
        $lastData = $historicalData->last();
        $prediksiGaji = $this->calculatePredictedGaji(
            $lastData->rata_rata_gaji, 
            $lastData->tahun, 
            $targetYear
        );

        $confidenceScore = $this->calculateAdvancedConfidenceScore($historicalData);

        $prediksi = Prediksi::create([
            'instansi_id' => $instansiId,
            'bulan' => $targetMonth,
            'tahun' => $targetYear,
            'prediksi_perempuan' => $prediksiPerempuan,
            'prediksi_laki_laki' => $prediksiLakiLaki,
            'prediksi_gaji' => $prediksiGaji,
            'confidence_score' => $confidenceScore,
            'is_dummy' => false
        ]);

        \Log::info("✓ Prediksi {$targetMonth}/{$targetYear} untuk instansi {$instansiId} disimpan - Gaji: Rp" . number_format($prediksiGaji, 2));

        return $prediksi;
    }

    /**
     * ✅ FUNGSI BARU: Hitung prediksi gaji dengan kenaikan 2% per tahun
     * 
     * @param float $baseGaji - Gaji dari data terakhir
     * @param int $baseTahun - Tahun dari data terakhir
     * @param int $targetTahun - Tahun target prediksi
     * @return float - Gaji yang sudah disesuaikan dengan kenaikan tahunan
     */
    private function calculatePredictedGaji($baseGaji, $baseTahun, $targetTahun)
    {
        // ✅ Hitung selisih tahun
        $selisihTahun = $targetTahun - $baseTahun;

        // ✅ Jika tahun sama, gaji tidak naik
        if ($selisihTahun == 0) {
            return round($baseGaji, 2);
        }

        // ✅ Hitung gaji dengan formula: Gaji_Baru = Gaji_Lama × (1 + 0.02)^selisih_tahun
        // Ini memastikan kenaikan KONSISTEN 2% per tahun (compound interest)
        $predictedGaji = $baseGaji * pow(1 + self::KENAIKAN_GAJI_TAHUNAN, $selisihTahun);

        \Log::info("Gaji Calculation: Base=Rp" . number_format($baseGaji, 2) . 
                   " ({$baseTahun}) → Rp" . number_format($predictedGaji, 2) . 
                   " ({$targetTahun}) [+{$selisihTahun} tahun @ 2%/tahun]");

        return round($predictedGaji, 2);
    }

    // ✅ Helper methods tetap sama
    private function extractBulanFromNamaInstansi($namaInstansi)
    {
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $typoMap = [
            'Febuari' => 'Februari',
            'Pebruari' => 'Februari'
        ];

        foreach ($typoMap as $typo => $correct) {
            if (stripos($namaInstansi, $typo) !== false) {
                return $correct;
            }
        }

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

    private function getBulanNumber($namaBulan)
    {
        $namaBulan = $this->normalizeBulanName($namaBulan);

        $bulanMap = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3,
            'April' => 4, 'Mei' => 5, 'Juni' => 6,
            'Juli' => 7, 'Agustus' => 8, 'September' => 9,
            'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        return $bulanMap[$namaBulan] ?? 0;
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

    private function predictNextValueAdvanced($dataArray, $field, $currentMonth)
    {
        $values = array_column($dataArray, $field);
        $n = count($values);

        if ($n == 0) return 0;
        if ($n == 1) return $values[0];

        $alpha = 0.3;
        $forecast = $values[0];
        for ($i = 1; $i < $n; $i++) {
            $forecast = $alpha * $values[$i] + (1 - $alpha) * $forecast;
        }

        if ($n >= 3) {
            $recentCount = min($n, 6);
            $recent = array_slice($values, -$recentCount);
            $x = range(1, $recentCount);
            
            $sumX = array_sum($x);
            $sumY = array_sum($recent);
            $sumXY = 0;
            $sumX2 = 0;
            
            for ($i = 0; $i < $recentCount; $i++) {
                $sumXY += $x[$i] * $recent[$i];
                $sumX2 += $x[$i] * $x[$i];
            }
            
            $slope = ($recentCount * $sumXY - $sumX * $sumY) / ($recentCount * $sumX2 - $sumX * $sumX);
            $trend = $slope;
            
            $forecast += $trend * 0.4;
        }

        if ($n >= 12) {
            $seasonalData = [];
            foreach ($dataArray as $item) {
                if ($item['is_prediction'] === false) {
                    $bulan = $item['bulan'];
                    if (!isset($seasonalData[$bulan])) {
                        $seasonalData[$bulan] = [];
                    }
                    $seasonalData[$bulan][] = $item[$field];
                }
            }
            
            if (isset($seasonalData[$currentMonth]) && count($seasonalData[$currentMonth]) > 0) {
                $seasonalAvg = array_sum($seasonalData[$currentMonth]) / count($seasonalData[$currentMonth]);
                $overallAvg = array_sum($values) / $n;
                
                if ($overallAvg > 0) {
                    $seasonalFactor = $seasonalAvg / $overallAvg;
                    $forecast *= (1 + ($seasonalFactor - 1) * 0.2);
                }
            }
        }

        $wmaWindow = min($n, 6);
        $recentValues = array_slice($values, -$wmaWindow);
        $weightedSum = 0;
        $weightSum = 0;
        
        for ($i = 0; $i < $wmaWindow; $i++) {
            $weight = $i + 1;
            $weightedSum += $recentValues[$i] * $weight;
            $weightSum += $weight;
        }
        
        $wma = $weightedSum / $weightSum;
        
        $finalForecast = ($forecast * 0.4) + ($wma * 0.6);

        return max(0, $finalForecast);
    }

    private function calculateOverallTrend($data, $field)
    {
        $n = $data->count();
        if ($n < 2) return $data->first()->$field;

        $x = range(1, $n);
        $y = $data->pluck($field)->toArray();

        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += $x[$i] * $y[$i];
            $sumX2 += $x[$i] * $x[$i];
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        $prediction = $slope * ($n + 1) + $intercept;

        return max(0, $prediction);
    }

    private function exponentialSmoothing($data, $field, $alpha = 0.3)
    {
        $values = $data->pluck($field)->toArray();
        $n = count($values);
        
        if ($n == 0) return 0;
        if ($n == 1) return $values[0];

        $forecast = $values[0];
        
        for ($i = 1; $i < $n; $i++) {
            $forecast = $alpha * $values[$i] + (1 - $alpha) * $forecast;
        }
        
        return max(0, $forecast);
    }

    private function detectSeasonalPattern($data, $field, $nextMonth)
    {
        $values = $data->pluck($field)->toArray();
        $n = count($values);
        
        if ($n < 12) {
            return array_sum($values) / $n;
        }
        
        $seasonalSums = array_fill(1, 12, 0);
        $seasonalCounts = array_fill(1, 12, 0);
        
        foreach ($data as $record) {
            $bulan = $record->bulan;
            $seasonalSums[$bulan] += $record->$field;
            $seasonalCounts[$bulan]++;
        }
        
        if ($seasonalCounts[$nextMonth] > 0) {
            $seasonalAverage = $seasonalSums[$nextMonth] / $seasonalCounts[$nextMonth];
            
            $recentValues = array_slice($values, -3);
            $recentAvg = array_sum($recentValues) / count($recentValues);
            $overallAvg = array_sum($values) / $n;
            
            $adjustmentFactor = $overallAvg > 0 ? $recentAvg / $overallAvg : 1;
            
            return max(0, $seasonalAverage * $adjustmentFactor);
        }
        
        return array_sum($values) / $n;
    }

    private function weightedMovingAverage($data, $field)
    {
        $values = $data->pluck($field)->toArray();
        $n = count($values);
        
        if ($n == 0) return 0;
        if ($n == 1) return $values[0];
        
        $windowSize = min($n, 12);
        $recentValues = array_slice($values, -$windowSize);
        
        $weightedSum = 0;
        $weightSum = 0;
        
        for ($i = 0; $i < $windowSize; $i++) {
            $weight = $i + 1;
            $weightedSum += $recentValues[$i] * $weight;
            $weightSum += $weight;
        }
        
        return max(0, $weightedSum / $weightSum);
    }

    private function calculateAdvancedConfidenceScore($data)
    {
        $n = $data->count();
        
        if ($n < 2) return 40.0;
        if ($n == 2) return 45.0;
        if ($n < 6) return 50.0 + ($n - 3) * 5;
        if ($n < 12) return 65.0 + ($n - 6) * 2.5;
        if ($n < 24) return 80.0 + ($n - 12) * 1.25;
        
        $baseConfidence = 95.0;
        
        $perempuanValues = $data->pluck('jumlah_perempuan')->toArray();
        $lakiLakiValues = $data->pluck('jumlah_laki_laki')->toArray();
        
        $cvPerempuan = $this->coefficientOfVariation($perempuanValues);
        $cvLakiLaki = $this->coefficientOfVariation($lakiLakiValues);
        
        $avgCV = ($cvPerempuan + $cvLakiLaki) / 2;
        
        $consistencyBonus = 0;
        if ($avgCV < 10) $consistencyBonus = 5;
        else if ($avgCV < 20) $consistencyBonus = 2;
        else if ($avgCV > 40) $consistencyBonus = -10;
        else if ($avgCV > 30) $consistencyBonus = -5;
        
        $finalConfidence = min(99, max(40, $baseConfidence + $consistencyBonus));
        
        return round($finalConfidence, 1);
    }

    private function coefficientOfVariation($values)
    {
        $n = count($values);
        if ($n == 0) return 100;
        
        $mean = array_sum($values) / $n;
        if ($mean == 0) return 100;
        
        $variance = 0;
        foreach ($values as $value) {
            $variance += pow($value - $mean, 2);
        }
        
        $stdDev = sqrt($variance / $n);
        $cv = ($stdDev / $mean) * 100;
        
        return $cv;
    }
}