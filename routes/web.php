<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardLengkapController;  // ← TAMBAHKAN INI
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\DataAnggotaController;
use App\Http\Controllers\PeriodeController;  // ← TAMBAHKAN INI JUGA
use App\Http\Controllers\DataAnggotaLengkapController;  // ← DAN INI
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Instansi Routes (CRUD)
Route::resource('instansi', InstansiController::class);

// Data Anggota Routes (CRUD)
Route::resource('data-anggota', DataAnggotaController::class);

// Dashboard Lengkap
Route::get('/dashboard-lengkap', [DashboardLengkapController::class, 'index'])
    ->name('dashboard-lengkap.index');

// Periode Routes
Route::resource('periode', PeriodeController::class);

// Data Anggota Lengkap Routes
Route::resource('data-anggota-lengkap', DataAnggotaLengkapController::class);


Route::get('/debug-prediksi', function() {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Debug Prediksi</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
            .container { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
            h2 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
            h3 { color: #555; margin-top: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
            th { background: #4CAF50; color: white; }
            tr:hover { background: #f5f5f5; }
            .success { color: #4CAF50; font-weight: bold; }
            .error { color: #f44336; font-weight: bold; }
            .warning { color: #ff9800; font-weight: bold; }
            .info { background: #e3f2fd; padding: 15px; border-left: 4px solid #2196F3; margin: 10px 0; }
            .btn { 
                background: #4CAF50; 
                color: white; 
                padding: 10px 20px; 
                border: none; 
                border-radius: 4px; 
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                margin: 5px;
            }
            .btn:hover { background: #45a049; }
            .btn-danger { background: #f44336; }
            .btn-danger:hover { background: #da190b; }
        </style>
    </head>
    <body>
    <?php
    
    echo "<div class='container'>";
    echo "<h2>🔍 Debug Sistem Prediksi</h2>";
    echo "<p>Halaman ini membantu Anda mengidentifikasi masalah dengan sistem prediksi</p>";
    
    echo "<div style='margin: 20px 0;'>";
    echo "<a href='/debug-prediksi?action=regenerate' class='btn'>🔄 Regenerate Semua Prediksi</a>";
    echo "<a href='/debug-prediksi?action=clear' class='btn btn-danger'>🗑️ Hapus Semua Prediksi</a>";
    echo "<a href='/dashboard' class='btn' style='background: #2196F3;'>← Kembali ke Dashboard</a>";
    echo "</div>";
    echo "</div>";
    
    // Handle actions
    if (isset($_GET['action'])) {
        echo "<div class='container'>";
        if ($_GET['action'] == 'regenerate') {
            echo "<h3>🔄 Regenerating Predictions...</h3>";
            try {
                $service = app(\App\Services\PredictionService::class);
                $results = $service->predictAllInstansi();
                echo "<p class='success'>✓ Berhasil generate " . count($results) . " prediksi!</p>";
            } catch (\Exception $e) {
                echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";
            }
        } elseif ($_GET['action'] == 'clear') {
            \App\Models\Prediksi::truncate();
            echo "<p class='success'>✓ Semua prediksi berhasil dihapus!</p>";
        }
        echo "</div>";
    }
    
    // 1. Cek Instansi
    echo "<div class='container'>";
    echo "<h3>1️⃣ Daftar Instansi</h3>";
    $instansi = \App\Models\Instansi::all();
    echo "<p><strong>Total Instansi:</strong> " . $instansi->count() . "</p>";
    if ($instansi->isEmpty()) {
        echo "<p class='error'>⚠️ Tidak ada instansi!</p>";
    } else {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nama Instansi</th><th>Jumlah Data</th></tr>";
        foreach($instansi as $inst) {
            $dataCount = \App\Models\DataAnggota::where('instansi_id', $inst->id)->count();
            echo "<tr>";
            echo "<td>{$inst->id}</td>";
            echo "<td>{$inst->nama_instansi}</td>";
            echo "<td>" . ($dataCount >= 2 ? "<span class='success'>" : "<span class='warning'>") . 
                 "{$dataCount} bulan</span></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    echo "</div>";
    
    // 2. Cek Data Anggota
    echo "<div class='container'>";
    echo "<h3>2️⃣ Data Anggota Historis</h3>";
    $dataAnggota = \App\Models\DataAnggota::with('instansi')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->get();
    echo "<p><strong>Total Data:</strong> " . $dataAnggota->count() . " entries</p>";
    
    if ($dataAnggota->isEmpty()) {
        echo "<p class='error'>⚠️ Tidak ada data anggota! Silakan input data terlebih dahulu.</p>";
    } else {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        echo "<table>";
        echo "<tr><th>Instansi</th><th>Periode</th><th>Perempuan</th><th>Laki-Laki</th><th>Total</th></tr>";
        foreach($dataAnggota->take(20) as $data) {
            $bulanNama = isset($namaBulan[$data->bulan]) ? $namaBulan[$data->bulan] : $data->bulan;
            echo "<tr>";
            echo "<td>{$data->instansi->nama_instansi}</td>";
            echo "<td>{$bulanNama} {$data->tahun}</td>";
            echo "<td>{$data->jumlah_perempuan}</td>";
            echo "<td>{$data->jumlah_laki_laki}</td>";
            echo "<td>" . ($data->jumlah_perempuan + $data->jumlah_laki_laki) . "</td>";
            echo "</tr>";
        }
        if ($dataAnggota->count() > 20) {
            echo "<tr><td colspan='5' style='text-align:center;'><em>... dan " . 
                 ($dataAnggota->count() - 20) . " data lainnya</em></td></tr>";
        }
        echo "</table>";
        
        // Show data range
        $oldest = $dataAnggota->sortBy('tahun')->sortBy('bulan')->first();
        $newest = $dataAnggota->sortByDesc('tahun')->sortByDesc('bulan')->first();
        $oldestBulan = isset($namaBulan[$oldest->bulan]) ? $namaBulan[$oldest->bulan] : $oldest->bulan;
        $newestBulan = isset($namaBulan[$newest->bulan]) ? $namaBulan[$newest->bulan] : $newest->bulan;
        
        echo "<div class='info'>";
        echo "<strong>📅 Range Data:</strong><br>";
        echo "Dari: {$oldestBulan} {$oldest->tahun}<br>";
        echo "Sampai: {$newestBulan} {$newest->tahun}";
        echo "</div>";
    }
    echo "</div>";
    
    // 3. Cek Prediksi
    echo "<div class='container'>";
    echo "<h3>3️⃣ Prediksi yang Tersimpan</h3>";
    $prediksi = \App\Models\Prediksi::with('instansi')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->get();
    echo "<p><strong>Total Prediksi:</strong> " . $prediksi->count() . "</p>";
    
    if ($prediksi->isEmpty()) {
        echo "<p class='warning'>⚠️ Belum ada prediksi! Klik tombol 'Regenerate' di atas.</p>";
    } else {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        echo "<table>";
        echo "<tr><th>Instansi</th><th>Periode Prediksi</th><th>Pred. Perempuan</th><th>Pred. Laki-Laki</th><th>Total</th><th>Confidence</th></tr>";
        foreach($prediksi as $pred) {
            $bulanNama = isset($namaBulan[$pred->bulan]) ? $namaBulan[$pred->bulan] : $pred->bulan;
            echo "<tr>";
            echo "<td>{$pred->instansi->nama_instansi}</td>";
            echo "<td><strong>{$bulanNama} {$pred->tahun}</strong></td>";
            echo "<td>" . round($pred->prediksi_perempuan) . "</td>";
            echo "<td>" . round($pred->prediksi_laki_laki) . "</td>";
            echo "<td><strong>" . round($pred->prediksi_perempuan + $pred->prediksi_laki_laki) . "</strong></td>";
            echo "<td>" . number_format($pred->confidence_score, 1) . "%</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    echo "</div>";
    
    // 4. Diagnosis
    echo "<div class='container'>";
    echo "<h3>4️⃣ Diagnosis Sistem</h3>";
    
    $checks = [];
    
    // Check 1: Ada instansi?
    $instansiCount = \App\Models\Instansi::count();
    $checks[] = [
        'check' => 'Instansi terdaftar',
        'status' => $instansiCount > 0,
        'message' => $instansiCount > 0 ? "{$instansiCount} instansi ditemukan" : "Tidak ada instansi!"
    ];
    
    // Check 2: Ada data anggota?
    $dataCount = \App\Models\DataAnggota::count();
    $checks[] = [
        'check' => 'Data anggota tersedia',
        'status' => $dataCount > 0,
        'message' => $dataCount > 0 ? "{$dataCount} data ditemukan" : "Tidak ada data anggota!"
    ];
    
    // Check 3: Data cukup untuk prediksi?
    $instansiWithEnoughData = 0;
    foreach(\App\Models\Instansi::all() as $inst) {
        if (\App\Models\DataAnggota::where('instansi_id', $inst->id)->count() >= 2) {
            $instansiWithEnoughData++;
        }
    }
    $checks[] = [
        'check' => 'Data cukup untuk prediksi (min 2 bulan)',
        'status' => $instansiWithEnoughData > 0,
        'message' => "{$instansiWithEnoughData} dari {$instansiCount} instansi memiliki data cukup"
    ];
    
    // Check 4: Ada prediksi?
    $prediksiCount = \App\Models\Prediksi::count();
    $checks[] = [
        'check' => 'Prediksi tersedia',
        'status' => $prediksiCount > 0,
        'message' => $prediksiCount > 0 ? "{$prediksiCount} prediksi ditemukan" : "Belum ada prediksi!"
    ];
    
    echo "<table>";
    echo "<tr><th width='40%'>Pemeriksaan</th><th width='15%'>Status</th><th>Keterangan</th></tr>";
    foreach ($checks as $check) {
        $statusClass = $check['status'] ? 'success' : 'error';
        $statusText = $check['status'] ? '✓ OK' : '✗ Error';
        echo "<tr>";
        echo "<td>{$check['check']}</td>";
        echo "<td class='{$statusClass}'>{$statusText}</td>";
        echo "<td>{$check['message']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    
    ?>
    </body>
    </html>
    <?php
});