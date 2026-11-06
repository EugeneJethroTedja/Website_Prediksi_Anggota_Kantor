<?php

namespace App\Services;

use App\Models\DataAnggotaLengkap;
use App\Models\PrediksiLengkap;
use App\Models\Periode;

class PredictionLengkapService
{
    /**
     * Predict all categories for a periode with selected method
     */
    public function predictPeriode($periodeId, $targetBulan, $targetTahun, $method = 'combined')
    {
        // Get historical data
        $historicalData = DataAnggotaLengkap::where('periode_id', $periodeId)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        if ($historicalData->count() < 2) {
            \Log::warning("Data tidak cukup untuk prediksi periode {$periodeId}");
            return null;
        }

        // Delete old prediction for this period
        PrediksiLengkap::where('periode_id', $periodeId)
            ->where('bulan', $targetBulan)
            ->where('tahun', $targetTahun)
            ->delete();

        $predictionData = [
            'periode_id' => $periodeId,
            'bulan' => $targetBulan,
            'tahun' => $targetTahun,
            'prediction_method' => $method,
        ];

        // Predict PENDIDIKAN
        foreach (['sd', 'sltp', 'slta', 'di', 'dii', 'diii', 'div', 's1', 's2', 's3'] as $pend) {
            $predictionData["pred_pend_{$pend}_laki"] = $this->predictField(
                $historicalData, "pend_{$pend}_laki", $method
            );
            $predictionData["pred_pend_{$pend}_perempuan"] = $this->predictField(
                $historicalData, "pend_{$pend}_perempuan", $method
            );
        }

        // Predict GOLONGAN (UPDATED: lengkap dengan I-XII)
        $golonganFields = [
            'ia', 'ib', 'ic', 'id', 
            'iia', 'iib', 'iic', 'iid', 
            'iiia', 'iiib', 'iiic', 'iiid', 
            'iva', 'ivb', 'ivc', 'ivd', 'ive',
            'i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii'
        ];
        
        foreach ($golonganFields as $gol) {
            $predictionData["pred_gol_{$gol}_laki"] = $this->predictField(
                $historicalData, "gol_{$gol}_laki", $method
            );
            $predictionData["pred_gol_{$gol}_perempuan"] = $this->predictField(
                $historicalData, "gol_{$gol}_perempuan", $method
            );
        }

        // Predict JABATAN
        foreach (['2a', '2b', '3a', '3b', '4a', '4b', '5a'] as $jab) {
            $predictionData["pred_jab_{$jab}_laki"] = $this->predictField(
                $historicalData, "jab_{$jab}_laki", $method
            );
            $predictionData["pred_jab_{$jab}_perempuan"] = $this->predictField(
                $historicalData, "jab_{$jab}_perempuan", $method
            );
        }

        // Predict AGAMA
        foreach (['islam', 'kristen', 'katholik', 'hindu', 'budha'] as $agama) {
            $predictionData["pred_agama_{$agama}_laki"] = $this->predictField(
                $historicalData, "agama_{$agama}_laki", $method
            );
            $predictionData["pred_agama_{$agama}_perempuan"] = $this->predictField(
                $historicalData, "agama_{$agama}_perempuan", $method
            );
        }

        // Predict JF TERTENTU PNS
        foreach (['i', 'ii', 'iii', 'iv'] as $jf) {
            $predictionData["pred_jf_tertentu_pns_{$jf}"] = $this->predictField(
                $historicalData, "jf_tertentu_pns_{$jf}", $method
            );
        }

        // Predict JF TERTENTU PPPK
        foreach (['v', 'vii', 'ix', 'x', 'xi'] as $jf) {
            $predictionData["pred_jf_tertentu_pppk_{$jf}"] = $this->predictField(
                $historicalData, "jf_tertentu_pppk_{$jf}", $method
            );
        }

        // Predict JF PELAKSANA PNS
        foreach (['i', 'ii', 'iii', 'iv'] as $jf) {
            $predictionData["pred_jf_pelaksana_pns_{$jf}"] = $this->predictField(
                $historicalData, "jf_pelaksana_pns_{$jf}", $method
            );
        }

        // Predict JF PELAKSANA PPPK
        foreach (['i', 'iii', 'v', 'vii', 'ix', 'x'] as $jf) {
            $predictionData["pred_jf_pelaksana_pppk_{$jf}"] = $this->predictField(
                $historicalData, "jf_pelaksana_pppk_{$jf}", $method
            );
        }

        // Calculate confidence score
        $predictionData['confidence_score'] = $this->calculateConfidenceScore($historicalData, $method);

        return PrediksiLengkap::create($predictionData);
    }

