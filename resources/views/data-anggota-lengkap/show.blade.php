@extends('layouts.app')

@section('title', 'Detail Data Anggota Lengkap')
@section('page-title', 'Detail Data Anggota Lengkap')

@push('styles')
<style>
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

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

    .stat-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }

    .stat-card-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 1rem 0;
    }

    .stat-icon {
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 4rem;
        opacity: 0.2;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Info Header --}}
    <div class="card mb-4 fade-in-up">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi Data</strong>
            </div>
            <div>
                <a href="{{ route('data-anggota-lengkap.edit', $dataAnggotaLengkap) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
                <a href="{{ route('data-anggota-lengkap.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="fw-bold text-muted small">Periode</label>
                    <div class="fs-5">{{ $dataAnggotaLengkap->periode->nama_periode }}</div>
                    <small class="text-muted">{{ $dataAnggotaLengkap->periode->periode_format }}</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold text-muted small">Bulan/Tahun Data</label>
                    <div>
                        <span class="badge bg-info text-white" style="font-size: 1.2rem; padding: 10px 20px;">
                            <i class="fas fa-calendar me-2"></i>{{ $dataAnggotaLengkap->nama_bulan }} {{ $dataAnggotaLengkap->tahun }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold text-muted small">Total Keseluruhan</label>
                    <div class="fs-3 fw-bold text-primary">{{ number_format($dataAnggotaLengkap->total_anggota) }} <small>orang</small></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card stat-card stat-card-primary fade-in-up" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="stat-label">Total Laki-Laki</div>
                    <div class="stat-value">{{ number_format($dataAnggotaLengkap->total_laki_laki) }}</div>
                    <div class="text-white-50 small">{{ $dataAnggotaLengkap->total_anggota > 0 ? number_format(($dataAnggotaLengkap->total_laki_laki / $dataAnggotaLengkap->total_anggota) * 100, 1) : 0 }}% dari total</div>
                    <i class="fas fa-male stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card stat-card-danger fade-in-up" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="stat-label">Total Perempuan</div>
                    <div class="stat-value">{{ number_format($dataAnggotaLengkap->total_perempuan) }}</div>
                    <div class="text-white-50 small">{{ $dataAnggotaLengkap->total_anggota > 0 ? number_format(($dataAnggotaLengkap->total_perempuan / $dataAnggotaLengkap->total_anggota) * 100, 1) : 0 }}% dari total</div>
                    <i class="fas fa-female stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Data PENDIDIKAN --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 0.3s">
        <div class="card-header">
            <i class="fas fa-graduation-cap me-2"></i>
            <strong>Data Pendidikan (10 Kategori)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="30%">Tingkat Pendidikan</th>
                            <th width="20%" class="text-center">Laki-laki</th>
                            <th width="20%" class="text-center">Perempuan</th>
                            <th width="15%" class="text-center">Total</th>
                            <th width="15%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataPendidikan as $label => $data)
                        <tr>
                            <td><strong>{{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ number_format($data['laki']) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ number_format($data['perempuan']) }}</span>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($data['laki'] + $data['perempuan']) }}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_anggota > 0 ? number_format((($data['laki'] + $data['perempuan']) / $dataAnggotaLengkap->total_anggota) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-primary" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_laki_laki) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-danger" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_perempuan) }}</span>
                            </th>
                            <th class="text-center">
                                <strong style="font-size: 1.1rem;">{{ number_format($dataAnggotaLengkap->total_anggota) }}</strong>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Data GOLONGAN (UPDATED: 29 Kategori) --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 0.4s">
        <div class="card-header">
            <i class="fas fa-layer-group me-2"></i>
            <strong>Data Golongan (29 Kategori - I/A sampai IV/E + I sampai XII)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="30%">Golongan</th>
                            <th width="20%" class="text-center">Laki-laki</th>
                            <th width="20%" class="text-center">Perempuan</th>
                            <th width="15%" class="text-center">Total</th>
                            <th width="15%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataGolongan as $label => $data)
                        <tr>
                            <td><strong>{{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ number_format($data['laki']) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ number_format($data['perempuan']) }}</span>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($data['laki'] + $data['perempuan']) }}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_anggota > 0 ? number_format((($data['laki'] + $data['perempuan']) / $dataAnggotaLengkap->total_anggota) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-primary" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_golongan_laki) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-danger" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_golongan_perempuan) }}</span>
                            </th>
                            <th class="text-center">
                                <strong style="font-size: 1.1rem;">{{ number_format($dataAnggotaLengkap->total_golongan_laki + $dataAnggotaLengkap->total_golongan_perempuan) }}</strong>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Data JABATAN --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 0.5s">
        <div class="card-header">
            <i class="fas fa-briefcase me-2"></i>
            <strong>Data Jabatan Eselon (7 Kategori)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="30%">Jabatan Eselon</th>
                            <th width="20%" class="text-center">Laki-laki</th>
                            <th width="20%" class="text-center">Perempuan</th>
                            <th width="15%" class="text-center">Total</th>
                            <th width="15%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataJabatan as $label => $data)
                        <tr>
                            <td><strong>Eselon {{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ number_format($data['laki']) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ number_format($data['perempuan']) }}</span>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($data['laki'] + $data['perempuan']) }}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_anggota > 0 ? number_format((($data['laki'] + $data['perempuan']) / $dataAnggotaLengkap->total_anggota) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-primary" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_jabatan_laki) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-danger" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_jabatan_perempuan) }}</span>
                            </th>
                            <th class="text-center">
                                <strong style="font-size: 1.1rem;">{{ number_format($dataAnggotaLengkap->total_jabatan_laki + $dataAnggotaLengkap->total_jabatan_perempuan) }}</strong>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Data AGAMA --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 0.6s">
        <div class="card-header">
            <i class="fas fa-pray me-2"></i>
            <strong>Data Agama (5 Kategori)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="30%">Agama</th>
                            <th width="20%" class="text-center">Laki-laki</th>
                            <th width="20%" class="text-center">Perempuan</th>
                            <th width="15%" class="text-center">Total</th>
                            <th width="15%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataAgama as $label => $data)
                        <tr>
                            <td><strong>{{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ number_format($data['laki']) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ number_format($data['perempuan']) }}</span>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($data['laki'] + $data['perempuan']) }}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_anggota > 0 ? number_format((($data['laki'] + $data['perempuan']) / $dataAnggotaLengkap->total_anggota) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-primary" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_agama_laki) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-danger" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_agama_perempuan) }}</span>
                            </th>
                            <th class="text-center">
                                <strong style="font-size: 1.1rem;">{{ number_format($dataAnggotaLengkap->total_agama_laki + $dataAnggotaLengkap->total_agama_perempuan) }}</strong>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Data JF TERTENTU PNS --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 0.7s">
        <div class="card-header">
            <i class="fas fa-user-tie me-2"></i>
            <strong>Data JF Tertentu PNS (4 Kategori)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="50%">Kategori JF Tertentu PNS</th>
                            <th width="30%" class="text-center">Total</th>
                            <th width="20%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataJfTertentuPns as $label => $total)
                        <tr>
                            <td><strong>JF Tertentu PNS {{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ number_format($total) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_jf_tertentu_pns > 0 ? number_format(($total / $dataAnggotaLengkap->total_jf_tertentu_pns) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_jf_tertentu_pns) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Data JF TERTENTU PPPK --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 0.8s">
        <div class="card-header">
            <i class="fas fa-user-tie me-2"></i>
            <strong>Data JF Tertentu PPPK (5 Kategori)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="50%">Kategori JF Tertentu PPPK</th>
                            <th width="30%" class="text-center">Total</th>
                            <th width="20%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataJfTertentuPppk as $label => $total)
                        <tr>
                            <td><strong>JF Tertentu PPPK {{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ number_format($total) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_jf_tertentu_pppk > 0 ? number_format(($total / $dataAnggotaLengkap->total_jf_tertentu_pppk) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_jf_tertentu_pppk) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Data JF PELAKSANA PNS --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 0.9s">
        <div class="card-header">
            <i class="fas fa-user-cog me-2"></i>
            <strong>Data JF Pelaksana PNS (4 Kategori)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="50%">Kategori JF Pelaksana PNS</th>
                            <th width="30%" class="text-center">Total</th>
                            <th width="20%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataJfPelaksanaPns as $label => $total)
                        <tr>
                            <td><strong>JF Pelaksana PNS {{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ number_format($total) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_jf_pelaksana_pns > 0 ? number_format(($total / $dataAnggotaLengkap->total_jf_pelaksana_pns) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_jf_pelaksana_pns) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Data JF PELAKSANA PPPK --}}
    <div class="card mb-4 fade-in-up" style="animation-delay: 1s">
        <div class="card-header">
            <i class="fas fa-user-cog me-2"></i>
            <strong>Data JF Pelaksana PPPK (6 Kategori)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="50%">Kategori JF Pelaksana PPPK</th>
                            <th width="30%" class="text-center">Total</th>
                            <th width="20%" class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataJfPelaksanaPppk as $label => $total)
                        <tr>
                            <td><strong>JF Pelaksana PPPK {{ $label }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ number_format($total) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $dataAnggotaLengkap->total_jf_pelaksana_pppk > 0 ? number_format(($total / $dataAnggotaLengkap->total_jf_pelaksana_pppk) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">{{ number_format($dataAnggotaLengkap->total_jf_pelaksana_pppk) }}</span>
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success" style="font-size: 1rem;">100%</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection