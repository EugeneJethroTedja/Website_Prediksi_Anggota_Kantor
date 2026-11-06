@extends('layouts.app')

@section('title', 'Kelola Data Anggota')
@section('page-title', 'Manajemen Data Anggota')

@push('styles')
<style>
    .page-luxury {
        background: var(--color-bg-primary);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Header Card Luxury */
    .header-card-luxury {
        background: var(--gradient-card-1);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .header-card-luxury h1 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        font-family: 'Space Grotesk', sans-serif;
    }

    .header-card-luxury p {
        margin: 0;
        opacity: 0.9;
        font-size: 1.05rem;
    }

    /* Filter Card */
    .filter-card-luxury {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(35, 41, 70, 0.9) 100%);
        border: 1px solid var(--color-border);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    }

    .filter-title-luxury {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    /* Main Card Luxury */
    .main-card-luxury {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(35, 41, 70, 0.9) 100%);
        border: 1px solid var(--color-border);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .main-card-luxury .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.3);
        padding: 1.5rem 2rem;
    }

    .card-title-luxury {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0;
        font-family: 'Space Grotesk', sans-serif;
    }

    /* Button Luxury */
    .btn-luxury {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: var(--transition-base);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1rem;
    }

    .btn-luxury-primary,
    .btn-luxury-success {
        background: var(--gradient-success);
        color: white;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }

    .btn-luxury-primary:hover,
    .btn-luxury-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(17, 153, 142, 0.5);
        color: white;
    }

    .btn-luxury-secondary {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.2) 0%, rgba(136, 146, 176, 0.2) 100%);
        border: 1px solid var(--color-border);
        color: var(--color-text-secondary);
    }

    .btn-luxury-secondary:hover {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.3) 0%, rgba(136, 146, 176, 0.3) 100%);
        color: var(--color-text-primary);
        transform: translateY(-2px);
    }

    /* Avatar & Badges */
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

    .number-box-luxury {
        width: 36px;
        height: 36px;
        background: var(--gradient-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
    }

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

    .badge-gaji-luxury {
        background: rgba(26, 26, 46, 0.8);
        border: 1px solid rgba(17, 153, 142, 0.5);
        padding: 0.6rem 1.1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        color: #38ef7d;
        display: inline-block;
    }

    .badge-status-recent-luxury {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.2) 0%, rgba(56, 239, 125, 0.2) 100%);
        border: 1px solid rgba(17, 153, 142, 0.5);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        color: #38ef7d;
        display: inline-block;
        font-size: 0.75rem;
    }

    .badge-status-old-luxury {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.1) 0%, rgba(136, 146, 176, 0.1) 100%);
        border: 1px solid var(--color-border);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        color: var(--color-text-tertiary);
        display: inline-block;
        font-size: 0.75rem;
    }

    /* Table Luxury */
    .table-luxury {
        margin: 0;
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

    /* Action Buttons */
    .btn-action-group-luxury {
        display: inline-flex;
        gap: 0.5rem;
    }

    .btn-action-luxury {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 0.9rem;
        transition: var(--transition-base);
        cursor: pointer;
    }

    .btn-action-edit-luxury {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.2) 0%, rgba(245, 87, 108, 0.2) 100%);
        border: 1px solid rgba(240, 147, 251, 0.4);
        color: #f093fb;
    }

    .btn-action-edit-luxury:hover {
        background: var(--gradient-card-4);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
    }

    .btn-action-delete-luxury {
        background: linear-gradient(135deg, rgba(238, 9, 121, 0.15) 0%, rgba(238, 9, 121, 0.1) 100%);
        border: 1px solid rgba(238, 9, 121, 0.4);
        color: #ee0979;
    }

    .btn-action-delete-luxury:hover {
        background: var(--gradient-danger);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(238, 9, 121, 0.4);
    }

    /* Empty State */
    .empty-state-luxury {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon-luxury {
        font-size: 5rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-state-title-luxury {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.75rem;
    }

    .empty-state-text-luxury {
        color: var(--color-text-tertiary);
        font-size: 0.95rem;
    }

    /* Stats Mini Cards */
    .stats-grid-luxury {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

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

    .stat-card-luxury.gradient-info {
        background: var(--gradient-card-5);
        border-color: rgba(79, 172, 254, 0.5);
    }

    .stat-card-luxury.gradient-warning {
        background: var(--gradient-card-4);
        border-color: rgba(240, 147, 251, 0.5);
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

    /* Pagination Luxury */
    .pagination {
        gap: 0.5rem;
    }

    .pagination .page-link {
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        background: rgba(102, 126, 234, 0.1);
        border: 1px solid rgba(102, 126, 234, 0.3);
        color: var(--color-text-primary);
        font-weight: 600;
        transition: var(--transition-base);
    }

    .pagination .page-link:hover {
        background: var(--gradient-primary);
        color: white;
        transform: translateY(-2px);
    }

    .pagination .page-item.active .page-link {
        background: var(--gradient-primary);
        border: none;
        color: white;
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
</style>
@endpush

@section('content')
<div class="page-luxury">
    <div class="container-fluid">
        
        {{-- Header Luxury --}}
        <div class="header-card-luxury fade-in-up">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>
                        <i class="fas fa-database me-3"></i>Manajemen Data Anggota
                    </h1>
                    <p>Kelola data historis anggota untuk prediksi yang akurat</p>
                </div>
                <a href="{{ route('data-anggota.create') }}" class="btn-luxury btn-luxury-success">
                    <i class="fas fa-plus-circle"></i>Tambah Data Baru
                </a>
            </div>
        </div>

        {{-- Stats Mini Cards --}}
        @if(!$dataAnggota->isEmpty())
        <div class="stats-grid-luxury fade-in-up" style="animation-delay: 0.1s">
            <div class="stat-card-luxury gradient-primary">
                <div class="stat-label-luxury">
                    <i class="fas fa-database me-1"></i>Total Data
                </div>
                <div class="stat-value-luxury">{{ $dataAnggota->total() }}</div>
                <div class="stat-detail-luxury">
                    @if(request('instansi_id') || request('search'))
                        Hasil Tersaring
                    @else
                        Daftar Data Terdaftar
                    @endif
                </div>
            </div>
            
            <div class="stat-card-luxury gradient-success">
                <div class="stat-label-luxury">
                    <i class="fas fa-building me-1"></i>Periode
                </div>
                <div class="stat-value-luxury">{{ $dataAnggota->unique('instansi_id')->count() }}</div>
                <div class="stat-detail-luxury">Jumlah Periode</div>
            </div>
            
            <div class="stat-card-luxury gradient-danger">
                <div class="stat-label-luxury">
                    <i class="fas fa-female me-1"></i>Total Perempuan
                </div>
                <div class="stat-value-luxury">{{ number_format($dataAnggota->sum('jumlah_perempuan')) }}</div>
                <div class="stat-detail-luxury">Semua Data</div>
            </div>
            
            <div class="stat-card-luxury gradient-info">
                <div class="stat-label-luxury">
                    <i class="fas fa-male me-1"></i>Total Laki-Laki
                </div>
                <div class="stat-value-luxury">{{ number_format($dataAnggota->sum('jumlah_laki_laki')) }}</div>
                <div class="stat-detail-luxury">Semua Data</div>
            </div>

            <div class="stat-card-luxury gradient-warning">
                <div class="stat-label-luxury">
                    <i class="fas fa-money-bill-wave me-1"></i>Avg. Gaji
                </div>
                <div class="stat-value-luxury" style="font-size: 1.2rem;">
                    @php
                        $avgGaji = $dataAnggota->avg('rata_rata_gaji') ?? 0;
                    @endphp
                    {{ number_format($avgGaji / 1000000, 1) }}Jt
                </div>
                <div class="stat-detail-luxury">Rata-rata Keseluruhan</div>
            </div>
        </div>
        @endif

        {{-- Filter Card --}}
        <div class="filter-card-luxury fade-in-up" style="animation-delay: 0.2s">
            <div class="filter-title-luxury">
                <i class="fas fa-filter me-2"></i>Filter & Pencarian
            </div>
            <form action="{{ route('data-anggota.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label text-muted small fw-bold" style="color: var(--color-text-tertiary) !important;">PERIODE</label>
                        <select name="instansi_id" class="form-select" style="border-radius: 10px; border: 1px solid rgba(102, 126, 234, 0.3); background: rgba(35, 41, 70, 0.6); color: var(--color-text-primary);">
                            <option value="">Semua Periode</option>
                            @foreach($allInstansi ?? [] as $inst)
                                <option value="{{ $inst->id }}" {{ request('instansi_id') == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->nama_instansi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-muted small fw-bold" style="color: var(--color-text-tertiary) !important;">TAHUN</label>
                        <select name="tahun" class="form-select" style="border-radius: 10px; border: 1px solid rgba(102, 126, 234, 0.3); background: rgba(35, 41, 70, 0.6); color: var(--color-text-primary);">
                            <option value="">Semua Tahun</option>
                            @for($y = date('Y'); $y >= 2015; $y--)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-muted small fw-bold" style="color: var(--color-text-tertiary) !important;">BULAN</label>
                        <select name="bulan" class="form-select" style="border-radius: 10px; border: 1px solid rgba(102, 126, 234, 0.3); background: rgba(35, 41, 70, 0.6); color: var(--color-text-primary);">
                            <option value="">Semua Bulan</option>
                            <option value="1" {{ request('bulan') == '1' ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ request('bulan') == '2' ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ request('bulan') == '3' ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ request('bulan') == '4' ? 'selected' : '' }}>April</option>
                            <option value="5" {{ request('bulan') == '5' ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ request('bulan') == '6' ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ request('bulan') == '7' ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ request('bulan') == '8' ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ request('bulan') == '9' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label text-muted small fw-bold" style="color: var(--color-text-tertiary) !important;">PENCARIAN</label>
                        <input type="text" name="search" class="form-select" placeholder="Cari periode..." 
                               value="{{ request('search') }}" style="border-radius: 10px; border: 1px solid rgba(102, 126, 234, 0.3); background: rgba(35, 41, 70, 0.6); color: var(--color-text-primary);">
                    </div>
                    <div class="col-lg-2 col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn-luxury btn-luxury-primary flex-grow-1" style="height: 42px;">
                            <i class="fas fa-search"></i>Filter
                        </button>
                        <a href="{{ route('data-anggota.index') }}" class="btn-luxury btn-luxury-secondary" 
                           style="height: 42px; width: 42px; padding: 0; justify-content: center;">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Main Table Card --}}
        <div class="main-card-luxury fade-in-up" style="animation-delay: 0.3s">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title-luxury">
                        <i class="fas fa-table me-2"></i>Data Anggota Historis
                    </h3>
                    <span class="badge" style="background: var(--gradient-primary); color: white; padding: 0.5rem 1.25rem; border-radius: 50px; font-size: 0.9rem;">
                        {{ $dataAnggota->total() }} Records
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($dataAnggota->isEmpty())
                    <div class="empty-state-luxury">
                        <div class="empty-state-icon-luxury">
                            <i class="fas fa-database"></i>
                        </div>
                        <h5 class="empty-state-title-luxury">Tidak Ada Data Anggota</h5>
                        <p class="empty-state-text-luxury">Mulai input data historis anggota untuk menghasilkan prediksi yang akurat</p>
                        <a href="{{ route('data-anggota.create') }}" class="btn-luxury btn-luxury-success" style="margin-top: 1rem;">
                            <i class="fas fa-plus-circle"></i>Tambah Data Pertama
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-luxury">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="20%">Periode</th>
                                    <th width="10%" class="text-center">Bulan/Tahun</th>
                                    <th width="10%" class="text-center">Perempuan</th>
                                    <th width="10%" class="text-center">Laki-Laki</th>
                                    <th width="9%" class="text-center">Total</th>
                                    <th width="12%" class="text-center">Rata² Gaji</th>
                                    <th width="12%" class="text-center">Total Belanja</th>
                                    <th width="8%" class="text-center">Status</th>
                                    <th width="9%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataAnggota as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        <div class="number-box-luxury" style="margin: 0 auto;">
                                            {{ $dataAnggota->firstItem() + $index }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            {{-- <div class="avatar-box-luxury">
                                                {{ substr($item->instansi->nama_instansi, 0, 1) }}
                                            </div> --}}
                                            <div>
                                                <div class="fw-bold" style="font-size: 0.95rem; color: black;">
                                                    {{ $item->instansi->nama_instansi }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                                                        <td class="text-center">
                                        <span class="badge-period-luxury">
                                            {{ $item->bulan }} {{ $item->tahun }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge-gender-female-luxury">
                                            <i class="fas fa-female me-1"></i>
                                            {{ number_format($item->jumlah_perempuan) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge-gender-male-luxury">
                                            <i class="fas fa-male me-1"></i>
                                            {{ number_format($item->jumlah_laki_laki) }}
                                        </span>
                                    </td>

                                    <td class="text-center fw-bold" style="color: black">
                                        {{ number_format($item->jumlah_perempuan + $item->jumlah_laki_laki) }}
                                    </td>

                                    <td class="text-center">
                                        <span class="badge-gaji-luxury">
                                            Rp {{ number_format($item->rata_rata_gaji, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="text-center fw-semibold" style="color: #38ef7d;">
                                        Rp {{ number_format($item->total_belanja, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        @if(\Carbon\Carbon::parse($item->created_at)->diffInDays(now()) <= 30)
                                            <span class="badge-status-recent-luxury">
                                                <i class="fas fa-clock me-1"></i>Terbaru
                                            </span>
                                        @else
                                            <span class="badge-status-old-luxury">
                                                <i class="fas fa-history me-1"></i>Lama
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-action-group-luxury">
                                            <a href="{{ route('data-anggota.edit', $item->id) }}"
                                               class="btn-action-luxury btn-action-edit-luxury"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('data-anggota.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn-action-luxury btn-action-delete-luxury"
                                                        title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="p-4 d-flex justify-content-center">
                        {{ $dataAnggota->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
