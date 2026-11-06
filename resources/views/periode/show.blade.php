@extends('layouts.app')

@section('title', 'Detail Periode')
@section('page-title', 'Detail Periode')

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

    /* Info Card Premium */
    .info-card-premium {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .info-card-premium .card-header {
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

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        padding: 2rem;
    }

    .info-item {
        text-align: center;
    }

    .info-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .info-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1d2e;
        margin-bottom: 0.5rem;
    }

    .info-badge {
        display: inline-block;
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .info-badge.success {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.15) 100%);
        color: #11998e;
    }

    .info-badge.secondary {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.15) 0%, rgba(108, 117, 125, 0.1) 100%);
        color: #6c757d;
    }

    .info-badge.info {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(23, 162, 184, 0.1) 100%);
        color: #17a2b8;
    }

    /* Stats Card */
    .stats-card-premium {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .stats-card-premium .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
        border: none;
        padding: 1.5rem 2rem;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .badge-count {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
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

    /* Number Box */
    .number-box {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Badge Styles */
    .badge-period {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(23, 162, 184, 0.1) 100%);
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        font-weight: 600;
        color: #17a2b8;
        display: inline-block;
        font-size: 0.85rem;
    }

    .badge-gender-male {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.1) 100%);
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        font-weight: 600;
        color: #667eea;
        display: inline-block;
    }

    .badge-gender-female {
        background: linear-gradient(135deg, rgba(245, 87, 108, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%);
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        font-weight: 600;
        color: #f5576c;
        display: inline-block;
    }

    .badge-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 193, 7, 0.1) 100%);
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        font-weight: 600;
        color: #ffc107;
        display: inline-block;
    }

    .badge-success-premium {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.15) 100%);
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        font-weight: 600;
        color: #11998e;
        display: inline-block;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state-icon {
        font-size: 4rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state-text {
        color: #6c757d;
        font-size: 1rem;
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

    .btn-premium-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
    }

    .btn-premium-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(255, 193, 7, 0.5);
        color: white;
    }

    .btn-premium-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
    }

    .btn-premium-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(108, 117, 125, 0.5);
        color: white;
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

    @media (max-width: 768px) {
        .info-grid {
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
                        <i class="fas fa-info-circle me-3"></i>Detail Periode
                    </h1>
                    <p>Informasi lengkap tentang periode dan data terkait</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('periode.edit', $periode) }}" class="btn-premium btn-premium-warning">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a href="{{ route('periode.index') }}" class="btn-premium btn-premium-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- Info Card Premium --}}
        <div class="info-card-premium fade-in-up" style="animation-delay: 0.1s">
            <div class="card-header">
                <h3 class="card-title-premium">
                    <i class="fas fa-calendar-alt me-2"></i>Informasi Periode
                </h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-tag me-1"></i>Nama Periode
                    </div>
                    <div class="info-value">{{ $periode->nama_periode }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-toggle-on me-1"></i>Status
                    </div>
                    <div>
                        @if($periode->is_active)
                            <span class="info-badge success">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </span>
                        @else
                            <span class="info-badge secondary">
                                <i class="fas fa-times-circle me-1"></i>Inactive
                            </span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-clock me-1"></i>Total Bulan
                    </div>
                    <div class="info-value">{{ $periode->total_bulan ?? 0 }}</div>
                </div>
            </div>
            
            @if($periode->keterangan)
            <div style="padding: 0 2rem 2rem 2rem;">
                <div style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(245, 87, 108, 0.05) 100%); border-radius: 12px; padding: 1.25rem;">
                    <div class="info-label text-start mb-2">
                        <i class="fas fa-align-left me-1"></i>Keterangan
                    </div>
                    <p style="color: #1a1d2e; margin: 0; line-height: 1.6;">{{ $periode->keterangan }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Data Anggota Lengkap --}}
        <div class="stats-card-premium fade-in-up" style="animation-delay: 0.2s">
            <div class="card-header">
                <h3 class="card-title-premium">
                    <i class="fas fa-database me-2"></i>Data Anggota Lengkap
                </h3>
                <span class="badge-count">{{ $periode->dataAnggotaLengkap->count() }} Data</span>
            </div>
            <div class="card-body p-0">
                @if($periode->dataAnggotaLengkap->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <p class="empty-state-text">Belum ada data anggota untuk periode ini</p>
                        <a href="{{ route('data-anggota-lengkap.create') }}" class="btn-premium btn-premium-warning mt-3">
                            <i class="fas fa-plus-circle"></i>Tambah Data
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="8%" class="text-center">No</th>
                                    <th width="20%">Bulan/Tahun</th>
                                    <th width="18%" class="text-center">Total Laki-laki</th>
                                    <th width="18%" class="text-center">Total Perempuan</th>
                                    <th width="18%" class="text-center">Total Anggota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($periode->dataAnggotaLengkap->sortByDesc('tahun')->sortByDesc('bulan') as $index => $data)
                                <tr>
                                    <td class="text-center">
                                        <div class="number-box">{{ $index + 1 }}</div>
                                    </td>
                                    <td>
                                        <span class="badge-period">
                                            <i class="fas fa-calendar me-1"></i>{{ $data->nama_bulan }} {{ $data->tahun }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-gender-male">
                                            <i class="fas fa-male me-1"></i>{{ number_format($data->total_laki_laki) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-gender-female">
                                            <i class="fas fa-female me-1"></i>{{ number_format($data->total_perempuan) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong style="font-size: 1.1rem; color: #1a1d2e;">{{ number_format($data->total_anggota) }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Prediksi Lengkap --}}
        <div class="stats-card-premium fade-in-up" style="animation-delay: 0.3s">
            <div class="card-header">
                <h3 class="card-title-premium">
                    <i class="fas fa-chart-line me-2"></i>Prediksi Lengkap
                </h3>
                <span class="badge-count">{{ $periode->prediksiLengkap->count() }} Prediksi</span>
            </div>
            <div class="card-body p-0">
                @if($periode->prediksiLengkap->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <p class="empty-state-text">Belum ada prediksi untuk periode ini</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-premium">
                            <thead>
                                <tr>
                                    <th width="8%" class="text-center">No</th>
                                    <th width="18%">Bulan/Tahun</th>
                                    <th width="16%" class="text-center">Pred. Laki-laki</th>
                                    <th width="16%" class="text-center">Pred. Perempuan</th>
                                    <th width="16%" class="text-center">Total Prediksi</th>
                                    <th width="14%" class="text-center">Confidence</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($periode->prediksiLengkap->sortByDesc('tahun')->sortByDesc('bulan') as $index => $pred)
                                <tr>
                                    <td class="text-center">
                                        <div class="number-box">{{ $index + 1 }}</div>
                                    </td>
                                    <td>
                                        <span class="badge-warning">
                                            <i class="fas fa-calendar-alt me-1"></i>{{ $pred->nama_bulan }} {{ $pred->tahun }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-gender-male">
                                            <i class="fas fa-male me-1"></i>{{ number_format($pred->total_prediksi_laki_laki) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-gender-female">
                                            <i class="fas fa-female me-1"></i>{{ number_format($pred->total_prediksi_perempuan) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong style="font-size: 1.1rem; color: #1a1d2e;">{{ number_format($pred->total_prediksi) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-success-premium">
                                            <i class="fas fa-check-circle me-1"></i>{{ number_format($pred->confidence_score, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection