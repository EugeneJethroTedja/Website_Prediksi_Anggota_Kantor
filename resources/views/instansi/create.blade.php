@extends('layouts.app')

@section('title', 'Tambah Periode')
@section('page-title', 'Tambah Periode Baru')

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

    /* Alert Luxury */
    .alert-luxury {
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .alert-luxury.info {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.1) 100%);
        border-color: rgba(79, 172, 254, 0.4);
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
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.3) 0%, rgba(0, 242, 254, 0.3) 100%);
        color: #00f2fe;
    }

    .alert-luxury-content {
        flex: 1;
    }

    .alert-luxury-title {
        font-weight: 700;
        color: #00f2fe;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .alert-luxury-text {
        color: var(--color-text-secondary);
        margin: 0;
        line-height: 1.6;
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

    /* Form Group Luxury */
    .form-group-luxury {
        margin-bottom: 2rem;
    }

    .form-label-luxury {
        font-weight: 700;
        color: var(--color-text-primary);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
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
    .form-textarea-luxury {
        border-radius: 12px;
        border: 2px solid rgba(102, 126, 234, 0.3);
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(35, 41, 70, 0.6);
        color: var(--color-text-primary);
    }

    .form-control-luxury:focus,
    .form-textarea-luxury:focus {
        border-color: rgba(102, 126, 234, 0.8);
        background: rgba(35, 41, 70, 0.8);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        outline: none;
        color: var(--color-text-primary);
    }

    .form-control-luxury.is-invalid,
    .form-textarea-luxury.is-invalid {
        border-color: rgba(238, 9, 121, 0.8);
    }

    .form-control-luxury.is-invalid:focus,
    .form-textarea-luxury.is-invalid:focus {
        border-color: rgba(238, 9, 121, 0.8);
        box-shadow: 0 0 0 4px rgba(238, 9, 121, 0.2);
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #ff6a00;
        font-weight: 600;
        padding-left: 0.5rem;
    }

    /* Character Counter */
    .char-counter {
        font-size: 0.85rem;
        color: var(--color-text-tertiary);
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .char-counter.warning {
        color: #f093fb;
    }

    .char-counter.danger {
        color: #ff6a00;
    }

    /* Form Helper Text */
    .form-helper-text {
        font-size: 0.85rem;
        color: var(--color-text-tertiary);
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Examples Box */
    .examples-box {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 0.75rem;
        border-left: 3px solid rgba(102, 126, 234, 0.6);
    }

    .examples-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #667eea;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .examples-list {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
        margin: 0;
        padding-left: 1.25rem;
    }

    .examples-list li {
        margin-bottom: 0.25rem;
    }

    /* Section Divider */
    .section-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, rgba(102, 126, 234, 0.3) 50%, transparent 100%);
        margin: 2rem 0;
    }

    /* Preview Card */
    .preview-card {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.1) 100%);
        border: 2px dashed rgba(56, 239, 125, 0.4);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .preview-title {
        font-weight: 700;
        color: #38ef7d;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .preview-content {
        background: rgba(26, 26, 46, 0.6);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(56, 239, 125, 0.2);
    }

    .preview-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-text-tertiary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .preview-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .preview-desc {
        font-size: 0.9rem;
        color: var(--color-text-secondary);
        line-height: 1.5;
    }

    .preview-avatar {
        width: 50px;
        height: 50px;
        background: var(--gradient-success);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        margin-right: 1rem;
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.4);
    }

    /* Button Luxury */
    .btn-luxury {
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

    .btn-luxury-primary {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-luxury-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-luxury-secondary {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.2) 0%, rgba(136, 146, 176, 0.2) 100%);
        border: 1px solid var(--color-border);
        color: var(--color-text-secondary);
    }

    .btn-luxury-secondary:hover {
        background: linear-gradient(135deg, rgba(184, 193, 236, 0.3) 0%, rgba(136, 146, 176, 0.3) 100%);
        border-color: var(--color-border-light);
        color: var(--color-text-primary);
        transform: translateY(-2px);
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
    }
</style>
@endpush

