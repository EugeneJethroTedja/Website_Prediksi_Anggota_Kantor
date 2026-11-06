@extends('layouts.app')

@section('title', 'Dashboard Lengkap - Sistem Prediksi')
@section('page-title', 'Dashboard Analytics Lengkap')

@push('styles')
<style>
    /* Premium Dashboard Styles */
    .dashboard-premium {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Header Card Premium */
    .header-card-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .header-card-premium h1 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
    }

    .header-card-premium p {
        margin: 0;
        opacity: 0.9;
        font-size: 1.05rem;
    }

    /* NEW: Method Selector Card */
    .method-selector-card {
        background: white;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .method-option {
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        height: 100%;
        position: relative;
    }

    .method-option:hover {
        border-color: #667eea;
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }

    .method-option.active {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
    }

    .method-option.active::after {
        content: '\f00c';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: 1rem;
        right: 1rem;
        color: #667eea;
        font-size: 1.25rem;
    }

    .method-option input[type="radio"] {
        display: none;
    }

    .method-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .method-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 0.5rem;
    }

    .method-desc {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }

    .method-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-high {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .badge-medium {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    /* NEW: Prediction Result Info Card */
    .prediction-result-card {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(79, 172, 254, 0.3);
    }

    .prediction-result-card .result-label {
        font-size: 0.9rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .prediction-result-card .result-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .prediction-result-card .result-detail {
        font-size: 0.85rem;
        opacity: 0.85;
    }

    /* Filter Card Premium */
    .filter-card-premium {
        background: white;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .filter-card-premium .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
        border: none;
        padding: 1.5rem 2rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .filter-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0;
    }

    .filter-card-premium .card-body {
        padding: 2rem;
    }

    .filter-card-premium .form-label {
        font-weight: 600;
        color: #1a1d2e;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .filter-card-premium .form-control,
    .filter-card-premium .form-select {
        border-radius: 12px;
        border: 2px solid #e1e8ed;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .filter-card-premium .form-control:focus,
    .filter-card-premium .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    /* Luxury Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .stat-card-luxury {
        border: none;
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .stat-card-luxury:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .stat-card-luxury::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.1;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .stat-card-luxury.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card-luxury.success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .stat-card-luxury.danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stat-card-luxury.warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .stat-icon-luxury {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 4rem;
        opacity: 0.2;
    }

    .stat-value-luxury {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1;
        margin: 1rem 0;
        position: relative;
        z-index: 1;
    }

    .stat-label-luxury {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    .stat-detail-luxury {
        font-size: 0.9rem;
        opacity: 0.8;
        position: relative;
        z-index: 1;
    }

    /* Charts Scroll Container */
    .charts-scroll-wrapper {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .charts-scroll-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 0 0.5rem;
    }

    .charts-scroll-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0;
    }

    .charts-scroll-container {
        display: flex;
        overflow-x: auto;
        gap: 2rem;
        padding: 1rem 0.5rem;
        scroll-behavior: smooth;
    }

    .charts-scroll-container::-webkit-scrollbar {
        height: 10px;
    }

    .charts-scroll-container::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        margin: 0 1rem;
    }

    .charts-scroll-container::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    .charts-scroll-container::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    /* Chart Item - Fixed Size */
    .chart-item {
        min-width: 550px;
        max-width: 550px;
        flex-shrink: 0;
    }

    /* Chart Container Premium */
    .chart-container-premium {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .chart-container-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 50px rgba(0, 0, 0, 0.12);
    }

    .chart-container-premium::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0;
        flex: 1;
        min-width: 200px;
    }

    .chart-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .chart-canvas-wrapper {
        position: relative;
        height: 320px;
        z-index: 1;
    }

    /* Chart Stats Box */
    .chart-stats-box {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .chart-stats-item {
        text-align: center;
    }

    .chart-stats-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .chart-stats-value {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .chart-stats-value.male {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Tab Navigation Premium */
    .nav-tabs-premium {
        border: none;
        background: white;
        padding: 0.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .nav-tabs-premium .nav-link {
        border: none;
        border-radius: 12px;
        color: #6c757d;
        font-weight: 600;
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .nav-tabs-premium .nav-link:hover {
        color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .nav-tabs-premium .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Summary Table Premium */
    .summary-card-premium {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        height: 100%;
    }

    .summary-card-premium .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
        border: none;
        padding: 1.5rem;
        font-weight: 700;
        color: #1a1d2e;
        border-bottom: 2px solid #f0f0f0;
    }

    .table-premium {
        margin: 0;
    }

    .table-premium thead th {
        background: #f8f9fa;
        border: none;
        color: #6c757d;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    .table-premium tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .table-premium tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.002);
    }

    .table-premium tbody td {
        padding: 1rem;
        vertical-align: middle;
        border: none;
    }

    /* Avatar Box */
    .avatar-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Scrollbar Custom */
    .custom-scroll::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    /* Button Premium */
    .btn-premium-primary {
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-premium-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-premium-reset {
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: 2px solid #e1e8ed;
        background: white;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .btn-premium-reset:hover {
        background: #f8f9fa;
        color: #495057;
        border-color: #ced4da;
        transform: translateY(-2px);
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .nav-tabs-premium .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-premium">
    <div class="container-fluid">
        
        {{-- Header Premium --}}
        <div class="header-card-premium fade-in-up">
            <h1>
                <i class="fas fa-chart-bar me-3"></i>Dashboard Analytics Lengkap
            </h1>
            <p>Analisis komprehensif prediksi anggota dengan filter custom, pemilihan metode AI, dan breakdown kategori</p>
        </div>

        {{-- NEW: Method Selector --}}
        <div class="method-selector-card fade-in-up" style="animation-delay: 0.05s">
            <div class="card-header" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%); border: none; padding: 1.5rem 2rem; border-bottom: 2px solid #f0f0f0;">
                <h3 style="font-size: 1.3rem; font-weight: 700; color: #1a1d2e; margin: 0;">
                    <i class="fas fa-brain me-2" style="color: #667eea;"></i>
                    Pilih Metode Prediksi AI
                </h3>
                <p class="mb-0 mt-2 text-muted">Pilih algoritma yang sesuai dengan karakteristik data Anda</p>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <form id="methodForm" action="{{ route('dashboard-lengkap.index') }}" method="GET">
                    {{-- Preserve other filters --}}
                    <input type="hidden" name="bulan_mulai" value="{{ request('bulan_mulai') }}">
                    <input type="hidden" name="tahun_mulai" value="{{ request('tahun_mulai') }}">
                    <input type="hidden" name="bulan_selesai" value="{{ request('bulan_selesai') }}">
                    <input type="hidden" name="tahun_selesai" value="{{ request('tahun_selesai') }}">
                    
                    <div class="row g-3">
                        @foreach($availableMethods as $methodKey => $method)
                        <div class="col-md-4">
                            <label class="method-option {{ request('prediction_method', 'combined') == $methodKey ? 'active' : '' }}">
                                <input type="radio" name="prediction_method" value="{{ $methodKey }}" 
                                       {{ request('prediction_method', 'combined') == $methodKey ? 'checked' : '' }}>
                                <div class="method-icon">
                                    <i class="fas fa-{{ $methodKey == 'combined' ? 'layer-group' : ($methodKey == 'exponential_smoothing' ? 'wave-square' : ($methodKey == 'linear_trend' ? 'chart-line' : ($methodKey == 'weighted_moving_average' ? 'weight-hanging' : 'project-diagram'))) }}"></i>
                                </div>
                                <div class="method-title">{{ $method['name'] }}</div>
                                <div class="method-desc">{{ $method['description'] }}</div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="method-badge {{ $method['accuracy'] == 'Tinggi' ? 'badge-high' : 'badge-medium' }}">
                                        {{ $method['accuracy'] }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>{{ $method['best_for'] }}
                                    </small>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        {{-- NEW: Prediction Result Info --}}
        @if($predictionResultInfo)
        <div class="prediction-result-card fade-in-up" style="animation-delay: 0.1s">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="result-label">
                        <i class="fas fa-calendar-check me-2"></i>Periode Prediksi
                    </div>
                    <div class="result-value">
                        {{ $predictionResultInfo['start'] }} - {{ $predictionResultInfo['end'] }}
                    </div>
                    <div class="result-detail">
                        Total {{ $predictionResultInfo['total_months'] }} bulan prediksi menggunakan metode 
                        <strong>{{ $availableMethods[request('prediction_method', 'combined')]['name'] }}</strong>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div style="background: rgba(255, 255, 255, 0.2); border-radius: 16px; padding: 1.5rem; display: inline-block;">
                        <div class="result-label mb-2">
                            <i class="fas fa-chart-line me-2"></i>Total Data Hasil Prediksi
                        </div>
                        <div class="result-value" style="font-size: 2.5rem;">
                            {{ $prediksiTerbaru->count() }}
                        </div>
                        <div class="result-detail">Record prediksi tersimpan</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Filter Card Premium --}}
        <div class="filter-card-premium fade-in-up" style="animation-delay: {{ $predictionResultInfo ? '0.15' : '0.1' }}s">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="filter-title mb-0">
                    <i class="fas fa-sliders-h me-2"></i>Filter & Generate Prediksi
                </h3>

                {{-- Tombol Reset --}}
                <a href="{{ route('dashboard-lengkap.index') }}"
                   class="btn-premium-reset d-flex align-items-center"
                   style="height: 42px;">
                    <i class="fas fa-rotate-left me-2"></i>Reset
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard-lengkap.index') }}" method="GET" id="filterForm">
                    {{-- Preserve prediction method --}}
                    <input type="hidden" name="prediction_method" value="{{ request('prediction_method', 'combined') }}">
                    
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-calendar-day me-2"></i>Bulan Mulai
                            </label>
                            <select name="bulan_mulai" class="form-select" required>
                                <option value="">Pilih Bulan</option>
                                @foreach($bulanList as $key => $bulan)
                                    <option value="{{ $key }}" {{ request('bulan_mulai') == $key ? 'selected' : '' }}>
                                        {{ $bulan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-calendar me-2"></i>Tahun Mulai
                            </label>
                            <input type="number" name="tahun_mulai" class="form-control"
                                   value="{{ request('tahun_mulai') }}" placeholder="2024" required>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-calendar-day me-2"></i>Bulan Selesai
                            </label>
                            <select name="bulan_selesai" class="form-select" required>
                                <option value="">Pilih Bulan</option>
                                @foreach($bulanList as $key => $bulan)
                                    <option value="{{ $key }}" {{ request('bulan_selesai') == $key ? 'selected' : '' }}>
                                        {{ $bulan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-calendar me-2"></i>Tahun Selesai
                            </label>
                            <input type="number" name="tahun_selesai" class="form-control"
                                   value="{{ request('tahun_selesai') }}" placeholder="2024" required>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">
                                <i class="fas fa-filter me-2"></i>Filter Metode
                            </label>
                            <select name="filter_method" class="form-select">
                                <option value="all">Semua Metode</option>
                                @foreach($availableMethods as $methodKey => $method)
                                    <option value="{{ $methodKey }}" {{ request('filter_method') == $methodKey ? 'selected' : '' }}>
                                        {{ $method['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-12">
                            <button type="submit" class="btn-premium-primary w-100" style="height: 48px;">
                                <i class="fas fa-chart-line me-2"></i>Generate
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="stats-grid fade-in-up" style="animation-delay: {{ $predictionResultInfo ? '0.2' : '0.15' }}s">
            <div class="stat-card-luxury primary">
                <i class="fas fa-calendar-alt stat-icon-luxury"></i>
                <div style="position: relative; z-index: 1;">
                    <div class="stat-label-luxury">Total Periode</div>
                    <div class="stat-value-luxury">{{ $periodeList->count() }}</div>
                    <div class="stat-detail-luxury">Periode Aktif Terdaftar</div>
                </div>
            </div>
            
            <div class="stat-card-luxury success">
                <i class="fas fa-users stat-icon-luxury"></i>
                <div style="position: relative; z-index: 1;">
                    <div class="stat-label-luxury">Total Prediksi</div>
                    <div class="stat-value-luxury">{{ number_format($totalPrediksiSemua) }}</div>
                    <div class="stat-detail-luxury">Anggota Diprediksi</div>
                </div>
            </div>
            
            <div class="stat-card-luxury danger">
                <i class="fas fa-female stat-icon-luxury"></i>
                <div style="position: relative; z-index: 1;">
                    <div class="stat-label-luxury">Prediksi Perempuan</div>
                    <div class="stat-value-luxury">{{ number_format($totalPrediksiPerempuan) }}</div>
                    <div class="stat-detail-luxury">{{ $totalPrediksiSemua > 0 ? number_format(($totalPrediksiPerempuan/$totalPrediksiSemua)*100, 1) : 0 }}% dari total</div>
                </div>
            </div>
            
            <div class="stat-card-luxury warning">
                <i class="fas fa-male stat-icon-luxury"></i>
                <div style="position: relative; z-index: 1;">
                    <div class="stat-label-luxury">Prediksi Laki-Laki</div>
                    <div class="stat-value-luxury">{{ number_format($totalPrediksiLakiLaki) }}</div>
                    <div class="stat-detail-luxury">{{ $totalPrediksiSemua > 0 ? number_format(($totalPrediksiLakiLaki/$totalPrediksiSemua)*100, 1) : 0 }}% dari total</div>
                </div>
            </div>
        </div>

        {{-- Charts Horizontal Scroll --}}
        @if(!empty($chartData))
        <div class="charts-scroll-wrapper fade-in-up" style="animation-delay: {{ $predictionResultInfo ? '0.25' : '0.2' }}s">
            <div class="charts-scroll-header">
                <h3 class="charts-scroll-title">
                    <i class="fas fa-chart-area me-2" style="color: #667eea;"></i>
                    Analisis Trend & Prediksi Per Periode
                </h3>
                <small class="text-muted">
                    <i class="fas fa-arrows-alt-h me-1"></i>Scroll untuk melihat semua grafik
                </small>
            </div>
            
            <div class="charts-scroll-container">
                @foreach($chartData as $periodeId => $data)
                <div class="chart-item">
                    <div class="chart-container-premium">
                        <div class="chart-header">
                            <h3 class="chart-title">
                                <i class="fas fa-chart-line me-2" style="color: #667eea;"></i>
                                <span style="display: inline-block;">{{ $data['nama_periode'] }}</span>
                            </h3>
                            @if($data['has_prediction'])
                                <span class="chart-badge">
                                    <i class="fas fa-check-circle me-1"></i> Prediksi Ready
                                </span>
                            @else
                                <span class="chart-badge" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                    <i class="fas fa-clock me-1"></i> Waiting Data
                                </span>
                            @endif
                        </div>
                        
                        <div class="chart-canvas-wrapper">
                            <canvas id="chart-{{ $periodeId }}"></canvas>
                        </div>
                        
                        @if($data['has_prediction'])
                        <div class="chart-stats-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="chart-stats-item">
                                        <div class="chart-stats-label">
                                            <i class="fas fa-female me-1"></i>Prediksi Perempuan
                                        </div>
                                        <div class="chart-stats-value">
                                            {{ number_format(end($data['perempuan'])) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="chart-stats-item">
                                        <div class="chart-stats-label">
                                            <i class="fas fa-male me-1"></i>Prediksi Laki-Laki
                                        </div>
                                        <div class="chart-stats-value male">
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

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs nav-tabs-premium fade-in-up" style="animation-delay: {{ $predictionResultInfo ? '0.3' : '0.25' }}s" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-pendidikan">
                    <i class="fas fa-graduation-cap me-2"></i>Pendidikan
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-golongan">
                    <i class="fas fa-layer-group me-2"></i>Golongan
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-jabatan">
                    <i class="fas fa-briefcase me-2"></i>Jabatan
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-agama">
                    <i class="fas fa-pray me-2"></i>Agama
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-jf-tertentu-pns">
                    <i class="fas fa-user-tie me-2"></i>JF Tertentu PNS
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-jf-tertentu-pppk">
                    <i class="fas fa-user-tie me-2"></i>JF Tertentu PPPK
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-jf-pelaksana-pns">
                    <i class="fas fa-user-cog me-2"></i>JF Pelaksana PNS
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-jf-pelaksana-pppk">
                    <i class="fas fa-user-cog me-2"></i>JF Pelaksana PPPK
                </button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content fade-in-up" style="animation-delay: {{ $predictionResultInfo ? '0.35' : '0.3' }}s">
            {{-- Pendidikan --}}
            <div class="tab-pane fade show active" id="tab-pendidikan">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Ringkasan Prediksi Pendidikan
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="30%">Tingkat Pendidikan</th>
                                    <th width="17%" class="text-center">Laki-Laki</th>
                                    <th width="17%" class="text-center">Perempuan</th>
                                    <th width="17%" class="text-center">Total</th>
                                    <th width="19%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summaryPendidikan as $label => $data)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-right: 1rem;">
                                                {{ substr($label, 0, 1) }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">{{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #667eea;">
                                            {{ number_format($data['laki']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(245, 87, 108, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #f5576c;">
                                            {{ number_format($data['perempuan']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong style="font-size: 1.1rem; color: #1a1d2e;">{{ number_format($data['total']) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100%; width: {{ $totalPrediksiSemua > 0 ? ($data['total']/$totalPrediksiSemua)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalPrediksiSemua > 0 ? number_format(($data['total']/$totalPrediksiSemua)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Golongan --}}
            <div class="tab-pane fade" id="tab-golongan">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-layer-group me-2"></i>
                        Ringkasan Prediksi Golongan
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="30%">Golongan</th>
                                    <th width="17%" class="text-center">Laki-Laki</th>
                                    <th width="17%" class="text-center">Perempuan</th>
                                    <th width="17%" class="text-center">Total</th>
                                    <th width="19%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summaryGolongan as $label => $data)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); margin-right: 1rem; font-size: 0.85rem;">
                                                {{ substr($label, 0, 2) }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">{{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #667eea;">
                                            {{ number_format($data['laki']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(245, 87, 108, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #f5576c;">
                                            {{ number_format($data['perempuan']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong style="font-size: 1.1rem; color: #1a1d2e;">{{ number_format($data['total']) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); height: 100%; width: {{ $totalPrediksiSemua > 0 ? ($data['total']/$totalPrediksiSemua)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalPrediksiSemua > 0 ? number_format(($data['total']/$totalPrediksiSemua)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Jabatan --}}
            <div class="tab-pane fade" id="tab-jabatan">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-briefcase me-2"></i>
                        Ringkasan Prediksi Jabatan
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="30%">Jabatan Eselon</th>
                                    <th width="17%" class="text-center">Laki-Laki</th>
                                    <th width="17%" class="text-center">Perempuan</th>
                                    <th width="17%" class="text-center">Total</th>
                                    <th width="19%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summaryJabatan as $label => $data)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); margin-right: 1rem; font-size: 0.85rem;">
                                                {{ $label }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">Eselon {{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #667eea;">
                                            {{ number_format($data['laki']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(245, 87, 108, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #f5576c;">
                                            {{ number_format($data['perempuan']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong style="font-size: 1.1rem; color: #1a1d2e;">{{ number_format($data['total']) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); height: 100%; width: {{ $totalPrediksiSemua > 0 ? ($data['total']/$totalPrediksiSemua)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalPrediksiSemua > 0 ? number_format(($data['total']/$totalPrediksiSemua)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Agama --}}
            <div class="tab-pane fade" id="tab-agama">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-pray me-2"></i>
                        Ringkasan Prediksi Agama
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="30%">Agama</th>
                                    <th width="17%" class="text-center">Laki-Laki</th>
                                    <th width="17%" class="text-center">Perempuan</th>
                                    <th width="17%" class="text-center">Total</th>
                                    <th width="19%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summaryAgama as $label => $data)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); margin-right: 1rem; font-size: 0.85rem;">
                                                {{ substr($label, 0, 1) }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">{{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #667eea;">
                                            {{ number_format($data['laki']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(245, 87, 108, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #f5576c;">
                                            {{ number_format($data['perempuan']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong style="font-size: 1.1rem; color: #1a1d2e;">{{ number_format($data['total']) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); height: 100%; width: {{ $totalPrediksiSemua > 0 ? ($data['total']/$totalPrediksiSemua)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalPrediksiSemua > 0 ? number_format(($data['total']/$totalPrediksiSemua)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- JF Tertentu PNS --}}
            <div class="tab-pane fade" id="tab-jf-tertentu-pns">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-user-tie me-2"></i>
                        Ringkasan Prediksi JF Tertentu PNS
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="50%">Kategori JF Tertentu PNS</th>
                                    <th width="30%" class="text-center">Total</th>
                                    <th width="20%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalJfTertentuPns = array_sum($summaryJfTertentuPns);
                                @endphp
                                @foreach($summaryJfTertentuPns as $label => $total)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-right: 1rem;">
                                                {{ $label }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">JF Tertentu PNS {{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #667eea;">
                                            {{ number_format($total) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100%; width: {{ $totalJfTertentuPns > 0 ? ($total/$totalJfTertentuPns)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalJfTertentuPns > 0 ? number_format(($total/$totalJfTertentuPns)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- JF Tertentu PPPK --}}
            <div class="tab-pane fade" id="tab-jf-tertentu-pppk">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-user-tie me-2"></i>
                        Ringkasan Prediksi JF Tertentu PPPK
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="50%">Kategori JF Tertentu PPPK</th>
                                    <th width="30%" class="text-center">Total</th>
                                    <th width="20%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalJfTertentuPppk = array_sum($summaryJfTertentuPppk);
                                @endphp
                                @foreach($summaryJfTertentuPppk as $label => $total)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); margin-right: 1rem;">
                                                {{ $label }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">JF Tertentu PPPK {{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #4facfe;">
                                            {{ number_format($total) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); height: 100%; width: {{ $totalJfTertentuPppk > 0 ? ($total/$totalJfTertentuPppk)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalJfTertentuPppk > 0 ? number_format(($total/$totalJfTertentuPppk)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- JF Pelaksana PNS --}}
            <div class="tab-pane fade" id="tab-jf-pelaksana-pns">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-user-cog me-2"></i>
                        Ringkasan Prediksi JF Pelaksana PNS
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="50%">Kategori JF Pelaksana PNS</th>
                                    <th width="30%" class="text-center">Total</th>
                                    <th width="20%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalJfPelaksanaPns = array_sum($summaryJfPelaksanaPns);
                                @endphp
                                @foreach($summaryJfPelaksanaPns as $label => $total)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); margin-right: 1rem;">
                                                {{ $label }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">JF Pelaksana PNS {{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #11998e;">
                                            {{ number_format($total) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); height: 100%; width: {{ $totalJfPelaksanaPns > 0 ? ($total/$totalJfPelaksanaPns)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalJfPelaksanaPns > 0 ? number_format(($total/$totalJfPelaksanaPns)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- JF Pelaksana PPPK --}}
            <div class="tab-pane fade" id="tab-jf-pelaksana-pppk">
                <div class="summary-card-premium">
                    <div class="card-header">
                        <i class="fas fa-user-cog me-2"></i>
                        Ringkasan Prediksi JF Pelaksana PPPK
                    </div>
                    <div class="table-responsive custom-scroll" style="max-height: 450px;">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="50%">Kategori JF Pelaksana PPPK</th>
                                    <th width="30%" class="text-center">Total</th>
                                    <th width="20%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalJfPelaksanaPppk = array_sum($summaryJfPelaksanaPppk);
                                @endphp
                                @foreach($summaryJfPelaksanaPppk as $label => $total)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="avatar-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); margin-right: 1rem;">
                                                {{ $label }}
                                            </div>
                                            <strong style="font-size: 0.95rem;">JF Pelaksana PPPK {{ $label }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span style="background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; color: #f093fb;">
                                            {{ number_format($total) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div style="width: 100px; margin: 0 auto;">
                                            <div style="background: #f0f0f0; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.25rem;">
                                                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); height: 100%; width: {{ $totalJfPelaksanaPppk > 0 ? ($total/$totalJfPelaksanaPppk)*100 : 0 }}%;"></div>
                                            </div>
                                            <small class="text-muted" style="font-weight: 600;">{{ $totalJfPelaksanaPppk > 0 ? number_format(($total/$totalJfPelaksanaPppk)*100, 1) : 0 }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Method Selection Handler
    const methodOptions = document.querySelectorAll('.method-option');
    const methodForm = document.getElementById('methodForm');
    
    methodOptions.forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Remove active class from all options
            methodOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to selected option
            this.classList.add('active');
            
            // Auto-submit form when method is changed
            methodForm.submit();
        });
    });

    // Chart Configuration
    const chartData = @json($chartData ?? []);
    
    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif";
    
    Object.keys(chartData).forEach(periodeId => {
        const data = chartData[periodeId];
        const ctx = document.getElementById('chart-' + periodeId);
        
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Perempuan',
                            data: data.perempuan,
                            borderColor: '#f5576c',
                            backgroundColor: function(context) {
                                const chart = context.chart;
                                const {ctx, chartArea} = chart;
                                if (!chartArea) {
                                    return null;
                                }
                                const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                                gradient.addColorStop(0, 'rgba(245, 87, 108, 0.25)');
                                gradient.addColorStop(1, 'rgba(245, 87, 108, 0.0)');
                                return gradient;
                            },
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#f5576c',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 9,
                            pointHoverBorderWidth: 4,
                            pointHoverBackgroundColor: '#f5576c',
                            pointHoverBorderColor: '#fff'
                        },
                        {
                            label: 'Laki-Laki',
                            data: data.laki_laki,
                            borderColor: '#667eea',
                            backgroundColor: function(context) {
                                const chart = context.chart;
                                const {ctx, chartArea} = chart;
                                if (!chartArea) {
                                    return null;
                                }
                                const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                                gradient.addColorStop(0, 'rgba(102, 126, 234, 0.25)');
                                gradient.addColorStop(1, 'rgba(102, 126, 234, 0.0)');
                                return gradient;
                            },
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 9,
                            pointHoverBorderWidth: 4,
                            pointHoverBackgroundColor: '#667eea',
                            pointHoverBorderColor: '#fff'
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
                                padding: 20,
                                font: {
                                    size: 13,
                                    weight: '600'
                                },
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 8,
                                boxHeight: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(26, 29, 46, 0.95)',
                            padding: 16,
                            cornerRadius: 12,
                            titleFont: {
                                size: 15,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 14
                            },
                            bodySpacing: 8,
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            displayColors: true,
                            boxWidth: 12,
                            boxHeight: 12,
                            boxPadding: 6,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += Math.round(context.parsed.y).toLocaleString('id-ID') + ' orang';
                                    return label;
                                },
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label;
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
                                color: '#6c757d',
                                padding: 10,
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.06)',
                                drawBorder: false,
                                lineWidth: 1
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
                                color: '#6c757d',
                                padding: 10,
                                maxRotation: 45,
                                minRotation: 45
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            border: {
                                display: false
                            }
                        }
                    },
                    elements: {
                        line: {
                            borderJoinStyle: 'round'
                        }
                    }
                }
            });
        }
    });
});
</script>
@endpush