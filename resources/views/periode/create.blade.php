@extends('layouts.app')

@section('title', 'Tambah Periode')
@section('page-title', 'Tambah Periode Baru')

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

    /* Form Card Premium */
    .form-card-premium {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .form-card-premium .card-header {
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

    /* Form Premium Styles */
    .form-group-premium {
        margin-bottom: 1.75rem;
    }

    .form-label-premium {
        font-weight: 700;
        color: #1a1d2e;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-premium .required {
        color: #f5576c;
        font-size: 1.2rem;
        line-height: 1;
    }

    .form-label-premium .icon {
        width: 24px;
        height: 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
    }

    .form-control-premium,
    .form-select-premium,
    .form-textarea-premium {
        border-radius: 12px;
        border: 2px solid #e1e8ed;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control-premium:focus,
    .form-select-premium:focus,
    .form-textarea-premium:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control-premium.is-invalid,
    .form-select-premium.is-invalid,
    .form-textarea-premium.is-invalid {
        border-color: #f5576c;
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #f5576c;
        font-weight: 600;
        padding-left: 0.5rem;
    }

    /* Form Helper Text */
    .form-helper-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Alert Premium */
    .alert-premium {
        border: none;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(23, 162, 184, 0.05) 100%);
        border-left: 4px solid #17a2b8;
    }

    .alert-premium-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .alert-premium-content {
        flex: 1;
    }

    .alert-premium-title {
        font-weight: 700;
        color: #17a2b8;
        margin-bottom: 0.25rem;
    }

    .alert-premium-text {
        color: #1a1d2e;
        margin: 0;
        line-height: 1.6;
    }

    /* Button Premium */
    .btn-premium {
        padding: 0.875rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1rem;
    }

    .btn-premium-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-premium-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
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

    /* Checkbox Premium */
    .form-check-premium {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(245, 87, 108, 0.05) 100%);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        border: 2px solid #e1e8ed;
        transition: all 0.3s ease;
    }

    .form-check-premium:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
    }

    .form-check-premium .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
        border: 2px solid #667eea;
        border-radius: 6px;
        cursor: pointer;
    }

    .form-check-premium .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    /* Info Box */
    .info-box-premium {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
    }

    .info-box-header {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        font-weight: 700;
        color: #f57c00;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-box-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-box-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .info-box-list li:last-child {
        border-bottom: none;
    }

    .info-box-number {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
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

    /* Section Divider */
    .section-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, #e1e8ed 50%, transparent 100%);
        margin: 2rem 0;
    }
</style>
@endpush

@section('content')
<div class="page-premium">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                
                {{-- Header Premium --}}
                <div class="header-card-premium fade-in-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1>
                                <i class="fas fa-plus-circle me-3"></i>Tambah Periode Baru
                            </h1>
                            <p>Buat periode untuk mengelompokkan data berdasarkan rentang waktu</p>
                        </div>
                        <a href="{{ route('periode.index') }}" class="btn-premium btn-premium-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                {{-- Alert Info --}}
                <div class="alert-premium fade-in-up" style="animation-delay: 0.1s">
                    <div class="alert-premium-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="alert-premium-content">
                        <div class="alert-premium-title">Informasi Periode</div>
                        <p class="alert-premium-text">
                            Periode digunakan sebagai label untuk mengelompokkan data pegawai berdasarkan rentang waktu tertentu. 
                            Contoh: "Pegawai BKPSDM 2024", "Dinas Kesehatan Q1", atau "Periode Januari-Juni 2024".
                        </p>
                    </div>
                </div>

                {{-- Form Card Premium --}}
                <div class="form-card-premium fade-in-up" style="animation-delay: 0.2s">
                    <div class="card-header">
                        <h3 class="card-title-premium">
                            <i class="fas fa-edit me-2"></i>Form Data Periode
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('periode.store') }}" method="POST">
                            @csrf
                            
                            {{-- Nama Periode --}}
                            <div class="form-group-premium">
                                <label for="nama_periode" class="form-label-premium">
                                    <span class="icon"><i class="fas fa-tag"></i></span>
                                    Nama Periode
                                    <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control-premium @error('nama_periode') is-invalid @enderror" 
                                       id="nama_periode" 
                                       name="nama_periode" 
                                       value="{{ old('nama_periode') }}" 
                                       placeholder="Contoh: Pegawai BKPSDM 2024" 
                                       required>
                                @error('nama_periode')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-helper-text">
                                    <i class="fas fa-lightbulb"></i>
                                    Gunakan nama yang deskriptif untuk kategori/grup pegawai
                                </div>
                            </div>

                            <div class="section-divider"></div>

                            {{-- Keterangan --}}
                            <div class="form-group-premium">
                                <label for="keterangan" class="form-label-premium">
                                    <span class="icon" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                                        <i class="fas fa-align-left"></i>
                                    </span>
                                    Keterangan
                                    <span style="font-size: 0.7rem; text-transform: none; color: #6c757d; font-weight: 500;">(Opsional)</span>
                                </label>
                                <textarea class="form-textarea-premium @error('keterangan') is-invalid @enderror" 
                                          id="keterangan" 
                                          name="keterangan" 
                                          rows="3" 
                                          placeholder="Tambahkan keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-helper-text">
                                    <i class="fas fa-info-circle"></i>
                                    Misalnya: "Data pegawai BKPSDM untuk tahun akademik 2024/2025"
                                </div>
                            </div>

                            <div class="section-divider"></div>

                            {{-- Status Aktif --}}
                            <div class="form-group-premium">
                                <label class="form-label-premium">
                                    <span class="icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                        <i class="fas fa-toggle-on"></i>
                                    </span>
                                    Status Periode
                                </label>
                                <div class="form-check-premium">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="is_active" 
                                           value="1" 
                                           id="is_active" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">
                                        <strong style="color: #1a1d2e;">Aktifkan periode ini</strong>
                                        <br>
                                        <small class="text-muted">
                                            Periode aktif akan muncul di dashboard dan dapat digunakan untuk input data & prediksi
                                        </small>
                                    </label>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="d-flex justify-content-between align-items-center pt-3">
                                <a href="{{ route('periode.index') }}" class="btn-premium btn-premium-secondary">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                                <button type="submit" class="btn-premium btn-premium-primary">
                                    <i class="fas fa-save"></i>
                                    Simpan Periode
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="info-box-premium fade-in-up" style="animation-delay: 0.3s">
                    <div class="info-box-header">
                        <i class="fas fa-lightbulb me-2"></i>
                        Cara Kerja Sistem
                    </div>
                    <ul class="info-box-list">
                        <li>
                            <div class="info-box-number">1</div>
                            <div>
                                <strong style="color: #1a1d2e;">Buat Periode</strong>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                    Sebagai kategori/label (contoh: "Pegawai BKPSDM")
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="info-box-number">2</div>
                            <div>
                                <strong style="color: #1a1d2e;">Input Data Anggota Lengkap</strong>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                    Masukkan data per bulan (Des 2015, Jan 2016, dll)
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="info-box-number">3</div>
                            <div>
                                <strong style="color: #1a1d2e;">Lihat Dashboard Lengkap</strong>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                    Filter berdasarkan periode dan rentang tanggal
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="info-box-number">4</div>
                            <div>
                                <strong style="color: #1a1d2e;">Prediksi Otomatis</strong>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                    Sistem akan menghitung prediksi berdasarkan filter yang dipilih
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection