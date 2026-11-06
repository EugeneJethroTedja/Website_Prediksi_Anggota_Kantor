<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnggotaLengkap extends Model
{
    use HasFactory;

    protected $table = 'data_anggota_lengkap';

    protected $fillable = [
        'periode_id', 'bulan', 'tahun',
        // Pendidikan Laki-laki
        'pend_sd_laki', 'pend_sltp_laki', 'pend_slta_laki', 'pend_di_laki', 
        'pend_dii_laki', 'pend_diii_laki', 'pend_div_laki', 'pend_s1_laki', 
        'pend_s2_laki', 'pend_s3_laki',
        // Pendidikan Perempuan
        'pend_sd_perempuan', 'pend_sltp_perempuan', 'pend_slta_perempuan', 'pend_di_perempuan',
        'pend_dii_perempuan', 'pend_diii_perempuan', 'pend_div_perempuan', 'pend_s1_perempuan', 
        'pend_s2_perempuan', 'pend_s3_perempuan',
        // Golongan Laki-laki (UPDATED: tambah Golongan I-XII)
        'gol_ia_laki', 'gol_ib_laki', 'gol_ic_laki', 'gol_id_laki',
        'gol_iia_laki', 'gol_iib_laki', 'gol_iic_laki', 'gol_iid_laki',
        'gol_iiia_laki', 'gol_iiib_laki', 'gol_iiic_laki', 'gol_iiid_laki',
        'gol_iva_laki', 'gol_ivb_laki', 'gol_ivc_laki', 'gol_ivd_laki', 'gol_ive_laki',
        'gol_i_laki', 'gol_ii_laki', 'gol_iii_laki', 'gol_iv_laki', 'gol_v_laki', 
        'gol_vi_laki', 'gol_vii_laki', 'gol_viii_laki', 'gol_ix_laki', 'gol_x_laki', 
        'gol_xi_laki', 'gol_xii_laki',
        // Golongan Perempuan (UPDATED: tambah Golongan I-XII)
        'gol_ia_perempuan', 'gol_ib_perempuan', 'gol_ic_perempuan', 'gol_id_perempuan',
        'gol_iia_perempuan', 'gol_iib_perempuan', 'gol_iic_perempuan', 'gol_iid_perempuan',
        'gol_iiia_perempuan', 'gol_iiib_perempuan', 'gol_iiic_perempuan', 'gol_iiid_perempuan',
        'gol_iva_perempuan', 'gol_ivb_perempuan', 'gol_ivc_perempuan', 'gol_ivd_perempuan', 'gol_ive_perempuan',
        'gol_i_perempuan', 'gol_ii_perempuan', 'gol_iii_perempuan', 'gol_iv_perempuan', 
        'gol_v_perempuan', 'gol_vi_perempuan', 'gol_vii_perempuan', 'gol_viii_perempuan', 
        'gol_ix_perempuan', 'gol_x_perempuan', 'gol_xi_perempuan', 'gol_xii_perempuan',
        // Jabatan Laki-laki
        'jab_2a_laki', 'jab_2b_laki', 'jab_3a_laki', 'jab_3b_laki',
        'jab_4a_laki', 'jab_4b_laki', 'jab_5a_laki',
        // Jabatan Perempuan
        'jab_2a_perempuan', 'jab_2b_perempuan', 'jab_3a_perempuan', 'jab_3b_perempuan',
        'jab_4a_perempuan', 'jab_4b_perempuan', 'jab_5a_perempuan',
        // Agama Laki-laki
        'agama_islam_laki', 'agama_kristen_laki', 'agama_katholik_laki',
        'agama_hindu_laki', 'agama_budha_laki',
        // Agama Perempuan
        'agama_islam_perempuan', 'agama_kristen_perempuan', 'agama_katholik_perempuan',
        'agama_hindu_perempuan', 'agama_budha_perempuan',
        // JF Tertentu PNS (Total tanpa gender)
        'jf_tertentu_pns_i', 'jf_tertentu_pns_ii', 'jf_tertentu_pns_iii', 'jf_tertentu_pns_iv',
        // JF Tertentu PPPK (Total tanpa gender)
        'jf_tertentu_pppk_v', 'jf_tertentu_pppk_vii', 'jf_tertentu_pppk_ix', 
        'jf_tertentu_pppk_x', 'jf_tertentu_pppk_xi',
        // JF Pelaksana PNS (Total tanpa gender)
        'jf_pelaksana_pns_i', 'jf_pelaksana_pns_ii', 'jf_pelaksana_pns_iii', 'jf_pelaksana_pns_iv',
        // JF Pelaksana PPPK (Total tanpa gender)
        'jf_pelaksana_pppk_i', 'jf_pelaksana_pppk_iii', 'jf_pelaksana_pppk_v', 
        'jf_pelaksana_pppk_vii', 'jf_pelaksana_pppk_ix', 'jf_pelaksana_pppk_x',
    ];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];

    // Relationships
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    // Accessors
    public function getNamaBulanAttribute()
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $namaBulan[$this->bulan] ?? $this->bulan;
    }

    // Calculate totals by category
    public function getTotalLakiLakiAttribute()
    {
        return $this->pend_sd_laki + $this->pend_sltp_laki + $this->pend_slta_laki + 
               $this->pend_di_laki + $this->pend_dii_laki + $this->pend_diii_laki + 
               $this->pend_div_laki + $this->pend_s1_laki + $this->pend_s2_laki + 
               $this->pend_s3_laki;
    }

    public function getTotalPerempuanAttribute()
    {
        return $this->pend_sd_perempuan + $this->pend_sltp_perempuan + $this->pend_slta_perempuan + 
               $this->pend_di_perempuan + $this->pend_dii_perempuan + $this->pend_diii_perempuan + 
               $this->pend_div_perempuan + $this->pend_s1_perempuan + $this->pend_s2_perempuan + 
               $this->pend_s3_perempuan;
    }

    public function getTotalAnggotaAttribute()
    {
        return $this->total_laki_laki + $this->total_perempuan;
    }

    // Total by Golongan (UPDATED: tambah Golongan I-XII)
    public function getTotalGolonganLakiAttribute()
    {
        return $this->gol_ia_laki + $this->gol_ib_laki + $this->gol_ic_laki + $this->gol_id_laki +
               $this->gol_iia_laki + $this->gol_iib_laki + $this->gol_iic_laki + $this->gol_iid_laki +
               $this->gol_iiia_laki + $this->gol_iiib_laki + $this->gol_iiic_laki + $this->gol_iiid_laki +
               $this->gol_iva_laki + $this->gol_ivb_laki + $this->gol_ivc_laki + $this->gol_ivd_laki + 
               $this->gol_ive_laki + $this->gol_i_laki + $this->gol_ii_laki + $this->gol_iii_laki + 
               $this->gol_iv_laki + $this->gol_v_laki + $this->gol_vi_laki + $this->gol_vii_laki + 
               $this->gol_viii_laki + $this->gol_ix_laki + $this->gol_x_laki + $this->gol_xi_laki + 
               $this->gol_xii_laki;
    }

    public function getTotalGolonganPerempuanAttribute()
    {
        return $this->gol_ia_perempuan + $this->gol_ib_perempuan + $this->gol_ic_perempuan + $this->gol_id_perempuan +
               $this->gol_iia_perempuan + $this->gol_iib_perempuan + $this->gol_iic_perempuan + $this->gol_iid_perempuan +
               $this->gol_iiia_perempuan + $this->gol_iiib_perempuan + $this->gol_iiic_perempuan + $this->gol_iiid_perempuan +
               $this->gol_iva_perempuan + $this->gol_ivb_perempuan + $this->gol_ivc_perempuan + $this->gol_ivd_perempuan + 
               $this->gol_ive_perempuan + $this->gol_i_perempuan + $this->gol_ii_perempuan + $this->gol_iii_perempuan + 
               $this->gol_iv_perempuan + $this->gol_v_perempuan + $this->gol_vi_perempuan + $this->gol_vii_perempuan + 
               $this->gol_viii_perempuan + $this->gol_ix_perempuan + $this->gol_x_perempuan + $this->gol_xi_perempuan + 
               $this->gol_xii_perempuan;
    }

    // Total by Jabatan
    public function getTotalJabatanLakiAttribute()
    {
        return $this->jab_2a_laki + $this->jab_2b_laki + $this->jab_3a_laki + $this->jab_3b_laki +
               $this->jab_4a_laki + $this->jab_4b_laki + $this->jab_5a_laki;
    }

    public function getTotalJabatanPerempuanAttribute()
    {
        return $this->jab_2a_perempuan + $this->jab_2b_perempuan + $this->jab_3a_perempuan + $this->jab_3b_perempuan +
               $this->jab_4a_perempuan + $this->jab_4b_perempuan + $this->jab_5a_perempuan;
    }

    // Total by Agama
    public function getTotalAgamaLakiAttribute()
    {
        return $this->agama_islam_laki + $this->agama_kristen_laki + $this->agama_katholik_laki +
               $this->agama_hindu_laki + $this->agama_budha_laki;
    }

    public function getTotalAgamaPerempuanAttribute()
    {
        return $this->agama_islam_perempuan + $this->agama_kristen_perempuan + $this->agama_katholik_perempuan +
               $this->agama_hindu_perempuan + $this->agama_budha_perempuan;
    }

    // Total JF Tertentu PNS
    public function getTotalJfTertentuPnsAttribute()
    {
        return $this->jf_tertentu_pns_i + $this->jf_tertentu_pns_ii + 
               $this->jf_tertentu_pns_iii + $this->jf_tertentu_pns_iv;
    }

    // Total JF Tertentu PPPK
    public function getTotalJfTertentuPppkAttribute()
    {
        return $this->jf_tertentu_pppk_v + $this->jf_tertentu_pppk_vii + 
               $this->jf_tertentu_pppk_ix + $this->jf_tertentu_pppk_x + 
               $this->jf_tertentu_pppk_xi;
    }

    // Total JF Pelaksana PNS
    public function getTotalJfPelaksanaPnsAttribute()
    {
        return $this->jf_pelaksana_pns_i + $this->jf_pelaksana_pns_ii + 
               $this->jf_pelaksana_pns_iii + $this->jf_pelaksana_pns_iv;
    }

    // Total JF Pelaksana PPPK
    public function getTotalJfPelaksanaPppkAttribute()
    {
        return $this->jf_pelaksana_pppk_i + $this->jf_pelaksana_pppk_iii + 
               $this->jf_pelaksana_pppk_v + $this->jf_pelaksana_pppk_vii + 
               $this->jf_pelaksana_pppk_ix + $this->jf_pelaksana_pppk_x;
    }

    // Total All JF
    public function getTotalJfAttribute()
    {
        return $this->total_jf_tertentu_pns + $this->total_jf_tertentu_pppk + 
               $this->total_jf_pelaksana_pns + $this->total_jf_pelaksana_pppk;
    }
}