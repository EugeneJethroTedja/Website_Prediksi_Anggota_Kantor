@extends('layouts.app')

@section('title', 'Edit Data Anggota Lengkap')
@section('page-title', 'Edit Data Anggota Lengkap')

@push('styles')
<style>
    /* Edit Mode Styling */
    .edit-mode-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
        animation: pulse-edit 2s ease-in-out infinite;
    }

    @keyframes pulse-edit {
        0%, 100% { box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4); }
        50% { box-shadow: 0 6px 25px rgba(240, 147, 251, 0.6); }
    }

    /* Wizard Card dengan border khusus edit */
    .wizard-card-edit {
        border: none;
        border-radius: 24px;
        box-shadow: 0 12px 45px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
        margin-bottom: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 5px solid #f093fb;
    }

    .wizard-card-edit:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        border-left-width: 8px;
    }

    /* Wizard Header Edit Mode */
    .wizard-header-edit {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 2.5rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .wizard-header-edit::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -15%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: rotate-slow 20s linear infinite;
    }

    @keyframes rotate-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .wizard-header-edit h4 {
        position: relative;
        z-index: 1;
        margin: 0;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .wizard-header-edit p {
        position: relative;
        z-index: 1;
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    /* Section Indicator Edit */
    .section-indicator-edit {
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

    /* Category Badge Edit */
    .category-badge-edit {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.75rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    /* Input dengan highlight untuk edit mode */
    .form-control-edit,
    .form-select-edit {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #fef9ff 100%);
    }

    .form-control-edit:focus,
    .form-select-edit:focus {
        border-color: #f093fb;
        box-shadow: 0 0 0 0.25rem rgba(240, 147, 251, 0.15);
        background: white;
        outline: none;
    }

    /* Input Group Edit */
    .input-group-edit {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .input-group-edit label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .input-group-edit label i {
        margin-right: 0.75rem;
        color: #f093fb;
        font-size: 1.1rem;
    }

    /* Data Table Edit Mode */
    .data-table-edit {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
    }

    .data-table-edit thead {
        background: linear-gradient(135deg, #fef5ff 0%, #ffe9f9 100%);
    }

    .data-table-edit thead th {
        padding: 1.25rem 1rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.8px;
        border: none;
        color: #2d3748;
    }

    .data-table-edit tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .data-table-edit tbody tr:hover {
        background: linear-gradient(90deg, #fff5fe 0%, #ffffff 100%);
    }

    .data-table-edit input[type="number"] {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        text-align: center;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        background: linear-gradient(135deg, #ffffff 0%, #fef9ff 100%);
    }

    .data-table-edit input[type="number"]:focus {
        border-color: #f093fb;
        box-shadow: 0 0 0 0.25rem rgba(240, 147, 251, 0.15);
        outline: none;
        transform: scale(1.02);
        background: white;
    }

    /* Button Edit Mode */
    .btn-update-gradient {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 0.875rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-update-gradient::before {
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

    .btn-update-gradient:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-update-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(240, 147, 251, 0.4);
    }

    /* Changed Indicator */
    .changed-field {
        position: relative;
    }

    .changed-field::after {
        content: '●';
        position: absolute;
        top: -5px;
        right: -5px;
        color: #f093fb;
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .changed-field.has-change::after {
        opacity: 1;
        animation: blink 1s ease-in-out infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* Animation */
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

    .slide-in-edit {
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
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Edit Mode Alert --}}
    <div class="alert alert-info border-0 shadow-sm mb-4 slide-in-edit" style="background: linear-gradient(135deg, #e0f7ff 0%, #f0f0ff 100%); border-left: 5px solid #f093fb !important;">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle fa-2x" style="color: #f093fb;"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="mb-1" style="color: #2d3748;">Mode Edit Data</h5>
                <p class="mb-0" style="color: #4a5568;">Anda sedang mengedit data anggota lengkap. Perubahan akan disimpan setelah klik tombol <strong>Update Data</strong>.</p>
            </div>
            <div class="edit-mode-badge">
                <i class="fas fa-edit"></i>
                <span>EDIT MODE</span>
            </div>
        </div>
    </div>

    <form action="{{ route('data-anggota-lengkap.update', $dataAnggotaLengkap) }}" method="POST" id="formEditAnggota">
        @csrf
        @method('PUT')
        
        {{-- SECTION 1: Info Dasar --}}
        <div class="wizard-card-edit slide-in-edit">
            <div class="wizard-header-edit">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">1</span>
                        <div>
                            <h4 class="mb-1">Informasi Dasar</h4>
                            <p class="mb-0 small">Edit periode, bulan, dan tahun data anggota</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-info-circle me-2"></i>Section 1 of 9
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="input-group-edit">
                            <label>
                                <i class="fas fa-calendar-alt"></i>
                                Periode <span class="text-danger">*</span>
                            </label>
                            <select name="periode_id" class="form-select form-select-edit @error('periode_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periode as $p)
                                    <option value="{{ $p->id }}" {{ old('periode_id', $dataAnggotaLengkap->periode_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('periode_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="input-group-edit">
                            <label>
                                <i class="fas fa-calendar"></i>
                                Bulan <span class="text-danger">*</span>
                            </label>
                            <select name="bulan" class="form-select form-select-edit @error('bulan') is-invalid @enderror" required>
                                <option value="">-- Pilih Bulan --</option>
                                @foreach($bulanList as $key => $bulan)
                                    <option value="{{ $key }}" {{ old('bulan', $dataAnggotaLengkap->bulan) == $key ? 'selected' : '' }}>
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
                        <div class="input-group-edit">
                            <label>
                                <i class="fas fa-calendar-day"></i>
                                Tahun <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="tahun" class="form-control form-control-edit @error('tahun') is-invalid @enderror" 
                                   value="{{ old('tahun', $dataAnggotaLengkap->tahun) }}" min="2000" max="2100" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: PENDIDIKAN --}}
        <div class="wizard-card-edit slide-in-edit delay-1">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">2</span>
                        <div>
                            <h4 class="mb-1">Data Pendidikan</h4>
                            <p class="mb-0 small">Edit jumlah anggota berdasarkan tingkat pendidikan (termasuk S3)</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-graduation-cap me-2"></i>10 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="pend_{{ strtolower($pend) }}_laki" 
                                           value="{{ old('pend_' . strtolower($pend) . '_laki', $dataAnggotaLengkap->{'pend_' . strtolower($pend) . '_laki'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'pend_' . strtolower($pend) . '_laki'} }}"
                                           required>
                                </td>
                                <td class="changed-field">
                                    <input type="number" 
                                           name="pend_{{ strtolower($pend) }}_perempuan" 
                                           value="{{ old('pend_' . strtolower($pend) . '_perempuan', $dataAnggotaLengkap->{'pend_' . strtolower($pend) . '_perempuan'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'pend_' . strtolower($pend) . '_perempuan'} }}"
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 3: GOLONGAN (UPDATED: 29 Kategori) --}}
        <div class="wizard-card-edit slide-in-edit delay-2">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">3</span>
                        <div>
                            <h4 class="mb-1">Data Golongan</h4>
                            <p class="mb-0 small">Edit jumlah anggota berdasarkan golongan kepangkatan (lengkap I/A-IV/E dan I-XII)</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-layer-group me-2"></i>29 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="gol_{{ $golField }}_laki" 
                                           value="{{ old('gol_' . $golField . '_laki', $dataAnggotaLengkap->{'gol_' . $golField . '_laki'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'gol_' . $golField . '_laki'} }}"
                                           required>
                                </td>
                                <td class="changed-field">
                                    <input type="number" 
                                           name="gol_{{ $golField }}_perempuan" 
                                           value="{{ old('gol_' . $golField . '_perempuan', $dataAnggotaLengkap->{'gol_' . $golField . '_perempuan'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'gol_' . $golField . '_perempuan'} }}"
                                           required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECTION 4: JABATAN --}}
        <div class="wizard-card-edit slide-in-edit delay-3">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">4</span>
                        <div>
                            <h4 class="mb-1">Data Jabatan Eselon</h4>
                            <p class="mb-0 small">Edit jumlah anggota berdasarkan jabatan eselon</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-briefcase me-2"></i>7 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="jab_{{ strtolower($jab) }}_laki" 
                                           value="{{ old('jab_' . strtolower($jab) . '_laki', $dataAnggotaLengkap->{'jab_' . strtolower($jab) . '_laki'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'jab_' . strtolower($jab) . '_laki'} }}"
                                           required>
                                </td>
                                <td class="changed-field">
                                    <input type="number" 
                                           name="jab_{{ strtolower($jab) }}_perempuan" 
                                           value="{{ old('jab_' . strtolower($jab) . '_perempuan', $dataAnggotaLengkap->{'jab_' . strtolower($jab) . '_perempuan'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'jab_' . strtolower($jab) . '_perempuan'} }}"
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
        <div class="wizard-card-edit slide-in-edit delay-4">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">5</span>
                        <div>
                            <h4 class="mb-1">Data Agama</h4>
                            <p class="mb-0 small">Edit jumlah anggota berdasarkan agama</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-pray me-2"></i>5 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="agama_{{ strtolower($agama) }}_laki" 
                                           value="{{ old('agama_' . strtolower($agama) . '_laki', $dataAnggotaLengkap->{'agama_' . strtolower($agama) . '_laki'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'agama_' . strtolower($agama) . '_laki'} }}"
                                           required>
                                </td>
                                <td class="changed-field">
                                    <input type="number" 
                                           name="agama_{{ strtolower($agama) }}_perempuan" 
                                           value="{{ old('agama_' . strtolower($agama) . '_perempuan', $dataAnggotaLengkap->{'agama_' . strtolower($agama) . '_perempuan'}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'agama_' . strtolower($agama) . '_perempuan'} }}"
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
        <div class="wizard-card-edit slide-in-edit delay-5">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">6</span>
                        <div>
                            <h4 class="mb-1">JF Tertentu PNS</h4>
                            <p class="mb-0 small">Edit total jumlah Jabatan Fungsional Tertentu PNS</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-user-tie me-2"></i>4 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="jf_tertentu_pns_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_tertentu_pns_' . strtolower($jf), $dataAnggotaLengkap->{'jf_tertentu_pns_' . strtolower($jf)}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'jf_tertentu_pns_' . strtolower($jf)} }}"
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
        <div class="wizard-card-edit slide-in-edit delay-6">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">7</span>
                        <div>
                            <h4 class="mb-1">JF Tertentu PPPK</h4>
                            <p class="mb-0 small">Edit total jumlah Jabatan Fungsional Tertentu PPPK</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-user-tie me-2"></i>5 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="jf_tertentu_pppk_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_tertentu_pppk_' . strtolower($jf), $dataAnggotaLengkap->{'jf_tertentu_pppk_' . strtolower($jf)}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'jf_tertentu_pppk_' . strtolower($jf)} }}"
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
        <div class="wizard-card-edit slide-in-edit delay-7">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">8</span>
                        <div>
                            <h4 class="mb-1">JF Pelaksana PNS</h4>
                            <p class="mb-0 small">Edit total jumlah Jabatan Fungsional Pelaksana PNS</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-user-cog me-2"></i>4 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="jf_pelaksana_pns_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_pelaksana_pns_' . strtolower($jf), $dataAnggotaLengkap->{'jf_pelaksana_pns_' . strtolower($jf)}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'jf_pelaksana_pns_' . strtolower($jf)} }}"
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
        <div class="wizard-card-edit slide-in-edit delay-8">
            <div class="wizard-header-edit" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="section-indicator-edit">9</span>
                        <div>
                            <h4 class="mb-1">JF Pelaksana PPPK</h4>
                            <p class="mb-0 small">Edit total jumlah Jabatan Fungsional Pelaksana PPPK</p>
                        </div>
                    </div>
                    <div class="category-badge-edit">
                        <i class="fas fa-user-cog me-2"></i>6 Kategori
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table-edit">
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
                                <td class="changed-field">
                                    <input type="number" 
                                           name="jf_pelaksana_pppk_{{ strtolower($jf) }}" 
                                           value="{{ old('jf_pelaksana_pppk_' . strtolower($jf), $dataAnggotaLengkap->{'jf_pelaksana_pppk_' . strtolower($jf)}) }}" 
                                           min="0" 
                                           data-original="{{ $dataAnggotaLengkap->{'jf_pelaksana_pppk_' . strtolower($jf)} }}"
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
        <div class="wizard-card-edit slide-in-edit delay-9">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('data-anggota-lengkap.index') }}" class="btn btn-secondary" style="padding: 0.875rem 2.5rem; border-radius: 12px; font-weight: 600;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn-update-gradient">
                        <i class="fas fa-save me-2"></i>Update Data
                    </button>
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
    
    const form = document.getElementById('formEditAnggota');
    const inputs = form.querySelectorAll('input[type="number"]');
    
    // Track perubahan pada setiap input
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            formChanged = true;
            const original = this.getAttribute('data-original');
            const current = this.value;
            const parent = this.closest('.changed-field');
            
            if (original && current !== original) {
                parent.classList.add('has-change');
            } else {
                parent.classList.remove('has-change');
            }
        });
    });
    
    // Set flag ketika form di-submit
    form.addEventListener('submit', function() {
        isSubmitting = true;
    });
    
    // Warning jika keluar tanpa save
    window.addEventListener('beforeunload', function(e) {
        if (formChanged && !isSubmitting) {
            e.preventDefault();
            e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin keluar?';
        }
    });
});
</script>
@endpush