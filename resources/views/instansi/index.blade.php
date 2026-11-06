@extends('layouts.app')

@section('title', 'Kelola Periode')
@section('page-title', 'Manajemen Periode')

@push('styles')
<style>
    /* Dashboard Luxury Base */
    .dashboard-luxury {
        background: var(--color-bg-primary);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Header Card Luxury */
    .header-card-luxury {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
        backdrop-filter: blur(10px);
    }

    .header-card-luxury .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-card-luxury h1 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Space Grotesk', sans-serif;
    }

    .header-card-luxury p {
        margin: 0;
        color: var(--color-text-secondary);
        font-size: 1.05rem;
    }

    /* Stats Grid Luxury */
    .stats-grid-luxury {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
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

    /* Search Card Luxury */
    .search-card-luxury {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(35, 41, 70, 0.9) 100%);
        border: 1px solid var(--color-border);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    }

    .search-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .search-input-luxury {
        border-radius: 12px;
        border: 2px solid rgba(102, 126, 234, 0.3);
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(35, 41, 70, 0.6);
        color: var(--color-text-primary);
    }

    .search-input-luxury:focus {
        border-color: rgba(102, 126, 234, 0.8);
        background: rgba(35, 41, 70, 0.8);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        outline: none;
        color: var(--color-text-primary);
    }

    /* Table Card Luxury */
    .table-card-luxury {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(35, 41, 70, 0.9) 100%);
        border: 1px solid var(--color-border);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .table-card-luxury .card-header {
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
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1rem;
    }

    .btn-luxury-primary {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        height: 48px;
    }

    .btn-luxury-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-luxury-success {
        background: var(--gradient-success);
        color: white;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }

    .btn-luxury-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(17, 153, 142, 0.5);
        color: white;
    }

    .btn-luxury-secondary {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.2) 0%, rgba(136, 146, 176, 0.2) 100%);
        border: 1px solid var(--color-border);
        color: var(--color-text-secondary);
        height: 48px;
        width: 48px;
        padding: 0;
        justify-content: center;
    }

    .btn-luxury-secondary:hover {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.3) 0%, rgba(136, 146, 176, 0.3) 100%);
        border-color: var(--color-border-light);
        color: var(--color-text-primary);
        transform: rotate(180deg) scale(1.1);
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
        width: 40px;
        height: 40px;
        background: var(--gradient-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.95rem;
        margin: 0 auto;
    }

    .badge-data-count-luxury {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.1) 100%);
        border: 1px solid rgba(79, 172, 254, 0.4);
        padding: 0.6rem 1.1rem;
        border-radius: 10px;
        font-weight: 600;
        color: #00f2fe;
        display: inline-block;
        font-size: 0.9rem;
    }

    .badge-total-luxury {
        background: var(--gradient-primary);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
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
    .btn-action-group {
        display: inline-flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-action-edit {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%);
        color: #f093fb;
        border: 1px solid rgba(240, 147, 251, 0.3);
    }

    .btn-action-edit:hover {
        background: var(--gradient-warning);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
    }

    .btn-action-delete {
        background: linear-gradient(135deg, rgba(238, 9, 121, 0.15) 0%, rgba(255, 106, 0, 0.1) 100%);
        color: #ff6a00;
        border: 1px solid rgba(238, 9, 121, 0.3);
    }

    .btn-action-delete:hover {
        background: var(--gradient-danger);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(238, 9, 121, 0.4);
    }

    /* Empty State */
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
        font-family: 'Space Grotesk', sans-serif;
    }

    .no-data-text-luxury {
        color: var(--color-text-tertiary);
        font-size: 0.95rem;
        margin-bottom: 2rem;
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

    /* Pagination */
    .pagination {
        gap: 0.5rem;
        margin: 0;
    }

    .pagination .page-link {
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        background: rgba(35, 41, 70, 0.6);
        color: #667eea;
        font-weight: 600;
        transition: all 0.3s ease;
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

    .pagination .page-item.disabled .page-link {
        background: rgba(35, 41, 70, 0.3);
        color: var(--color-text-tertiary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-card-luxury h1 {
            font-size: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .btn-luxury {
            width: 100%;
            justify-content: center;
        }

        .btn-luxury-secondary {
            width: 48px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-luxury">
    <div class="container-fluid">
        
        {{-- Header Luxury --}}
        <div class="header-card-luxury fade-in-up">
            <div class="header-content">
                <div>
                    <h1>
                        <i class="fas fa-building me-3"></i>Manajemen Periode
                    </h1>
                    <p>Kelola daftar periode yang terdaftar dalam sistem</p>
                </div>
                <a href="{{ route('instansi.create') }}" class="btn-luxury btn-luxury-success">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Periode Baru
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        @if(!$instansi->isEmpty())
        <div class="stats-grid-luxury fade-in-up" style="animation-delay: 0.1s">
            <div class="stat-card-luxury gradient-primary">
                <div class="stat-icon-luxury">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-label-luxury">Total Periode</div>
                <div class="stat-value-luxury">{{ $instansi->total() }}</div>
                <div class="stat-detail-luxury">Periode Terdaftar</div>
            </div>
            
            <div class="stat-card-luxury gradient-success">
                <div class="stat-icon-luxury">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-label-luxury">Periode Aktif</div>
                <div class="stat-value-luxury">{{ $instansi->where('data_anggota_count', '>', 0)->count() }}</div>
                <div class="stat-detail-luxury">Memiliki Data</div>
            </div>
            
            <div class="stat-card-luxury gradient-info">
                <div class="stat-icon-luxury">
                    <i class="fas fa-database"></i>
                </div>
                <div class="stat-label-luxury">Total Data</div>
                <div class="stat-value-luxury">{{ number_format($instansi->sum('data_anggota_count')) }}</div>
                <div class="stat-detail-luxury">Data Anggota</div>
            </div>
        </div>
        @endif

        {{-- Search Card --}}
        <div class="search-card-luxury fade-in-up" style="animation-delay: 0.2s">
            <div class="search-title">
                <i class="fas fa-search me-2"></i>Pencarian
            </div>
            <form action="{{ route('instansi.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-lg-10 col-md-9">
                        <input type="text" 
                               name="search" 
                               class="form-control search-input-luxury" 
                               placeholder="Cari periode..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 d-flex gap-2">
                        <button type="submit" class="btn-luxury btn-luxury-primary flex-grow-1">
                            <i class="fas fa-search"></i>Cari
                        </button>
                        <a href="{{ route('instansi.index') }}" 
                           class="btn-luxury btn-luxury-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table Card --}}
        <div class="table-card-luxury fade-in-up" style="animation-delay: 0.3s">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="card-title-luxury">
                        <i class="fas fa-list me-2"></i>Daftar Periode
                    </h3>
                    <span class="badge-total-luxury">
                        {{ $instansi->total() }} Periode
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($instansi->isEmpty())
                    <div class="no-data-state-luxury">
                        <div class="no-data-icon-luxury">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 class="no-data-title-luxury">Belum Ada Periode</h3>
                        <p class="no-data-text-luxury">Mulai dengan menambahkan periode pertama Anda untuk memulai sistem prediksi</p>
                        <a href="{{ route('instansi.create') }}" class="btn-luxury btn-luxury-success">
                            <i class="fas fa-plus-circle"></i>Tambah Periode Pertama
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-luxury">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="35%">Periode</th>
                                    <th width="40%">Keterangan</th>
                                    <th width="12%" class="text-center">Jumlah Data</th>
                                    <th width="8%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($instansi as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        <div class="number-box-luxury">
                                            {{ $instansi->firstItem() + $index }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            {{-- <div class="avatar-box-luxury">
                                                {{ substr($item->nama_instansi, 0, 1) }}
                                            </div> --}}
                                            <div style="flex: 1; min-width: 0;">
                                                <div class="fw-bold" style="font-size: 0.95rem; color: black; line-height: 1.3;">
                                                    {{ $item->nama_instansi }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->keterangan)
                                            <span style="color: black; font-size: 0.9rem; line-height: 1.5;">
                                                {{ Str::limit($item->keterangan, 80) }}
                                            </span>
                                        @else
                                            <span style="color: black; font-style: italic; font-size: 0.9rem;">
                                                Tidak ada keterangan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-data-count-luxury">
                                            <i class="fas fa-database me-1"></i>{{ $item->data_anggota_count }} data
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-action-group">
                                            <a href="{{ route('instansi.edit', $item) }}" 
                                               class="btn-action btn-action-edit" 
                                               title="Edit Periode">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('instansi.destroy', $item) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('⚠️ Yakin ingin menghapus periode ini?\n\nPeriode: {{ $item->nama_instansi }}\nJumlah Data: {{ $item->data_anggota_count }} data\n\n⚠️ PERINGATAN: Semua data historis terkait akan ikut terhapus dan tidak dapat dikembalikan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-action btn-action-delete" 
                                                        title="Hapus Periode">
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
                    @if($instansi->hasPages())
                    <div class="p-4 d-flex justify-content-center">
                        {{ $instansi->withQueryString()->links() }}
                    </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>
@endsection