    /**
     * Predict single field using selected method
     */
    private function predictField($data, $fieldName, $method = 'combined')
    {
        $values = $data->pluck($fieldName)->toArray();
        $n = count($values);

        if ($n == 0) return 0;
        if ($n == 1) return max(0, $values[0]);

        switch ($method) {
            case 'exponential_smoothing':
                $prediction = $this->exponentialSmoothing($values);
                break;
            
            case 'linear_trend':
                $prediction = $this->linearTrend($values);
                break;
            
            case 'weighted_moving_average':
                $prediction = $this->weightedMovingAverage($values);
                break;
            
            case 'arima':
                $prediction = $this->arimaSimple($values);
                break;
            
            case 'combined':
            default:
                // Combined prediction methods
                $expSmooth = $this->exponentialSmoothing($values);
                $trend = $this->linearTrend($values);
                $wma = $this->weightedMovingAverage($values);
                
                // Weighted combination
                $prediction = ($expSmooth * 0.4) + ($trend * 0.35) + ($wma * 0.25);
                break;
        }

        return max(0, round($prediction, 2));
    }

    /**
     * Exponential Smoothing
     */
    private function exponentialSmoothing($values, $alpha = 0.3)
    {
        $n = count($values);
        if ($n == 0) return 0;
        if ($n == 1) return $values[0];

        $forecast = $values[0];
        for ($i = 1; $i < $n; $i++) {
            $forecast = $alpha * $values[$i] + (1 - $alpha) * $forecast;
        }

        return $forecast;
    }

    /**
     * Linear Trend Analysis
     */
    private function linearTrend($values)
    {
        $n = count($values);
        if ($n < 2) return $values[0] ?? 0;

        $x = range(1, $n);
        $sumX = array_sum($x);
        $sumY = array_sum($values);
        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += $x[$i] * $values[$i];
            $sumX2 += $x[$i] * $x[$i];
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        return $slope * ($n + 1) + $intercept;
    }

    /**
     * Weighted Moving Average
     */
    private function weightedMovingAverage($values)
    {
        $n = count($values);
        if ($n == 0) return 0;
        if ($n == 1) return $values[0];

        $windowSize = min($n, 6);
        $recentValues = array_slice($values, -$windowSize);

        $weightedSum = 0;
        $weightSum = 0;

        for ($i = 0; $i < $windowSize; $i++) {
            $weight = $i + 1;
            $weightedSum += $recentValues[$i] * $weight;
            $weightSum += $weight;
        }

        return $weightedSum / $weightSum;
    }

    /**
     * Simple ARIMA (Simplified version)
     * This is a basic implementation focusing on AR(1) component
     */
    private function arimaSimple($values)
    {
        $n = count($values);
        if ($n < 3) return $this->linearTrend($values);

        // Calculate first differences
        $diff = [];
        for ($i = 1; $i < $n; $i++) {
            $diff[] = $values[$i] - $values[$i - 1];
        }

        // Calculate mean of differences
        $meanDiff = array_sum($diff) / count($diff);

        // Simple AR(1) coefficient estimation
        $numerator = 0;
        $denominator = 0;
        
        for ($i = 1; $i < count($diff); $i++) {
            $numerator += ($diff[$i] - $meanDiff) * ($diff[$i-1] - $meanDiff);
            $denominator += pow($diff[$i-1] - $meanDiff, 2);
        }

        $ar1 = $denominator != 0 ? $numerator / $denominator : 0;
        
        // Limit AR coefficient to reasonable range
        $ar1 = max(-0.9, min(0.9, $ar1));

        // Forecast next value
        $lastDiff = end($diff);
        $predictedDiff = $ar1 * ($lastDiff - $meanDiff) + $meanDiff;
        
        return end($values) + $predictedDiff;
    }

