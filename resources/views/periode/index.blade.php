@extends('layouts.app')

@section('title', 'Kelola Periode')
@section('page-title', 'Manajemen Periode')

@push('styles')
<style>
    /* Premium Page Styles */
    .page-premium {
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

    /* Stats Mini Cards */
    .stats-mini-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-mini-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .stat-mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-mini-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .stat-mini-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .stat-mini-card.primary .stat-mini-value {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-mini-card.success .stat-mini-value {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-mini-card.info .stat-mini-value {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Main Card Premium */
    .main-card-premium {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .main-card-premium .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
        border: none;
        padding: 1.5rem 2rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .card-title-premium {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0;
    }

    /* Button Premium */
    .btn-premium {
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-premium-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }

    .btn-premium-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(17, 153, 142, 0.5);
        color: white;
    }

    /* Avatar & Badges */
    .avatar-box {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .number-box {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .badge-period-range {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(23, 162, 184, 0.1) 100%);
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        font-weight: 600;
        color: #17a2b8;
        display: inline-block;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .badge-data-count {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.15) 100%);
        padding: 0.6rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        color: #11998e;
        display: inline-block;
        font-size: 0.9rem;
    }

    .badge-status-active {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.15) 100%);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        color: #11998e;
        display: inline-block;
        font-size: 0.85rem;
    }

    .badge-status-inactive {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.15) 0%, rgba(108, 117, 125, 0.1) 100%);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        color: #6c757d;
        display: inline-block;
        font-size: 0.85rem;
    }

    /* Table Premium */
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
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border: none;
    }

    /* Action Buttons */
    .btn-action-group {
        display: inline-flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-action-view {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(23, 162, 184, 0.1) 100%);
        color: #17a2b8;
    }

    .btn-action-view:hover {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
    }

    .btn-action-edit {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 193, 7, 0.1) 100%);
        color: #ffc107;
    }

    .btn-action-edit:hover {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    .btn-action-delete {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15) 0%, rgba(220, 53, 69, 0.1) 100%);
        color: #dc3545;
    }

    .btn-action-delete:hover {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        font-size: 6rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0.3;
        margin-bottom: 1.5rem;
    }

    .empty-state-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 0.75rem;
    }

    .empty-state-text {
        color: #6c757d;
        font-size: 1.05rem;
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
    }

    .pagination .page-link {
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        color: #667eea;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    @media (max-width: 1200px) {
        .stats-mini-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-mini-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="page-premium">
    <div class="container-fluid">
        
        {{-- Header Premium --}}
        <div class="header-card-premium fade-in-up">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>
                        <i class="fas fa-calendar-alt me-3"></i>Manajemen Periode
                    </h1>
                    <p>Kelola periode dan rentang waktu untuk kategori data</p>
                </div>
                <a href="{{ route('periode.create') }}" class="btn-premium btn-premium-success">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Periode Baru
                </a>
            </div>
        </div>

        {{-- Stats Mini Cards --}}
        @if(!$periode->isEmpty())
        <div class="stats-mini-grid fade-in-up" style="animation-delay: 0.1s">
            <div class="stat-mini-card primary">
                <div class="stat-mini-label">
                    <i class="fas fa-calendar-alt me-1"></i>Total Periode
                </div>
                <div class="stat-mini-value">{{ $periode->total() }}</div>
            </div>
            <div class="stat-mini-card success">
                <div class="stat-mini-label">
                    <i class="fas fa-check-circle me-1"></i>Periode Aktif
                </div>
                <div class="stat-mini-value">{{ $periode->where('is_active', true)->count() }}</div>
            </div>
            <div class="stat-mini-card info">
                <div class="stat-mini-label">
                    <i class="fas fa-database me-1"></i>Total Data
                </div>
                <div class="stat-mini-value">{{ $periode->sum('data_anggota_lengkap_count') }}</div>
            </div>
        </div>
        @endif

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="alert fade-in-up" style="background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(17, 153, 142, 0.05) 100%); border: 2px solid #11998e; border-radius: 16px; padding: 1.25rem; animation-delay: 0.2s; margin-bottom: 2rem;">
            <div class="d-flex align-items-center">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                    <i class="fas fa-check-circle" style="color: white; font-size: 1.2rem;"></i>
                </div>
                <div class="flex-grow-1">
                    <strong style="color: #11998e;">Berhasil!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        {{-- Main Table Card --}}
        <div class="main-card-premium fade-in-up" style="animation-delay: 0.3s">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title-premium">
                        <i class="fas fa-list me-2"></i>Daftar Periode
                    </h3>
                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 1.25rem; border-radius: 50px; font-size: 0.9rem;">
                        {{ $periode->total() }} Periode
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($periode->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="empty-state-title">Belum Ada Periode</h3>
                        <p class="empty-state-text">Mulai dengan menambahkan periode pertama untuk mengelompokkan data</p>
                        <a href="{{ route('periode.create') }}" class="btn-premium btn-premium-success">
                            <i class="fas fa-plus-circle"></i>Tambah Periode Pertama
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="25%">Nama Periode</th>
                                    <th width="12%" class="text-center">Jumlah Data</th>
                                    <th width="20%">Keterangan</th>
                                    <th width="8%" class="text-center">Status</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($periode as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        <div class="number-box" style="margin: 0 auto;">
                                            {{ $periode->firstItem() + $index }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-box" style="margin-right: 1rem;">
                                                {{ substr($item->nama_periode, 0, 1) }}
                                            </div>
                                            <div style="flex: 1; min-width: 0;">
                                                <div class="fw-bold" style="font-size: 0.95rem; color: #1a1d2e; line-height: 1.3;">
                                                    {{ $item->nama_periode }}
                                                </div>
                                                <small style="color: #6c757d; font-size: 0.8rem;">
                                                    <i class="fas fa-clock me-1"></i>{{ $item->total_bulan ?? 0 }} bulan
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-data-count">
                                            <i class="fas fa-database me-1"></i>{{ $item->data_anggota_lengkap_count ?? 0 }} data
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->keterangan)
                                            <span style="color: #6c757d; font-size: 0.9rem; line-height: 1.5;">
                                                {{ Str::limit($item->keterangan, 60) }}
                                            </span>
                                        @else
                                            <span style="color: #adb5bd; font-style: italic; font-size: 0.9rem;">
                                                Tidak ada keterangan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge-status-active">
                                                <i class="fas fa-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge-status-inactive">
                                                <i class="fas fa-times-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-action-group">
                                            <a href="{{ route('periode.show', $item) }}" 
                                               class="btn-action btn-action-view" 
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('periode.edit', $item) }}" 
                                               class="btn-action btn-action-edit" 
                                               title="Edit Periode">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('periode.destroy', $item) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('⚠️ Yakin ingin menghapus periode ini?\n\nPeriode: {{ $item->nama_periode }}\nJumlah Data: {{ $item->data_anggota_lengkap_count ?? 0 }} data\n\n⚠️ PERINGATAN: Semua data terkait akan ikut terhapus dan tidak dapat dikembalikan!')">
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
                    @if($periode->hasPages())
                    <div class="d-flex justify-content-center p-4">
                        {{ $periode->links() }}
                    </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>
@endsection