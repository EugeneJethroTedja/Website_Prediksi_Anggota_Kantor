@extends('layouts.app')

@section('title', 'Edit Periode')
@section('page-title', 'Edit Periode')

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

    /* Current Data Card */
    .current-data-card {
        background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%);
        border: 1px solid rgba(240, 147, 251, 0.4);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(240, 147, 251, 0.2);
        backdrop-filter: blur(10px);
    }

    .current-data-title {
        font-weight: 700;
        color: #f093fb;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .current-data-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .current-data-avatar {
        width: 60px;
        height: 60px;
        background: var(--gradient-warning);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.75rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
    }

    .current-data-info {
        flex: 1;
        min-width: 200px;
    }

    .current-data-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-text-tertiary);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .current-data-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-text-primary);
        margin-bottom: 0.25rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .current-data-desc {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
        line-height: 1.4;
    }

    /* Stats Card */
    .stats-card {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.1) 100%);
        border: 1px solid rgba(79, 172, 254, 0.3);
        border-radius: 12px;
        padding: 1.25rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        background: var(--gradient-info);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Space Grotesk', sans-serif;
    }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--color-text-tertiary);
        font-weight: 700;
        margin-top: 0.25rem;
        letter-spacing: 0.5px;
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

    .alert-luxury-content {
        flex: 1;
    }

    .alert-luxury-title {
        font-weight: 700;
        color: #f5576c;
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
    }

    .char-counter.warning {
        color: #f093fb;
    }

    .char-counter.danger {
        color: #ff6a00;
    }

    /* Section Divider */
    .section-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, rgba(102, 126, 234, 0.3) 50%, transparent 100%);
        margin: 2rem 0;
    }

    /* Comparison Card */
    .comparison-card {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 2px dashed rgba(102, 126, 234, 0.4);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .comparison-title {
        font-weight: 700;
        color: #667eea;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .comparison-grid {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 1.5rem;
        align-items: center;
    }

    .comparison-item {
        background: rgba(26, 26, 46, 0.6);
        border-radius: 12px;
        padding: 1.5rem;
        border: 2px solid;
    }

    .comparison-item.before {
        border-color: rgba(240, 147, 251, 0.5);
    }

    .comparison-item.after {
        border-color: rgba(102, 126, 234, 0.5);
    }

    .comparison-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        margin-bottom: 0.75rem;
        text-align: center;
    }

    .comparison-item.before .comparison-label {
        color: #f093fb;
    }

    .comparison-item.after .comparison-label {
        color: #667eea;
    }

    .comparison-content {
        text-align: center;
    }

    .comparison-avatar {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.3rem;
        margin: 0 auto 0.75rem;
    }

    .comparison-item.before .comparison-avatar {
        background: var(--gradient-warning);
    }

    .comparison-item.after .comparison-avatar {
        background: var(--gradient-primary);
    }

    .comparison-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
    }

    .comparison-desc {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
        line-height: 1.4;
    }

    .comparison-arrow {
        font-size: 2rem;
        color: #667eea;
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

    .btn-luxury-warning {
        background: var(--gradient-warning);
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
        border-color: var(--color-border-light);
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

    /* Responsive */
    @media (max-width: 768px) {
        .header-card-luxury h1 {
            font-size: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .current-data-content {
            flex-direction: column;
            text-align: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .comparison-grid {
            grid-template-columns: 1fr;
        }

        .comparison-arrow {
            transform: rotate(90deg);
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
                                <i class="fas fa-edit me-3"></i>Edit Periode
                            </h1>
                            <p>Perbarui informasi periode dalam sistem</p>
                        </div>
                        <a href="{{ route('instansi.index') }}" class="btn-luxury btn-luxury-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                {{-- Current Data Display --}}
                <div class="current-data-card fade-in-up" style="animation-delay: 0.1s">
                    <div class="current-data-title">
                        <i class="fas fa-database"></i>
                        Data Saat Ini
                    </div>
                    <div class="current-data-content">
                        <div class="current-data-avatar">
                            {{ substr($instansi->nama_instansi, 0, 1) }}
                        </div>
                        <div class="current-data-info" style="flex: 2;">
                            <div class="current-data-label">Periode</div>
                            <div class="current-data-value">{{ $instansi->nama_instansi }}</div>
                            <div class="current-data-desc">
                                {{ $instansi->keterangan ?? 'Tidak ada keterangan' }}
                            </div>
                        </div>
                        <div class="stats-card">
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-value">{{ $instansi->data_anggota_count }}</div>
                                    <div class="stat-label"><i class="fas fa-database me-1"></i>Data Anggota</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ $instansi->prediksi_count ?? 0 }}</div>
                                    <div class="stat-label"><i class="fas fa-chart-line me-1"></i>Prediksi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alert Warning --}}
                @if($instansi->data_anggota_count > 0)
                <div class="alert-luxury warning fade-in-up" style="animation-delay: 0.2s">
                    <div class="alert-icon-box-luxury">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-luxury-content">
                        <div class="alert-luxury-title">Perhatian!</div>
                        <p class="alert-luxury-text">
                            Periode ini memiliki <strong>{{ $instansi->data_anggota_count }} data anggota</strong> yang sudah tersimpan. 
                            Perubahan periode akan mempengaruhi semua data terkait. Pastikan perubahan yang Anda lakukan sudah benar.
                        </p>
                    </div>
                </div>
                @endif

                {{-- Form Card Luxury --}}
                <div class="form-card-luxury fade-in-up" style="animation-delay: 0.3s">
                    <div class="card-header">
                        <h3 class="card-title-luxury">
                            <i class="fas fa-pen me-2"></i>Form Edit Data
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('instansi.update', $instansi->id) }}" method="POST" id="formEdit">
                            @csrf
                            @method('PUT')
                            
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
                                       value="{{ old('nama_instansi', $instansi->nama_instansi) }}" 
                                       placeholder="Masukkan periode..." 
                                       maxlength="255"
                                       required
                                       oninput="updateComparison()">
                                @error('nama_instansi')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="char-counter" id="namaCounter">
                                    <i class="fas fa-info-circle me-1"></i>Karakter: <strong id="namaCount">{{ strlen($instansi->nama_instansi) }}</strong> / 255
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
                                          placeholder="Tambahkan keterangan atau deskripsi singkat..."
                                          maxlength="500"
                                          oninput="updateComparison()">{{ old('keterangan', $instansi->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="char-counter" id="ketCounter">
                                    <i class="fas fa-info-circle me-1"></i>Karakter: <strong id="ketCount">{{ strlen($instansi->keterangan ?? '') }}</strong> / 500
                                </div>
                            </div>

                            {{-- Comparison Card --}}
                            <div class="comparison-card" id="comparisonCard" style="display: none;">
                                <div class="comparison-title">
                                    <i class="fas fa-exchange-alt"></i>
                                    Perbandingan Perubahan
                                </div>
                                <div class="comparison-grid">
                                    <div class="comparison-item before">
                                        <div class="comparison-label">
                                            <i class="fas fa-history"></i> Data Lama
                                        </div>
                                        <div class="comparison-content">
                                            <div class="comparison-avatar">
                                                {{ substr($instansi->nama_instansi, 0, 1) }}
                                            </div>
                                            <div class="comparison-name">{{ $instansi->nama_instansi }}</div>
                                            <div class="comparison-desc">
                                                {{ Str::limit($instansi->keterangan ?? 'Tidak ada keterangan', 60) }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="comparison-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                    
                                    <div class="comparison-item after">
                                        <div class="comparison-label">
                                            <i class="fas fa-sync-alt"></i> Data Baru
                                        </div>
                                        <div class="comparison-content">
                                            <div class="comparison-avatar" id="newAvatar">
                                                {{ substr($instansi->nama_instansi, 0, 1) }}
                                            </div>
                                            <div class="comparison-name" id="newNama">{{ $instansi->nama_instansi }}</div>
                                            <div class="comparison-desc" id="newKet">
                                                {{ Str::limit($instansi->keterangan ?? 'Tidak ada keterangan', 60) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="d-flex justify-content-between align-items-center pt-3 flex-wrap gap-2">
                                <a href="{{ route('instansi.index') }}" class="btn-luxury btn-luxury-secondary">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                                <button type="submit" class="btn-luxury btn-luxury-warning">
                                    <i class="fas fa-save"></i>
                                    Update Periode
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
const originalNama = "{{ $instansi->nama_instansi }}";
const originalKet = "{{ $instansi->keterangan ?? '' }}";

function updateComparison() {
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
    
    // Show comparison if values changed
    if (nama !== originalNama || keterangan !== originalKet) {
        document.getElementById('comparisonCard').style.display = 'block';
        
        // Update new values
        document.getElementById('newAvatar').textContent = nama ? nama.charAt(0).toUpperCase() : '?';
        document.getElementById('newNama').textContent = nama || 'Belum diisi';
        
        // Truncate keterangan if needed
        const displayKet = keterangan || 'Tidak ada keterangan';
        document.getElementById('newKet').textContent = displayKet.length > 60 ? displayKet.substring(0, 60) + '...' : displayKet;
    } else {
        document.getElementById('comparisonCard').style.display = 'none';
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    updateComparison();
});
</script>
@endpush