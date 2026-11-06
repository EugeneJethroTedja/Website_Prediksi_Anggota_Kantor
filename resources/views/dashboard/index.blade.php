@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Analisa Prediksi')

@push('styles')
<style>
    /* Dashboard Luxury Styles */
    .dashboard-luxury {
        background: var(--color-bg-primary);
        min-height: 100vh;
    }

    /* Filter Card Luxury */
    .filter-card-luxury {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
        overflow: hidden;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .filter-card-luxury .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.3);
        color: var(--color-text-primary);
        padding: 1.5rem 2rem;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .filter-card-luxury .card-body {
        padding: 2rem;
    }

    .filter-card-luxury .form-label {
        font-weight: 600;
        color: var(--color-text-primary);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .filter-card-luxury .form-control,
    .filter-card-luxury .form-select {
        background: rgba(35, 41, 70, 0.6);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 10px;
        padding: 0.875rem 1.25rem;
        color: var(--color-text-primary);
        font-size: 0.95rem;
        transition: var(--transition-base);
    }

    .filter-card-luxury .form-control:focus,
    .filter-card-luxury .form-select:focus {
        border-color: rgba(102, 126, 234, 0.8);
        background: rgba(35, 41, 70, 0.8);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
    }

    /* Custom Prediction Section */
    .custom-prediction-section {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.1) 100%);
        border: 2px dashed rgba(56, 239, 125, 0.4);
        border-radius: 16px;
        padding: 2rem;
        margin-top: 1.5rem;
    }

    .custom-prediction-title {
        font-weight: 700;
        color: #38ef7d;
        font-size: 1.15rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .custom-prediction-title i {
        font-size: 1.3rem;
    }

    /* Stats Grid Luxury */
    .stats-grid-luxury {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1400px) {
        .stats-grid-luxury {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .stats-grid-luxury {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid-luxury {
            grid-template-columns: 1fr;
        }
    }

    /* Stat Card Luxury */
    .stat-card-luxury {
        border-radius: 16px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: var(--transition-base);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid;
    }

    .stat-card-luxury::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .stat-card-luxury:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
    }

    .stat-card-luxury.gradient-primary {
        background: var(--gradient-card-1);
        border-color: rgba(102, 126, 234, 0.5);
    }

    .stat-card-luxury.gradient-success {
        background: var(--gradient-card-2);
        border-color: rgba(17, 153, 142, 0.5);
    }

    .stat-card-luxury.gradient-danger {
        background: var(--gradient-card-3);
        border-color: rgba(238, 9, 121, 0.5);
    }

    .stat-card-luxury.gradient-warning {
        background: var(--gradient-card-4);
        border-color: rgba(240, 147, 251, 0.5);
    }

    .stat-card-luxury.gradient-info {
        background: var(--gradient-card-5);
        border-color: rgba(79, 172, 254, 0.5);
    }

    .stat-icon-luxury {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: white;
        margin-bottom: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .stat-label-luxury {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .stat-value-luxury {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        color: white;
        margin-bottom: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
        position: relative;
        z-index: 1;
    }

    .stat-detail-luxury {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.75);
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    /* Table Luxury */
    .table-card-luxury {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(35, 41, 70, 0.9) 100%);
        border: 1px solid var(--color-border);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .table-card-luxury .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.3);
        padding: 1.5rem 2rem;
        font-weight: 700;
        color: var(--color-text-primary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-card-luxury .card-body {
        padding: 0;
    }

    /* Avatar Box */
    .avatar-box-luxury {
        width: 48px;
        height: 48px;
        background: var(--gradient-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    /* Badge Luxury - FIXED: Warna text kontras dengan background */
    .badge-period-luxury {
        background: rgba(26, 26, 46, 0.8);
        border: 1px solid rgba(79, 172, 254, 0.4);
        padding: 0.6rem 1.1rem;
        border-radius: 10px;
        font-weight: 600;
        color: #00f2fe;
        white-space: nowrap;
        display: inline-block;
        font-size: 0.85rem;
    }

    .badge-gender-female-luxury {
        background: rgba(26, 26, 46, 0.8);
        border: 1px solid rgba(238, 9, 121, 0.5);
        padding: 0.6rem 1.1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        color: #ff6a00;
        display: inline-block;
    }

    .badge-gender-male-luxury {
        background: rgba(26, 26, 46, 0.8);
        border: 1px solid rgba(79, 172, 254, 0.5);
        padding: 0.6rem 1.1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        color: #00f2fe;
        display: inline-block;
    }

    .badge-belanja-luxury {
        background: rgba(26, 26, 46, 0.8);
        border: 1px solid rgba(17, 153, 142, 0.5);
        padding: 0.6rem 1.1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        color: #38ef7d;
        display: inline-block;
    }

    .table-luxury thead th {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.3);
        color: var(--color-text-primary);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1.2px;
        padding: 1.25rem 1rem;
    }

    .table-luxury tbody tr {
        border-bottom: 1px solid var(--color-border);
        transition: var(--transition-fast);
    }

    .table-luxury tbody tr:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .table-luxury tbody td {
        padding: 1.5rem 1rem;
        vertical-align: middle;
        border: none;
        color: var(--color-text-secondary);
    }

    .table-luxury tfoot tr {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        border-top: 2px solid rgba(102, 126, 234, 0.4);
    }

    .table-luxury tfoot th {
        padding: 1.75rem 1rem;
        border: none;
        font-size: 1rem;
        color: var(--color-text-primary);
    }

    /* Progress Bar Luxury */
    .progress-luxury {
        height: 8px;
        border-radius: 4px;
        background: rgba(35, 41, 70, 0.5);
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .progress-bar-luxury {
        height: 100%;
        background: linear-gradient(90deg, #ee0979 0%, #ff6a00 100%);
        transition: width 0.6s ease;
        box-shadow: 0 0 10px rgba(238, 9, 121, 0.5);
    }

    /* Charts Container */
    .charts-scroll-wrapper-luxury {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(35, 41, 70, 0.9) 100%);
        border: 1px solid var(--color-border);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        padding: 2rem;
        margin-top: 2rem;
        backdrop-filter: blur(10px);
    }

    .charts-scroll-header-luxury {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(102, 126, 234, 0.3);
    }

    .charts-scroll-title-luxury {
        font-size: 1.4rem;
        font-weight: 700;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        font-family: 'Space Grotesk', sans-serif;
    }

    .charts-scroll-subtitle-luxury {
        font-size: 0.85rem;
        color: var(--color-text-tertiary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .charts-scroll-container-luxury {
        display: flex;
        overflow-x: auto;
        gap: 2rem;
        padding: 1rem 0;
        scroll-behavior: smooth;
    }

    .charts-scroll-container-luxury::-webkit-scrollbar {
        height: 10px;
    }

    .charts-scroll-container-luxury::-webkit-scrollbar-track {
        background: rgba(35, 41, 70, 0.5);
        border-radius: 5px;
    }

    .charts-scroll-container-luxury::-webkit-scrollbar-thumb {
        background: var(--gradient-primary);
        border-radius: 5px;
    }

    /* Chart Item */
    .chart-item-luxury {
        min-width: 600px;
        max-width: 600px;
        flex-shrink: 0;
    }

    .chart-container-luxury {
        background: linear-gradient(135deg, rgba(35, 41, 70, 0.6) 0%, rgba(26, 26, 46, 0.6) 100%);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        transition: var(--transition-base);
        height: 100%;
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(5px);
    }

    .chart-container-luxury:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.3);
        border-color: rgba(102, 126, 234, 0.6);
    }

    .chart-header-luxury {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .chart-title-luxury {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0;
        flex: 1;
        min-width: 200px;
        font-family: 'Space Grotesk', sans-serif;
    }

    .chart-badge-luxury {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        white-space: nowrap;
        flex-shrink: 0;
        border: 1px solid;
    }

    .chart-badge-luxury.active {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.2) 0%, rgba(56, 239, 125, 0.2) 100%);
        border-color: rgba(17, 153, 142, 0.5);
        color: #38ef7d;
    }

    .chart-badge-luxury.waiting {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.2) 0%, rgba(245, 87, 108, 0.2) 100%);
        border-color: rgba(240, 147, 251, 0.5);
        color: #f5576c;
    }

    /* Chart Canvas */
    .chart-canvas-container-luxury {
        height: 340px;
        position: relative;
    }

    /* Chart Stats Box */
    .chart-stats-box-luxury {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .chart-stats-item-luxury {
        text-align: center;
    }

    .chart-stats-label-luxury {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--color-text-tertiary);
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .chart-stats-value-luxury {
        font-size: 1.85rem;
        font-weight: 800;
        line-height: 1;
        font-family: 'Space Grotesk', sans-serif;
    }

    .chart-stats-value-luxury.female {
        background: var(--gradient-danger);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .chart-stats-value-luxury.male {
        background: var(--gradient-info);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* No Data State */
    .no-data-state-luxury {
        text-align: center;
        padding: 4rem 2rem;
    }

    .no-data-icon-luxury {
        font-size: 5rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .no-data-title-luxury {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.75rem;
    }

    .no-data-text-luxury {
        color: var(--color-text-tertiary);
        font-size: 0.95rem;
    }

    /* Alert Luxury */
    .alert-luxury {
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid;
        backdrop-filter: blur(10px);
    }

    .alert-luxury.info {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.1) 100%);
        border-color: rgba(79, 172, 254, 0.4);
    }

    .alert-luxury.warning {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%);
        border-color: rgba(240, 147, 251, 0.4);
    }

    .alert-luxury.success {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.1) 100%);
        border-color: rgba(17, 153, 142, 0.4);
    }

    .alert-icon-box-luxury {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
    }

    .alert-luxury.info .alert-icon-box-luxury {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.3) 0%, rgba(0, 242, 254, 0.3) 100%);
        color: #00f2fe;
    }

    .alert-luxury.warning .alert-icon-box-luxury {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.3) 0%, rgba(245, 87, 108, 0.3) 100%);
        color: #f5576c;
    }

    .alert-luxury.success .alert-icon-box-luxury {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.3) 0%, rgba(56, 239, 125, 0.3) 100%);
        color: #38ef7d;
    }

    /* Button Reset */
    .btn-reset-luxury {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.1) 0%, rgba(136, 146, 176, 0.1) 100%);
        border: 1px solid var(--color-border);
        color: var(--color-text-secondary);
        transition: var(--transition-base);
        cursor: pointer;
    }

    .btn-reset-luxury:hover {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.2) 0%, rgba(136, 146, 176, 0.2) 100%);
        border-color: var(--color-border-light);
        color: var(--color-text-primary);
        transform: rotate(180deg) scale(1.1);
    }

    /* Button Predict */
    .btn-predict-luxury {
        height: 48px;
        background: var(--gradient-success);
        color: white;
        border: none;
        font-weight: 700;
        border-radius: 12px;
        transition: var(--transition-base);
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.4);
    }

    .btn-predict-luxury:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(17, 153, 142, 0.6);
    }
