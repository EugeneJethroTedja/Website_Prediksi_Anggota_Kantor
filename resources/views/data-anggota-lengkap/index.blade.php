@extends('layouts.app')

@section('title', 'Kelola Data Anggota Lengkap')
@section('page-title', 'Manajemen Data Anggota Lengkap')

@push('styles')
<style>
    /* Modern Card Styling */
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .modern-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    /* Header Gradient */
    .card-header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1.5rem;
    }

    /* Stats Card */
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .stats-icon {
        font-size: 3rem;
        opacity: 0.3;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Filter Section */
    .filter-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border: none;
        border-radius: 16px;
        padding: 1.5rem;
    }

    /* Table Styling */
    .modern-table {
        border-radius: 12px;
        overflow: hidden;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .modern-table thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(90deg, #f8f9ff 0%, #fff 100%);
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    }

    /* Badge Styling */
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Period Avatar */
    .period-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.25rem;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* Button Group Modern */
    .btn-action {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 6rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        opacity: 0.3;
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

    .animate-in {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-in-delay-1 { animation-delay: 0.1s; }
    .animate-in-delay-2 { animation-delay: 0.2s; }
    .animate-in-delay-3 { animation-delay: 0.3s; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Stats Overview --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3 animate-in">
            <div class="stats-card">
                <div style="position: relative; z-index: 1;">
                    <div class="text-white-50 mb-2">Total Data</div>
                    <h2 class="mb-0">{{ $dataAnggota->total() }}</h2>
                    <small>Record tersimpan</small>
                </div>
                <i class="fas fa-database stats-icon"></i>
            </div>
        </div>
        <div class="col-md-3 animate-in animate-in-delay-1">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div style="position: relative; z-index: 1;">
                    <div class="text-white-50 mb-2">Total Anggota</div>
                    <h2 class="mb-0">{{ number_format($dataAnggota->sum('total_anggota')) }}</h2>
                    <small>Orang terdaftar</small>
                </div>
                <i class="fas fa-users stats-icon"></i>
            </div>
        </div>
        <div class="col-md-3 animate-in animate-in-delay-2">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div style="position: relative; z-index: 1;">
                    <div class="text-white-50 mb-2">Laki-laki</div>
                    <h2 class="mb-0">{{ number_format($dataAnggota->sum('total_laki_laki')) }}</h2>
                    <small>Total laki-laki</small>
                </div>
                <i class="fas fa-male stats-icon"></i>
            </div>
        </div>
        <div class="col-md-3 animate-in animate-in-delay-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div style="position: relative; z-index: 1;">
                    <div class="text-white-50 mb-2">Perempuan</div>
                    <h2 class="mb-0">{{ number_format($dataAnggota->sum('total_perempuan')) }}</h2>
                    <small>Total perempuan</small>
                </div>
                <i class="fas fa-female stats-icon"></i>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card modern-card mb-4 animate-in">
        <div class="card-body filter-card">
            <form action="{{ route('data-anggota-lengkap.index') }}" method="GET">
                <div class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt me-2"></i>Periode
                        </label>
                        <select name="periode_id" class="form-select form-select-lg">
                            <option value="">Semua Periode</option>
                            @foreach($periodeList as $p)
                                <option value="{{ $p->id }}" {{ request('periode_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar me-2"></i>Tahun
                        </label>
                        <select name="tahun" class="form-select form-select-lg">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-search me-2"></i>Filter Data
                            </button>
                            <a href="{{ route('data-anggota-lengkap.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-redo me-2"></i>Reset
                            </a>
                            <a href="{{ route('data-anggota-lengkap.create') }}" class="btn btn-success btn-lg px-4 ms-auto">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Main Data Table --}}
    <div class="card modern-card animate-in">
        <div class="card-header-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1"><i class="fas fa-table me-2"></i>Daftar Data Anggota Lengkap</h5>
                    <small class="opacity-75">Kelola dan pantau data anggota dengan mudah</small>
                </div>
                <div class="badge bg-white text-primary px-3 py-2">
                    {{ $dataAnggota->total() }} Data
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-4 border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fs-4"></i>
                        <div>
                            <strong>Berhasil!</strong>
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($dataAnggota->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3 class="mt-4 mb-3">Belum Ada Data</h3>
                    <p class="text-muted mb-4">Mulai tambahkan data anggota lengkap untuk menghasilkan analisis dan prediksi</p>
                    <a href="{{ route('data-anggota-lengkap.create') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Data Pertama
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table modern-table mb-0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="25%">Periode & Waktu</th>
                                <th width="15%" class="text-center">Laki-laki</th>
                                <th width="15%" class="text-center">Perempuan</th>
                                <th width="15%" class="text-center">Total</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataAnggota as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <div class="fw-bold" style="color: #667eea;">
                                        {{ $dataAnggota->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="period-avatar">
                                            {{ substr($item->periode->nama_periode, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold mb-1">{{ $item->periode->nama_periode }}</div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                    <i class="fas fa-calendar me-1"></i>{{ $item->nama_bulan }} {{ $item->tahun }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="badge badge-modern" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                        <i class="fas fa-male me-1"></i>{{ number_format($item->total_laki_laki) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="badge badge-modern" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                        <i class="fas fa-female me-1"></i>{{ number_format($item->total_perempuan) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <div class="fw-bold fs-5" style="color: #667eea;">
                                            {{ number_format($item->total_anggota) }}
                                        </div>
                                        <small class="text-muted">orang</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $bulanSekarang = \Carbon\Carbon::now();
                                        $bulanData = \Carbon\Carbon::create($item->tahun, $item->bulan, 1);
                                        $isRecent = $bulanData->diffInMonths($bulanSekarang) <= 3;
                                    @endphp
                                    @if($isRecent)
                                        <span class="badge badge-modern bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Recent
                                        </span>
                                    @else
                                        <span class="badge badge-modern bg-secondary">
                                            <i class="fas fa-clock me-1"></i>Old
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('data-anggota-lengkap.show', $item) }}" 
                                           class="btn btn-info btn-action" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('data-anggota-lengkap.edit', $item) }}" 
                                           class="btn btn-warning btn-action" 
                                           title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('data-anggota-lengkap.destroy', $item) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-action" 
                                                    title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($dataAnggota->hasPages())
                <div class="p-4 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $dataAnggota->firstItem() }} - {{ $dataAnggota->lastItem() }} 
                            dari {{ $dataAnggota->total() }} data
                        </div>
                        <div>
                            {{ $dataAnggota->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation class to elements
    const elements = document.querySelectorAll('.animate-in');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        setTimeout(() => {
            el.style.opacity = '1';
        }, index * 100);
    });
});
</script>
@endpush