    /**
     * Calculate confidence score based on data and method
     */
    private function calculateConfidenceScore($data, $method)
    {
        $n = $data->count();

        // Base confidence from data points
        if ($n < 2) return 40.0;
        if ($n == 2) return 45.0;
        if ($n < 6) return 50.0 + ($n - 3) * 5;
        if ($n < 12) return 65.0 + ($n - 6) * 2.5;
        if ($n < 24) return 80.0 + ($n - 12) * 1.25;

        $baseConfidence = 95.0;

        // Adjust based on method
        $methodBonus = [
            'combined' => 5.0,
            'arima' => 3.0,
            'exponential_smoothing' => 2.0,
            'linear_trend' => 1.0,
            'weighted_moving_average' => 1.5
        ];

        $confidence = $baseConfidence + ($methodBonus[$method] ?? 0);

        return min(99.0, $confidence);
    }

    /**
     * Predict for date range with selected method
     */
    public function predictDateRange($bulanMulai, $tahunMulai, $bulanSelesai, $tahunSelesai, $method = 'combined')
    {
        $results = [];
        $currentBulan = $bulanMulai;
        $currentTahun = $tahunMulai;

        // Get all active periods
        $periods = Periode::where('is_active', true)->get();

        while (true) {
            foreach ($periods as $periode) {
                $prediction = $this->predictPeriode($periode->id, $currentBulan, $currentTahun, $method);
                if ($prediction) {
                    $results[] = $prediction;
                }
            }

            if ($currentBulan == $bulanSelesai && $currentTahun == $tahunSelesai) {
                break;
            }

            $currentBulan++;
            if ($currentBulan > 12) {
                $currentBulan = 1;
                $currentTahun++;
            }

            // Safety check
            if ($currentTahun > $tahunSelesai + 1) {
                break;
            }
        }

        \Log::info("Total prediksi lengkap yang dibuat: " . count($results) . " menggunakan metode: {$method}");

        return $results;
    }

    /**
     * Get available prediction methods
     */
    public function getAvailableMethods()
    {
        return [
            'combined' => [
                'name' => 'Combined Methods (Hybrid)',
                'description' => 'Kombinasi dari Exponential Smoothing, Linear Trend, dan Weighted Moving Average',
                'accuracy' => 'Tinggi',
                'best_for' => 'Data dengan pola kompleks dan variasi tinggi'
            ],
            'exponential_smoothing' => [
                'name' => 'Exponential Smoothing',
                'description' => 'Memberikan bobot lebih pada data terbaru',
                'accuracy' => 'Sedang-Tinggi',
                'best_for' => 'Data dengan trend yang stabil'
            ],
            'linear_trend' => [
                'name' => 'Linear Trend Analysis',
                'description' => 'Analisis trend linear menggunakan regresi',
                'accuracy' => 'Sedang',
                'best_for' => 'Data dengan pertumbuhan/penurunan yang konsisten'
            ],
            'weighted_moving_average' => [
                'name' => 'Weighted Moving Average',
                'description' => 'Rata-rata bergerak dengan pembobotan',
                'accuracy' => 'Sedang',
                'best_for' => 'Data dengan fluktuasi periodik'
            ],
            'arima' => [
                'name' => 'ARIMA (Simplified)',
                'description' => 'Auto-Regressive Integrated Moving Average (versi sederhana)',
                'accuracy' => 'Tinggi',
                'best_for' => 'Data time series dengan pola musiman'
            ]
        ];
    }
}