</style>
@endpush

@section('content')
<div class="dashboard-luxury">
    <div class="container-fluid">
        
        {{-- Filter Card Luxury --}}
        <div class="card filter-card-luxury fade-in-up">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-sliders-h me-2"></i>
                        <strong>Fitur Prediksi Data Anggota</strong>
                    </div>
                    <a href="{{ route('dashboard.index') }}" class="btn-reset-luxury">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <form action="{{ route('dashboard.index') }}" method="GET">
                    {{-- Custom Prediction Section --}}
                    <div class="custom-prediction-section">
                        <div class="custom-prediction-title">
                            <i class="fas fa-crystal-ball"></i>
                            Prediksi Target (Pilih Target Prediksi)
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Target Bulan
                                </label>
                                <select name="custom_bulan" class="form-control" id="customBulan">
                                    <option value="">-- Pilih Bulan --</option>
                                    @foreach($bulanList as $key => $value)
                                        <option value="{{ $key }}" {{ request('custom_bulan') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Target Tahun
                                </label>
                                <input type="number" name="custom_tahun" class="form-control" 
                                       placeholder="2027" min="2026" max="2100" 
                                       value="{{ request('custom_tahun') }}" id="customTahun">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-predict-luxury w-100">
                                    <i class="fas fa-chart-line me-2"></i>Hasilkan Prediksi
                                </button>
                            </div>
                        </div>
                        <div class="mt-3" style="font-size: 0.85rem; color: var(--color-text-tertiary);">
                            <i class="fas fa-info-circle me-1"></i>
                            Sistem akan menghasilkan prediksi berdasarkan data terbaru untuk periode yang dipilih (hanya hasil prediksi).
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Alert --}}
        @if(isset($useCustomPrediction) && $useCustomPrediction)
        <div class="alert-luxury success fade-in-up" style="animation-delay: 0.1s">
            <div class="d-flex align-items-center gap-3">
                <div class="alert-icon-box-luxury">
                    <i class="fas fa-magic"></i>
                </div>
                <div class="flex-grow-1">
                    <strong style="color: #38ef7d;">Mode Kustom Prediksi:</strong>
                    <span style="color: var(--color-text-secondary); margin-left: 0.5rem;">
                        @if(isset($infoBulanPrediksi['is_range']) && $infoBulanPrediksi['is_range'])
                            Showing predictions for <strong style="color: var(--color-text-primary);">{{ $infoBulanPrediksi['range_text'] }}</strong>
                        @else
                            Showing predictions for <strong style="color: var(--color-text-primary);">{{ $infoBulanPrediksi['bulan'] }} {{ $infoBulanPrediksi['tahun'] }}</strong>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        @elseif($prediksiTerbaru->isNotEmpty())
        <div class="alert-luxury info fade-in-up" style="animation-delay: 0.1s">
            <div class="d-flex align-items-center gap-3">
                <div class="alert-icon-box-luxury">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="flex-grow-1">
                    <strong style="color: #00f2fe;">Prediksi Tersedia:</strong>
                    <span style="color: var(--color-text-secondary); margin-left: 0.5rem;">
                        Sistem menampilkan hasil prediksi untuk 
                        <strong style="color: var(--color-text-primary);">
                            {{ $infoBulanPrediksi['bulan'] }} {{ $infoBulanPrediksi['tahun'] }}
                        </strong>
                    </span>
                </div>
            </div>
        </div>
        @else
        <div class="alert-luxury warning fade-in-up" style="animation-delay: 0.1s">
            <div class="d-flex align-items-center gap-3">
                <div class="alert-icon-box-luxury">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <strong style="color: #f5576c;">Tidak ada hasil prediksi:</strong>
                    <span style="color: var(--color-text-secondary); margin-left: 0.5rem;">
                        Silakan masukkan minimal 2 bulan data historis untuk setiap instansi agar prediksi dapat dilakukan.
                    </span>
                </div>
            </div>
        </div>
        @endif

        {{-- Stats Cards --}}
        <div class="stats-grid-luxury fade-in-up" style="animation-delay: 0.2s">
            <div class="stat-card-luxury gradient-primary">
                <div class="stat-icon-luxury">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-label-luxury">Total Periode</div>
                <div class="stat-value-luxury">{{ $instansiList->count() }}</div>
                <div class="stat-detail-luxury">
                    @if(request('instansi_id') || request('search'))
                        Hasil Tersaring
                    @else
                        Daftar Instansi Terdaftar
                    @endif
                </div>
            </div>
            
            <div class="stat-card-luxury gradient-danger">
                <div class="stat-icon-luxury">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label-luxury">Total Prediksi Anggota</div>
                <div class="stat-value-luxury">{{ number_format($totalPrediksiSemua) }}</div>
                <div class="stat-detail-luxury">
                    @if(isset($infoBulanPrediksi['is_range']) && $infoBulanPrediksi['is_range'])
                        {{ $infoBulanPrediksi['range_text'] }}
                    @else
                        {{ $infoBulanPrediksi['bulan'] }} {{ $infoBulanPrediksi['tahun'] }}
                    @endif
                </div>
            </div>
            
            <div class="stat-card-luxury gradient-warning">
                <div class="stat-icon-luxury">
                    <i class="fas fa-female"></i>
                </div>
                <div class="stat-label-luxury">Prediksi Anggota Perempuan</div>
                <div class="stat-value-luxury">{{ number_format($totalPrediksiPerempuan) }}</div>
                <div class="stat-detail-luxury">
                    {{ $totalPrediksiSemua > 0 ? number_format(($totalPrediksiPerempuan/$totalPrediksiSemua)*100, 1) : 0 }}% of total
                </div>
            </div>
            
            <div class="stat-card-luxury gradient-info">
                <div class="stat-icon-luxury">
                    <i class="fas fa-male"></i>
                </div>
                <div class="stat-label-luxury">Prediksi Anggota Laki-laki</div>
                <div class="stat-value-luxury">{{ number_format($totalPrediksiLakiLaki) }}</div>
                <div class="stat-detail-luxury">
                    {{ $totalPrediksiSemua > 0 ? number_format(($totalPrediksiLakiLaki/$totalPrediksiSemua)*100, 1) : 0 }}% of total
                </div>
            </div>

            <div class="stat-card-luxury gradient-success">
                <div class="stat-icon-luxury">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-label-luxury">Total Gaji Bulanan</div>
                <div class="stat-value-luxury" style="font-size: 1.2rem;">
                    Rp {{ number_format($totalBelanja ?? 0, 0, ',', '.') }}
                </div>
                <div class="stat-detail-luxury">Perkiraan Anggaran Bulanan</div>
            </div>
        </div>

        {{-- Table Luxury --}}
        <div class="table-card-luxury fade-in-up" style="animation-delay: 0.3s">
            <div class="card-header">
                <div>
                    <i class="fas fa-table me-2"></i>
                    <strong>Prediksi Anggota
                        @if(isset($infoBulanPrediksi['is_range']) && $infoBulanPrediksi['is_range'])
                            {{ $infoBulanPrediksi['range_text'] }}
                        @else
                            {{ $infoBulanPrediksi['bulan'] }} {{ $infoBulanPrediksi['tahun'] }}
                        @endif
                    </strong>
                </div>
                <span class="badge bg-primary">
                    {{ $prediksiTerbaru->count() }} Records
                </span>
            </div>
            <div class="card-body">
                @if($prediksiTerbaru->isEmpty())
                    <div class="no-data-state-luxury">
                        <div class="no-data-icon-luxury">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5 class="no-data-title-luxury">Tidak Ada Data Prediksi</h5>
                        <p class="no-data-text-luxury">Pastikan data historis cukup untuk menghasilkan prediksi</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-luxury">
                            <thead>
                                <tr>
                                    <th width="28%">Periode</th>
                                    <th width="14%" class="text-center">Periode / Tahun</th>
                                    <th width="12%" class="text-center">Perempuan</th>
                                    <th width="12%" class="text-center">Laki-laki</th>
                                    <th width="10%" class="text-center">Total</th>
                                    <th width="14%" class="text-center">Prediksi Pengeluaran</th>
                                    <th width="10%" class="text-center">Komposisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prediksiTerbaru as $prediksi)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-box-luxury">
                                                {{ substr($prediksi->instansi->nama_instansi ?? 'N/A', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold" style="font-size: 0.95rem; color: rgb(63, 58, 76);">
                                                    {{ $prediksi->instansi->nama_instansi ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-period-luxury">
                                            @php
                                                $bulanNama = is_object($prediksi) ? 
                                                    (method_exists($prediksi, 'getNamaBulanAttribute') ? $prediksi->nama_bulan : 
                                                    (isset($bulanList[$prediksi->bulan]) ? $bulanList[$prediksi->bulan] : $prediksi->bulan)) : 
                                                    $prediksi->bulan;
                                            @endphp
                                            {{ $bulanNama }} / {{ $prediksi->tahun }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-gender-female-luxury">
                                            <i class="fas fa-female me-1"></i>{{ number_format(round($prediksi->prediksi_perempuan ?? 0)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-gender-male-luxury">
                                            <i class="fas fa-male me-1"></i>{{ number_format(round($prediksi->prediksi_laki_laki ?? 0)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-bold" style="font-size: 1.6rem; color: rgb(63, 58, 76);">
                                            {{ number_format(round($prediksi->total_prediksi ?? 0)) }}
                                        </div>
                                        <small style="color: rgb(63, 58, 76); font-size: 0.75rem;">Anggota</small>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $gaji = $prediksi->prediksi_gaji ?? 0;
                                            $total = $prediksi->total_prediksi ?? 0;
                                            $belanja = $total * $gaji;
                                        @endphp
                                        <span class="badge-belanja-luxury">
                                            <i class="fas fa-money-bill-wave me-1"></i>Rp {{ number_format($belanja, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $totalPred = $prediksi->total_prediksi ?? 1;
                                            $persenPerempuan = $totalPred > 0 ? 
                                                (($prediksi->prediksi_perempuan ?? 0) / $totalPred * 100) : 0;
                                            $persenLakiLaki = $totalPred > 0 ? 
                                                (($prediksi->prediksi_laki_laki ?? 0) / $totalPred * 100) : 0;
                                        @endphp
                                        <div class="progress-luxury">
                                            <div class="progress-bar-luxury" style="width: {{ $persenPerempuan }}%;"></div>
                                        </div>
                                        <small style="color: var(--color-text-tertiary); font-weight: 600; font-size: 0.75rem;">
                                            <i class="fas fa-female" style="color: #ff6a00;"></i> {{ number_format($persenPerempuan, 1) }}% | 
                                            <i class="fas fa-male" style="color: #00f2fe;"></i> {{ number_format($persenLakiLaki, 1) }}%
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end" style="font-size: 1.05rem; color: rgb(63, 58, 76);">TOTAL KESELURUHAN</th>
                                    <th class="text-center">
                                        <span class="badge-gender-female-luxury">
                                            {{ number_format($totalPrediksiPerempuan) }}
                                        </span>
                                    </th>
                                    <th class="text-center">
                                        <span class="badge-gender-male-luxury">
                                            {{ number_format($totalPrediksiLakiLaki) }}
                                        </span>
                                    </th>
                                    <th class="text-center">
                                        <div class="fw-bold" style="font-size: 1.85rem; color: rgb(63, 58, 76);">
                                            {{ number_format($totalPrediksiSemua) }}
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <span class="badge-belanja-luxury">
                                            Rp {{ number_format($totalBelanja ?? 0, 0, ',', '.') }}
                                        </span>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Charts Horizontal Scroll --}}
        @if(!empty($chartData))
        <div class="charts-scroll-wrapper-luxury fade-in-up" style="animation-delay: 0.4s">
            <div class="charts-scroll-header-luxury">
                <h3 class="charts-scroll-title-luxury">
                    <i class="fas fa-chart-area me-2"></i>
                    Analisis Tren & Prediksi Berdasarkan Instansi
                </h3>
                <small class="charts-scroll-subtitle-luxury">
                    <i class="fas fa-arrows-alt-h me-1"></i>Gulir untuk melihat semua grafik
                </small>
            </div>
            
            <div class="charts-scroll-container-luxury">
                @foreach($chartData as $instansiId => $data)
                <div class="chart-item-luxury">
                    <div class="chart-container-luxury">
                        <div class="chart-header-luxury">
                            <h3 class="chart-title-luxury">
                                <i class="fas fa-building me-2"></i>
                                {{ $data['nama_instansi'] }}
                            </h3>
                            @if($data['has_prediction'])
                                <span class="chart-badge-luxury active">
                                    <i class="fas fa-check-circle me-1"></i> Active
                                </span>
                            @else
                                <span class="chart-badge-luxury waiting">
                                    <i class="fas fa-clock me-1"></i> Waiting
                                </span>
                            @endif
                        </div>
                        
                        <div class="chart-canvas-container-luxury">
                            <canvas id="chart-{{ $instansiId }}"></canvas>
                        </div>
                        
                        @if($data['has_prediction'])
                        <div class="chart-stats-box-luxury">
                            <div class="row">
                                <div class="col-6">
                                    <div class="chart-stats-item-luxury">
                                        <div class="chart-stats-label-luxury">
                                            <i class="fas fa-female me-1"></i>Prediksi Anggota Perempuan
                                        </div>
                                        <div class="chart-stats-value-luxury female">
                                            {{ number_format(end($data['perempuan'])) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="chart-stats-item-luxury">
                                        <div class="chart-stats-label-luxury">
                                            <i class="fas fa-male me-1"></i>Prediksi Anggota Laki-laki
                                        </div>
                                        <div class="chart-stats-value-luxury male">
                                            {{ number_format(end($data['laki_laki'])) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData ?? []);
    
    // Chart defaults
    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    Chart.defaults.color = '#b8c1ec';
    
    Object.keys(chartData).forEach(instansiId => {
        const data = chartData[instansiId];
        const ctx = document.getElementById('chart-' + instansiId);
        
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Female',
                            data: data.perempuan,
                            borderColor: '#ff6a00',
                            backgroundColor: function(context) {
                                const chart = context.chart;
                                const {ctx, chartArea} = chart;
                                if (!chartArea) return null;
                                const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                                gradient.addColorStop(0, 'rgba(255, 106, 0, 0.3)');
                                gradient.addColorStop(1, 'rgba(238, 9, 121, 0.05)');
                                return gradient;
                            },
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#ff6a00',
                            pointBorderColor: '#1a1a2e',
                            pointBorderWidth: 3,
                            pointRadius: 5,
                            pointHoverRadius: 8,
                            pointHoverBorderWidth: 4,
                        },
                        {
                            label: 'Male',
                            data: data.laki_laki,
                            borderColor: '#00f2fe',
                            backgroundColor: function(context) {
                                const chart = context.chart;
                                const {ctx, chartArea} = chart;
                                if (!chartArea) return null;
                                const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                                gradient.addColorStop(0, 'rgba(0, 242, 254, 0.3)');
                                gradient.addColorStop(1, 'rgba(79, 172, 254, 0.05)');
                                return gradient;
                            },
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#00f2fe',
                            pointBorderColor: '#1a1a2e',
                            pointBorderWidth: 3,
                            pointRadius: 5,
                            pointHoverRadius: 8,
                            pointHoverBorderWidth: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                padding: 16,
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                color: '#b8c1ec',
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 8,
                                boxHeight: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(26, 26, 46, 0.95)',
                            padding: 14,
                            cornerRadius: 10,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            bodySpacing: 8,
                            borderColor: 'rgba(102, 126, 234, 0.3)',
                            borderWidth: 1,
                            displayColors: true,
                            boxWidth: 12,
                            boxHeight: 12,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + 
                                           Math.round(context.parsed.y).toLocaleString('id-ID') + ' persons';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                color: '#8892b0',
                                padding: 10,
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
                            },
                            grid: {
                                color: 'rgba(45, 53, 97, 0.5)',
                                drawBorder: false,
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                color: '#8892b0',
                                padding: 10,
                                maxRotation: 45,
                                minRotation: 45
                            },
                            grid: {
                                display: false,
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
});
</script>
@endpush