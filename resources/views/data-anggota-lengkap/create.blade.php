@extends('layouts.app')

@section('title', 'Tambah Data Anggota Lengkap')
@section('page-title', 'Input Data Anggota Lengkap')

@push('styles')
<style>
    .wizard-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 12px 45px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
        margin-bottom: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .wizard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .wizard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2.5rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .wizard-header::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -15%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.1; }
        50% { transform: scale(1.1); opacity: 0.15; }
    }

    .wizard-header h4 {
        position: relative;
        z-index: 1;
        margin: 0;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .wizard-header p {
        position: relative;
        z-index: 1;
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    .section-indicator {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        margin-right: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 1;
    }

    .category-badge {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.75rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    .input-group-modern {
        margin-bottom: 1.5rem;
    }

    .input-group-modern label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .input-group-modern label i {
        margin-right: 0.75rem;
        color: #667eea;
        font-size: 1.1rem;
    }

    .form-control-modern,
    .form-select-modern {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        background: white;
        outline: none;
    }

    .data-table-modern {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
    }

    .data-table-modern thead {
        background: linear-gradient(135deg, #f5f7fa 0%, #e3e7f0 100%);
    }

    .data-table-modern thead th {
        padding: 1.25rem 1rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.8px;
        border: none;
        color: #2d3748;
    }

    .data-table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .data-table-modern tbody tr:hover {
        background: linear-gradient(90deg, #f8f9ff 0%, #ffffff 100%);
    }

    .data-table-modern tbody td strong {
        color: #2d3748;
        font-size: 0.95rem;
    }

    .data-table-modern input[type="number"] {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        text-align: center;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
    }

    .data-table-modern input[type="number"]:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        outline: none;
        transform: scale(1.02);
    }

    .btn-modern {
        padding: 0.875rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-modern:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-success-gradient {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .btn-warning-gradient {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .slide-in {
        animation: slideInUp 0.6s ease-out backwards;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }
    .delay-7 { animation-delay: 0.7s; }
    .delay-8 { animation-delay: 0.8s; }
    .delay-9 { animation-delay: 0.9s; }

    .progress-dots {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .progress-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .progress-dot.active {
        background: white;
        width: 30px;
        border-radius: 5px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <form action="{{ route('data-anggota-lengkap.store') }}" method="POST" id="formDataAnggota">
        @csrf
        
        {{-- SECTION 1: Info Dasar --}}
        <div class="wizard-card slide-in">
            <div class="wizard-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">1</span>
                        <div>
                            <h4 class="mb-1">Informasi Dasar</h4>
                            <p class="mb-0 small">Pilih periode, bulan, dan tahun data anggota</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-info-circle me-2"></i>Step 1 of 9
                    </div>
                </div>
                <div class="progress-dots mt-3">
                    <div class="progress-dot active"></div>
                    <div class="progress-dot"></div>
                    <div class="progress-dot"></div>
                    <div class="progress-dot"></div>
                    <div class="progress-dot"></div>
                    <div class="progress-dot"></div>
                    <div class="progress-dot"></div>
                    <div class="progress-dot"></div>
                    <div class="progress-dot"></div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="input-group-modern">
                            <label>
                                <i class="fas fa-calendar-alt"></i>
                                Periode <span class="text-danger">*</span>
                            </label>
                            <select name="periode_id" class="form-select form-select-modern @error('periode_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periode as $p)
                                    <option value="{{ $p->id }}" {{ old('periode_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_periode }} ({{ $p->periode_format }})
                                    </option>
                                @endforeach
                            </select>
                            @error('periode_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="input-group-modern">
                            <label>
                                <i class="fas fa-calendar"></i>
                                Bulan <span class="text-danger">*</span>
                            </label>
                            <select name="bulan" class="form-select form-select-modern @error('bulan') is-invalid @enderror" required>
                                <option value="">-- Pilih Bulan --</option>
                                @foreach($bulanList as $key => $bulan)
                                    <option value="{{ $key }}" {{ old('bulan') == $key ? 'selected' : '' }}>
                                        {{ $bulan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="input-group-modern">
                            <label>
                                <i class="fas fa-calendar-day"></i>
                                Tahun <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="tahun" class="form-control form-control-modern @error('tahun') is-invalid @enderror" 
                                   value="{{ old('tahun', date('Y')) }}" min="2000" max="2100" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: PENDIDIKAN (UPDATED: tambah S3) --}}
        <div class="wizard-card slide-in delay-1">
            <div class="wizard-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">2</span>
                        <div>
                            <h4 class="mb-1">Data Pendidikan</h4>
                            <p class="mb-0 small">Input jumlah anggota berdasarkan tingkat pendidikan (termasuk S3)</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-graduation-cap me-2"></i>10 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="40%">Tingkat Pendidikan</th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-male text-primary me-2"></i>Jumlah Laki-laki
                                </th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-female text-danger me-2"></i>Jumlah Perempuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendidikanList as $pend)
                            <tr>
                                <td><strong>{{ $pend }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="pend_{{ strtolower($pend) }}_laki" 
                                           value="{{ old('pend_' . strtolower($pend) . '_laki', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                                <td>
                                    <input type="number" 
                                           name="pend_{{ strtolower($pend) }}_perempuan" 
                                           value="{{ old('pend_' . strtolower($pend) . '_perempuan', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 3: GOLONGAN (UPDATED: lengkap dengan I-XII) --}}
        <div class="wizard-card slide-in delay-2">
            <div class="wizard-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">3</span>
                        <div>
                            <h4 class="mb-1">Data Golongan</h4>
                            <p class="mb-0 small">Input jumlah anggota berdasarkan golongan kepangkatan (lengkap I/A-IV/E dan I-XII)</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-layer-group me-2"></i>29 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="40%">Golongan</th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-male text-primary me-2"></i>Jumlah Laki-laki
                                </th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-female text-danger me-2"></i>Jumlah Perempuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($golonganList as $gol)
                            @php
                                $golField = strtolower(str_replace('/', '', $gol));
                            @endphp
                            <tr>
                                <td><strong>{{ $gol }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="gol_{{ $golField }}_laki" 
                                           value="{{ old('gol_' . $golField . '_laki', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                                <td>
                                    <input type="number" 
                                           name="gol_{{ $golField }}_perempuan" 
                                           value="{{ old('gol_' . $golField . '_perempuan', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 4: JABATAN ESELON --}}
        <div class="wizard-card slide-in delay-3">
            <div class="wizard-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">4</span>
                        <div>
                            <h4 class="mb-1">Data Jabatan Eselon</h4>
                            <p class="mb-0 small">Input jumlah anggota berdasarkan jabatan eselon</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-briefcase me-2"></i>7 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="40%">Jabatan Eselon</th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-male text-primary me-2"></i>Jumlah Laki-laki
                                </th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-female text-danger me-2"></i>Jumlah Perempuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jabatanList as $jab)
                            <tr>
                                <td><strong>Eselon {{ $jab }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="jab_{{ strtolower($jab) }}_laki" 
                                           value="{{ old('jab_' . strtolower($jab) . '_laki', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                                <td>
                                    <input type="number" 
                                           name="jab_{{ strtolower($jab) }}_perempuan" 
                                           value="{{ old('jab_' . strtolower($jab) . '_perempuan', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 5: AGAMA --}}
        <div class="wizard-card slide-in delay-4">
            <div class="wizard-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">5</span>
                        <div>
                            <h4 class="mb-1">Data Agama</h4>
                            <p class="mb-0 small">Input jumlah anggota berdasarkan agama</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-pray me-2"></i>5 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="40%">Agama</th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-male text-primary me-2"></i>Jumlah Laki-laki
                                </th>
                                <th width="30%" class="text-center">
                                    <i class="fas fa-female text-danger me-2"></i>Jumlah Perempuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agamaList as $agama)
                            <tr>
                                <td><strong>{{ $agama }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="agama_{{ strtolower($agama) }}_laki" 
                                           value="{{ old('agama_' . strtolower($agama) . '_laki', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                                <td>
                                    <input type="number" 
                                           name="agama_{{ strtolower($agama) }}_perempuan" 
                                           value="{{ old('agama_' . strtolower($agama) . '_perempuan', 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 6: JF TERTENTU PNS --}}
        <div class="wizard-card slide-in delay-5">
            <div class="wizard-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">6</span>
                        <div>
                            <h4 class="mb-1">JF Tertentu PNS</h4>
                            <p class="mb-0 small">Input total jumlah Jabatan Fungsional Tertentu PNS</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-user-tie me-2"></i>4 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="50%">Kategori JF Tertentu PNS</th>
                                <th width="50%" class="text-center">
                                    <i class="fas fa-users text-success me-2"></i>Total Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jfTertentuPnsList as $jf)
                            <tr>
                                <td><strong>JF Tertentu PNS {{ $jf }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="jf_tertentu_pns_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_tertentu_pns_' . strtolower($jf), 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 7: JF TERTENTU PPPK --}}
        <div class="wizard-card slide-in delay-6">
            <div class="wizard-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">7</span>
                        <div>
                            <h4 class="mb-1">JF Tertentu PPPK</h4>
                            <p class="mb-0 small">Input total jumlah Jabatan Fungsional Tertentu PPPK</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-user-tie me-2"></i>5 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="50%">Kategori JF Tertentu PPPK</th>
                                <th width="50%" class="text-center">
                                    <i class="fas fa-users text-success me-2"></i>Total Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jfTertentuPppkList as $jf)
                            <tr>
                                <td><strong>JF Tertentu PPPK {{ $jf }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="jf_tertentu_pppk_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_tertentu_pppk_' . strtolower($jf), 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 8: JF PELAKSANA PNS --}}
        <div class="wizard-card slide-in delay-7">
            <div class="wizard-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">8</span>
                        <div>
                            <h4 class="mb-1">JF Pelaksana PNS</h4>
                            <p class="mb-0 small">Input total jumlah Jabatan Fungsional Pelaksana PNS</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-user-cog me-2"></i>4 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="50%">Kategori JF Pelaksana PNS</th>
                                <th width="50%" class="text-center">
                                    <i class="fas fa-users text-success me-2"></i>Total Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jfPelaksanaPnsList as $jf)
                            <tr>
                                <td><strong>JF Pelaksana PNS {{ $jf }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="jf_pelaksana_pns_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_pelaksana_pns_' . strtolower($jf), 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 9: JF PELAKSANA PPPK --}}
        <div class="wizard-card slide-in delay-8">
            <div class="wizard-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator">9</span>
                        <div>
                            <h4 class="mb-1">JF Pelaksana PPPK</h4>
                            <p class="mb-0 small">Input total jumlah Jabatan Fungsional Pelaksana PPPK</p>
                        </div>
                    </div>
                    <div class="category-badge">
                        <i class="fas fa-user-cog me-2"></i>6 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-modern">
                        <thead>
                            <tr>
                                <th width="50%">Kategori JF Pelaksana PPPK</th>
                                <th width="50%" class="text-center">
                                    <i class="fas fa-users text-success me-2"></i>Total Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jfPelaksanaPppkList as $jf)
                            <tr>
                                <td><strong>JF Pelaksana PPPK {{ $jf }}</strong></td>
                                <td>
                                    <input type="number" 
                                           name="jf_pelaksana_pppk_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_pelaksana_pppk_' . strtolower($jf), 0) }}" 
                                           min="0" 
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="wizard-card slide-in delay-9">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('data-anggota-lengkap.index') }}" class="btn btn-secondary btn-modern">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <div class="d-flex gap-3">
                        <button type="reset" class="btn btn-warning-gradient btn-modern">
                            <i class="fas fa-redo me-2"></i>Reset Form
                        </button>
                        <button type="submit" class="btn btn-success-gradient btn-modern">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let formChanged = false;
    let isSubmitting = false;
    
    const form = document.getElementById('formDataAnggota');
    
    form.addEventListener('change', function() {
        formChanged = true;
    });
    
    form.addEventListener('submit', function() {
        isSubmitting = true;
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formChanged && !isSubmitting) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    const cards = document.querySelectorAll('.wizard-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endpush