@section('content')
<div class="dashboard-luxury">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                
                {{-- Header Luxury --}}
                <div class="header-card-luxury fade-in-up">
                    <div class="header-content">
                        <div>
                            <h1>
                                <i class="fas fa-plus-circle me-3"></i>Tambah Periode Baru
                            </h1>
                            <p>Daftarkan periode baru ke dalam sistem prediksi</p>
                        </div>
                        <a href="{{ route('instansi.index') }}" class="btn-luxury btn-luxury-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                {{-- Alert Info --}}
                <div class="alert-luxury info fade-in-up" style="animation-delay: 0.1s">
                    <div class="alert-icon-box-luxury">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="alert-luxury-content">
                        <div class="alert-luxury-title">Informasi Penting</div>
                        <p class="alert-luxury-text">
                            • Periode harus unik dan tidak boleh sama dengan periode yang sudah ada<br>
                            • Setelah periode ditambahkan, Anda dapat mulai input data anggota historis<br>
                            • Minimal 2 bulan data diperlukan untuk menghasilkan prediksi
                        </p>
                    </div>
                </div>

                {{-- Form Card Luxury --}}
                <div class="form-card-luxury fade-in-up" style="animation-delay: 0.2s">
                    <div class="card-header">
                        <h3 class="card-title-luxury">
                            <i class="fas fa-edit me-2"></i>Form Data Periode
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('instansi.store') }}" method="POST" id="formInstansi">
                            @csrf
                            
                            {{-- Nama Instansi --}}
                            <div class="form-group-luxury">
                                <label for="nama_instansi" class="form-label-luxury">
                                    <span class="icon"><i class="fas fa-building"></i></span>
                                    Periode
                                    <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control-luxury @error('nama_instansi') is-invalid @enderror" 
                                       id="nama_instansi" 
                                       name="nama_instansi" 
                                       value="{{ old('nama_instansi') }}" 
                                       placeholder="Masukkan nama instansi..." 
                                       maxlength="255"
                                       required
                                       oninput="updatePreview()">
                                @error('nama_instansi')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="char-counter" id="namaCounter">
                                    <span><i class="fas fa-info-circle me-1"></i>Karakter: <strong id="namaCount">0</strong> / 255</span>
                                </div>
                                
                                {{-- Examples --}}
                                <div class="examples-box">
                                    <div class="examples-title">
                                        <i class="fas fa-lightbulb me-1"></i>Contoh Periode
                                    </div>
                                    <ul class="examples-list">
                                        <li>Periode Januari-2016</li>
                                        <li>Periode Febuari-2016</li>
                                        <li>Periode Maret-2016</li>
                                        <li>Periode April-2016</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="section-divider"></div>

                            {{-- Keterangan --}}
                            <div class="form-group-luxury">
                                <label for="keterangan" class="form-label-luxury">
                                    <span class="icon" style="background: var(--gradient-info);">
                                        <i class="fas fa-align-left"></i>
                                    </span>
                                    Keterangan
                                    <span style="font-size: 0.7rem; text-transform: none; color: var(--color-text-tertiary); font-weight: 500;">(Opsional)</span>
                                </label>
                                <textarea class="form-textarea-luxury @error('keterangan') is-invalid @enderror" 
                                          id="keterangan" 
                                          name="keterangan" 
                                          rows="4" 
                                          placeholder="Tambahkan keterangan atau deskripsi singkat tentang periode..."
                                          maxlength="500"
                                          oninput="updatePreview()">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="char-counter" id="ketCounter">
                                    <span><i class="fas fa-info-circle me-1"></i>Karakter: <strong id="ketCount">0</strong> / 500</span>
                                </div>
                                <div class="form-helper-text">
                                    <i class="fas fa-lightbulb"></i>
                                    Informasi tambahan seperti alamat, kontak, atau deskripsi singkat
                                </div>
                            </div>

                            {{-- Preview Card --}}
                            <div class="preview-card" id="previewCard" style="display: none;">
                                <div class="preview-title">
                                    <i class="fas fa-eye"></i>
                                    Preview
                                </div>
                                <div class="preview-content">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="preview-avatar" id="previewInitial">
                                            ?
                                        </div>
                                        <div style="flex: 1;">
                                            <div class="preview-label">Periode</div>
                                            <div class="preview-value" id="previewNama">-</div>
                                        </div>
                                    </div>
                                    <div id="previewKetWrapper" style="display: none;">
                                        <div class="preview-label">Keterangan</div>
                                        <div class="preview-desc" id="previewKet">-</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="d-flex justify-content-between align-items-center pt-3 flex-wrap gap-2">
                                <a href="{{ route('instansi.index') }}" class="btn-luxury btn-luxury-secondary">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                                <button type="submit" class="btn-luxury btn-luxury-success">
                                    <i class="fas fa-save"></i>
                                    Simpan Periode
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
    const nama = document.getElementById('nama_instansi').value;
    const keterangan = document.getElementById('keterangan').value;
    
    // Update character counters
    const namaCount = nama.length;
    const ketCount = keterangan.length;
    
    document.getElementById('namaCount').textContent = namaCount;
    document.getElementById('ketCount').textContent = ketCount;
    
    // Color counter based on length
    const namaCounter = document.getElementById('namaCounter');
    if (namaCount > 230) {
        namaCounter.classList.add('danger');
        namaCounter.classList.remove('warning');
    } else if (namaCount > 200) {
        namaCounter.classList.add('warning');
        namaCounter.classList.remove('danger');
    } else {
        namaCounter.classList.remove('warning', 'danger');
    }
    
    const ketCounter = document.getElementById('ketCounter');
    if (ketCount > 450) {
        ketCounter.classList.add('danger');
        ketCounter.classList.remove('warning');
    } else if (ketCount > 400) {
        ketCounter.classList.add('warning');
        ketCounter.classList.remove('danger');
    } else {
        ketCounter.classList.remove('warning', 'danger');
    }
    
    // Update preview
    if (nama || keterangan) {
        document.getElementById('previewCard').style.display = 'block';
        
        // Update initial
        document.getElementById('previewInitial').textContent = nama ? nama.charAt(0).toUpperCase() : '?';
        
        // Update nama
        document.getElementById('previewNama').textContent = nama || 'Belum diisi';
        
        // Update keterangan
        if (keterangan) {
            document.getElementById('previewKetWrapper').style.display = 'block';
            document.getElementById('previewKet').textContent = keterangan;
        } else {
            document.getElementById('previewKetWrapper').style.display = 'none';
        }
    } else {
        document.getElementById('previewCard').style.display = 'none';
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
});
</script>
@endpush