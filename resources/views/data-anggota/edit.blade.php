@extends('layouts.app')

@section('title', 'Edit Data Anggota')
@section('page-title', 'Edit Data Anggota')

@push('styles')
<style>
    /* Premium Page Styles */
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

    /* Current Data Card */
    .current-data-card-luxury {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%);
        border: 1px solid rgba(240, 147, 251, 0.4);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .current-data-title-luxury {
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .current-data-content-luxury {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .current-stat-item-luxury {
        background: rgba(35, 41, 70, 0.6);
        border: 1px solid rgba(240, 147, 251, 0.3);
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
    }

    .current-stat-label-luxury {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--color-text-tertiary);
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .current-stat-value-luxury {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1;
        font-family: 'Space Grotesk', sans-serif;
    }

    .current-stat-value-luxury.female {
        background: var(--gradient-danger);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .current-stat-value-luxury.male {
        background: var(--gradient-info);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .current-stat-value-luxury.total {
        background: var(--gradient-success);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Form Card Luxury */
    .form-card-luxury {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(35, 41, 70, 0.9) 100%);
        border: 1px solid var(--color-border);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .form-card-luxury .card-header {
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

    /* Form Luxury Styles */
    .form-group-luxury {
        margin-bottom: 1.75rem;
    }

    .form-label-luxury {
        font-weight: 700;
        color: var(--color-text-primary);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-luxury .required {
        color: #ff6a00;
        font-size: 1.2rem;
        line-height: 1;
    }

    .form-label-luxury .icon {
        width: 24px;
        height: 24px;
        background: var(--gradient-primary);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
    }

    .form-control-luxury,
    .form-select-luxury {
        background: rgba(35, 41, 70, 0.6);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 10px;
        padding: 0.875rem 1.25rem;
        color: var(--color-text-primary);
        font-size: 1rem;
        transition: var(--transition-base);
    }

    .form-control-luxury:focus,
    .form-select-luxury:focus {
        border-color: rgba(102, 126, 234, 0.8);
        background: rgba(35, 41, 70, 0.8);
        color: var(--color-text-primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        outline: none;
    }

    .form-control-luxury::placeholder {
        color: var(--color-text-tertiary);
    }

    .form-control-luxury.is-invalid,
    .form-select-luxury.is-invalid {
        border-color: rgba(255, 106, 0, 0.6);
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #ff6a00;
        font-weight: 600;
        padding-left: 0.5rem;
    }

    /* Input Helper Text */
    .form-helper-text {
        font-size: 0.85rem;
        color: var(--color-text-tertiary);
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Input Group Styling */
    .input-group-text {
        border-radius: 10px 0 0 10px;
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-right: none;
        background: rgba(35, 41, 70, 0.6);
        font-weight: 600;
        color: var(--color-text-primary);
    }

    .input-group .form-control-luxury {
        border-radius: 0 10px 10px 0;
        border-left: none;
    }

    .input-group:focus-within .input-group-text {
        border-color: rgba(102, 126, 234, 0.8);
        background: rgba(35, 41, 70, 0.8);
    }

    /* Alert Luxury */
    .alert-luxury {
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid;
        backdrop-filter: blur(10px);
    }

    .alert-luxury.warning {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%);
        border-color: rgba(240, 147, 251, 0.4);
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

    .alert-luxury.warning .alert-icon-box-luxury {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.3) 0%, rgba(245, 87, 108, 0.3) 100%);
        color: #f5576c;
    }

    /* Preview Card */
    .preview-card-luxury {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 2px dashed rgba(102, 126, 234, 0.4);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .preview-title-luxury {
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.1rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .preview-grid-luxury {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .preview-item-luxury {
        background: rgba(35, 41, 70, 0.6);
        border: 1px solid rgba(102, 126, 234, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
    }

    .preview-label-luxury {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--color-text-tertiary);
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .preview-value-luxury {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1;
        font-family: 'Space Grotesk', sans-serif;
    }

    .preview-value-luxury.female {
        background: var(--gradient-danger);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .preview-value-luxury.male {
        background: var(--gradient-info);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .preview-value-luxury.total {
        background: var(--gradient-success);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .preview-value-luxury.gaji {
        background: var(--gradient-success);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.3rem;
    }

    .preview-value-luxury.belanja {
        background: var(--gradient-warning);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.5rem;
    }

    /* Section Divider */
    .section-divider-luxury {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(102, 126, 234, 0.3) 50%, transparent 100%);
        margin: 2rem 0;
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

    .btn-luxury-warning {
        background: var(--gradient-card-4);
        color: white;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
    }

    .btn-luxury-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(240, 147, 251, 0.5);
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

    @media (max-width: 992px) {
        .preview-grid-luxury,
        .current-data-content-luxury {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .preview-grid-luxury,
        .current-data-content-luxury {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="page-luxury">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                
                {{-- Header Luxury --}}
                <div class="header-card-luxury fade-in-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1>
                                <i class="fas fa-edit me-3"></i>Edit Data Anggota
                            </h1>
                            <p>Perbarui data historis untuk prediksi yang lebih akurat</p>
                        </div>
                        <a href="{{ route('data-anggota.index') }}" class="btn-luxury btn-luxury-secondary">
                            <i class="fas fa-arrow-left"></i>Kembali
                        </a>
                    </div>
                </div>

                {{-- Current Data Display --}}
                <div class="current-data-card-luxury fade-in-up" style="animation-delay: 0.1s">
                    <div class="current-data-title-luxury">
                        <i class="fas fa-database"></i>
                        Data Saat Ini
                    </div>
                    <div class="current-data-content-luxury">
                        <div class="current-stat-item-luxury">
                            <div class="current-stat-label-luxury">
                                <i class="fas fa-female"></i> Perempuan
                            </div>
                            <div class="current-stat-value-luxury female">{{ number_format($dataAnggotum->jumlah_perempuan) }}</div>
                        </div>
                        <div class="current-stat-item-luxury">
                            <div class="current-stat-label-luxury">
                                <i class="fas fa-male"></i> Laki-Laki
                            </div>
                            <div class="current-stat-value-luxury male">{{ number_format($dataAnggotum->jumlah_laki_laki) }}</div>
                        </div>
                        <div class="current-stat-item-luxury">
                            <div class="current-stat-label-luxury">
                                <i class="fas fa-users"></i> Total
                            </div>
                            <div class="current-stat-value-luxury total">{{ number_format($dataAnggotum->total_anggota) }}</div>
                        </div>
                    </div>
                </div>

                {{-- Alert Warning --}}
                <div class="alert-luxury warning fade-in-up" style="animation-delay: 0.2s">
                    <div class="d-flex align-items-start gap-3">
                        <div class="alert-icon-box-luxury">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <strong style="color: #f5576c;">Perhatian!</strong>
                            <p style="color: var(--color-text-secondary); margin: 0.5rem 0 0;">
                                Perubahan data akan mempengaruhi hasil prediksi. Pastikan data yang diinput sudah akurat dan terverifikasi.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Card Luxury --}}
                <div class="form-card-luxury fade-in-up" style="animation-delay: 0.3s">
                    <div class="card-header">
                        <h3 class="card-title-luxury">
                            <i class="fas fa-edit me-2"></i>Form Edit Data
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('data-anggota.update', $dataAnggotum->id) }}" method="POST" id="formData">
                            @csrf
                            @method('PUT')
                            
                            {{-- Instansi --}}
                            <div class="form-group-luxury">
                                <label for="instansi_id" class="form-label-luxury">
                                    <span class="icon"><i class="fas fa-building"></i></span>
                                    Periode
                                    <span class="required">*</span>
                                </label>
                                <select class="form-select-luxury @error('instansi_id') is-invalid @enderror" 
                                        id="instansi_id" name="instansi_id" required>
                                    <option value="">-- Pilih Periode --</option>
                                    @foreach($instansi as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ (old('instansi_id', $dataAnggotum->instansi_id) == $item->id) ? 'selected' : '' }}>
                                            {{ $item->nama_instansi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('instansi_id')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-helper-text">
                                    <i class="fas fa-info-circle"></i>
                                    Pilih periode yang akan diinput datanya
                                </div>
                            </div>

                            <div class="section-divider-luxury"></div>

                            {{-- Periode --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="bulan" class="form-label-luxury">
                                            <span class="icon"><i class="fas fa-calendar"></i></span>
                                            Bulan
                                            <span class="required">*</span>
                                        </label>
                                        <select class="form-select-luxury @error('bulan') is-invalid @enderror" 
                                                id="bulan" name="bulan" required>
                                            <option value="">-- Pilih Bulan --</option>
                                            @foreach($bulanList as $key => $value)
                                                <option value="{{ $key }}" 
                                                    {{ (old('bulan', $dataAnggotum->bulan) == $key) ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bulan')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="tahun" class="form-label-luxury">
                                            <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                                            Tahun
                                            <span class="required">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control-luxury @error('tahun') is-invalid @enderror" 
                                               id="tahun" 
                                               name="tahun" 
                                               value="{{ old('tahun', $dataAnggotum->tahun) }}" 
                                               min="2000" 
                                               max="2100" 
                                               required>
                                        @error('tahun')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="section-divider-luxury"></div>

                            {{-- Jumlah Anggota --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="jumlah_perempuan" class="form-label-luxury">
                                            <span class="icon" style="background: var(--gradient-danger);">
                                                <i class="fas fa-female"></i>
                                            </span>
                                            Jumlah Perempuan
                                            <span class="required">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control-luxury @error('jumlah_perempuan') is-invalid @enderror" 
                                               id="jumlah_perempuan" 
                                               name="jumlah_perempuan" 
                                               value="{{ old('jumlah_perempuan', $dataAnggotum->jumlah_perempuan) }}" 
                                               min="0" 
                                               required
                                               onchange="updatePreview()">
                                        @error('jumlah_perempuan')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-helper-text">
                                            <i class="fas fa-info-circle"></i>
                                            Masukkan jumlah anggota perempuan
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="jumlah_laki_laki" class="form-label-luxury">
                                            <span class="icon" style="background: var(--gradient-info);">
                                                <i class="fas fa-male"></i>
                                            </span>
                                            Jumlah Laki-Laki
                                            <span class="required">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control-luxury @error('jumlah_laki_laki') is-invalid @enderror" 
                                               id="jumlah_laki_laki" 
                                               name="jumlah_laki_laki" 
                                               value="{{ old('jumlah_laki_laki', $dataAnggotum->jumlah_laki_laki) }}" 
                                               min="0" 
                                               required
                                               onchange="updatePreview()">
                                        @error('jumlah_laki_laki')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-helper-text">
                                            <i class="fas fa-info-circle"></i>
                                            Masukkan jumlah anggota laki-laki
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-divider-luxury"></div>

                            {{-- Rata-rata Gaji --}}
                            <div class="form-group-luxury">
                                <label for="rata_rata_gaji" class="form-label-luxury">
                                    <span class="icon" style="background: var(--gradient-success);">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </span>
                                    Rata-Rata Gaji
                                    <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control-luxury @error('rata_rata_gaji') is-invalid @enderror" 
                                           id="rata_rata_gaji" 
                                           name="rata_rata_gaji" 
                                           value="{{ old('rata_rata_gaji', $dataAnggotum->rata_rata_gaji ?? 0) }}" 
                                           min="0" 
                                           step="0.01" 
                                           required 
                                           onchange="updatePreview()">
                                </div>
                                @error('rata_rata_gaji')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-helper-text">
                                    <i class="fas fa-info-circle"></i>
                                    Masukkan rata-rata gaji per anggota untuk perhitungan prediksi belanja
                                </div>
                            </div>

                            {{-- Preview Card --}}
                            <div class="preview-card-luxury" id="previewCard">
                                <div class="preview-title-luxury">
                                    <i class="fas fa-eye"></i>
                                    Preview Data Baru
                                </div>
                                <div class="preview-grid-luxury">
                                    <div class="preview-item-luxury">
                                        <div class="preview-label-luxury">
                                            <i class="fas fa-female"></i> Perempuan
                                        </div>
                                        <div class="preview-value-luxury female" id="previewFemale">{{ number_format($dataAnggotum->jumlah_perempuan) }}</div>
                                    </div>
                                    <div class="preview-item-luxury">
                                        <div class="preview-label-luxury">
                                            <i class="fas fa-male"></i> Laki-Laki
                                        </div>
                                        <div class="preview-value-luxury male" id="previewMale">{{ number_format($dataAnggotum->jumlah_laki_laki) }}</div>
                                    </div>
                                    <div class="preview-item-luxury">
                                        <div class="preview-label-luxury">
                                            <i class="fas fa-users"></i> Total Anggota
                                        </div>
                                        <div class="preview-value-luxury total" id="previewTotal">{{ number_format($dataAnggotum->total_anggota) }}</div>
                                    </div>
                                    <div class="preview-item-luxury">
                                        <div class="preview-label-luxury">
                                            <i class="fas fa-chart-pie"></i> Komposisi
                                        </div>
                                        <div id="previewComposition" style="font-size: 0.95rem; color: var(--color-text-secondary); margin-top: 0.75rem;">
                                            <span class="me-2">
                                                <i class="fas fa-female" style="color: #ff6a00;"></i> 
                                                <span id="percentFemale">{{ $dataAnggotum->total_anggota > 0 ? number_format(($dataAnggotum->jumlah_perempuan / $dataAnggotum->total_anggota) * 100, 1) : 0 }}</span>%
                                            </span>
                                                                                        <span class="me-2">
                                                <i class="fas fa-male" style="color: #4facfe;"></i>
                                                <span id="percentMale">
                                                    {{ $dataAnggotum->total_anggota > 0
                                                        ? number_format(($dataAnggotum->jumlah_laki_laki / $dataAnggotum->total_anggota) * 100, 1)
                                                        : 0 }}
                                                </span>%
                                            </span>
                                        </div>
                                    </div>

                                    <div class="preview-item-luxury">
                                        <div class="preview-label-luxury">
                                            <i class="fas fa-money-bill-wave"></i> Rata-rata Gaji
                                        </div>
                                        <div class="preview-value-luxury gaji" id="previewGaji">
                                            Rp {{ number_format($dataAnggotum->rata_rata_gaji ?? 0, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="{{ route('data-anggota.index') }}"
                                   class="btn-luxury btn-luxury-secondary">
                                    <i class="fas fa-times"></i>Batal
                                </a>
                                <button type="submit" class="green-btn btn-luxury btn-luxury-warning">
                                    <i class="fas fa-save"></i>Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updatePreview() {
        const perempuan = parseInt(document.getElementById('jumlah_perempuan').value) || 0;
        const laki = parseInt(document.getElementById('jumlah_laki_laki').value) || 0;
        const gaji = parseFloat(document.getElementById('rata_rata_gaji').value) || 0;

        const total = perempuan + laki;

        document.getElementById('previewFemale').innerText = perempuan.toLocaleString('id-ID');
        document.getElementById('previewMale').innerText = laki.toLocaleString('id-ID');
        document.getElementById('previewTotal').innerText = total.toLocaleString('id-ID');
        document.getElementById('previewGaji').innerText = 'Rp ' + gaji.toLocaleString('id-ID');

        const percentFemale = total > 0 ? ((perempuan / total) * 100).toFixed(1) : 0;
        const percentMale = total > 0 ? ((laki / total) * 100).toFixed(1) : 0;

        document.getElementById('percentFemale').innerText = percentFemale;
        document.getElementById('percentMale').innerText = percentMale;
    }
</script>
@endpush
