<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrediksiLengkap extends Model
{
    use HasFactory;

    protected $table = 'prediksi_lengkap';

    protected $fillable = [
        'periode_id', 'bulan', 'tahun', 'confidence_score', 'prediction_method',
        // Pendidikan Prediksi
        'pred_pend_sd_laki', 'pred_pend_sltp_laki', 'pred_pend_slta_laki', 'pred_pend_di_laki',
        'pred_pend_dii_laki', 'pred_pend_diii_laki', 'pred_pend_div_laki', 'pred_pend_s1_laki', 
        'pred_pend_s2_laki', 'pred_pend_s3_laki',
        'pred_pend_sd_perempuan', 'pred_pend_sltp_perempuan', 'pred_pend_slta_perempuan', 'pred_pend_di_perempuan',
        'pred_pend_dii_perempuan', 'pred_pend_diii_perempuan', 'pred_pend_div_perempuan', 'pred_pend_s1_perempuan', 
        'pred_pend_s2_perempuan', 'pred_pend_s3_perempuan',
        // Golongan Prediksi (UPDATED: tambah golongan I-XII)
        'pred_gol_ia_laki', 'pred_gol_ib_laki', 'pred_gol_ic_laki', 'pred_gol_id_laki',
        'pred_gol_iia_laki', 'pred_gol_iib_laki', 'pred_gol_iic_laki', 'pred_gol_iid_laki',
        'pred_gol_iiia_laki', 'pred_gol_iiib_laki', 'pred_gol_iiic_laki', 'pred_gol_iiid_laki',
        'pred_gol_iva_laki', 'pred_gol_ivb_laki', 'pred_gol_ivc_laki', 'pred_gol_ivd_laki', 'pred_gol_ive_laki',
        'pred_gol_i_laki', 'pred_gol_ii_laki', 'pred_gol_iii_laki', 'pred_gol_iv_laki', 'pred_gol_v_laki', 
        'pred_gol_vi_laki', 'pred_gol_vii_laki', 'pred_gol_viii_laki', 'pred_gol_ix_laki', 'pred_gol_x_laki', 
        'pred_gol_xi_laki', 'pred_gol_xii_laki',
        'pred_gol_ia_perempuan', 'pred_gol_ib_perempuan', 'pred_gol_ic_perempuan', 'pred_gol_id_perempuan',
        'pred_gol_iia_perempuan', 'pred_gol_iib_perempuan', 'pred_gol_iic_perempuan', 'pred_gol_iid_perempuan',
        'pred_gol_iiia_perempuan', 'pred_gol_iiib_perempuan', 'pred_gol_iiic_perempuan', 'pred_gol_iiid_perempuan',
        'pred_gol_iva_perempuan', 'pred_gol_ivb_perempuan', 'pred_gol_ivc_perempuan', 'pred_gol_ivd_perempuan', 'pred_gol_ive_perempuan',
        'pred_gol_i_perempuan', 'pred_gol_ii_perempuan', 'pred_gol_iii_perempuan', 'pred_gol_iv_perempuan', 
        'pred_gol_v_perempuan', 'pred_gol_vi_perempuan', 'pred_gol_vii_perempuan', 'pred_gol_viii_perempuan', 
        'pred_gol_ix_perempuan', 'pred_gol_x_perempuan', 'pred_gol_xi_perempuan', 'pred_gol_xii_perempuan',
        // Jabatan Prediksi
        'pred_jab_2a_laki', 'pred_jab_2b_laki', 'pred_jab_3a_laki', 'pred_jab_3b_laki',
        'pred_jab_4a_laki', 'pred_jab_4b_laki', 'pred_jab_5a_laki',
        'pred_jab_2a_perempuan', 'pred_jab_2b_perempuan', 'pred_jab_3a_perempuan', 'pred_jab_3b_perempuan',
        'pred_jab_4a_perempuan', 'pred_jab_4b_perempuan', 'pred_jab_5a_perempuan',
        // Agama Prediksi
        'pred_agama_islam_laki', 'pred_agama_kristen_laki', 'pred_agama_katholik_laki',
        'pred_agama_hindu_laki', 'pred_agama_budha_laki',
        'pred_agama_islam_perempuan', 'pred_agama_kristen_perempuan', 'pred_agama_katholik_perempuan',
        'pred_agama_hindu_perempuan', 'pred_agama_budha_perempuan',
        // JF Tertentu PNS Predictions
        'pred_jf_tertentu_pns_i', 'pred_jf_tertentu_pns_ii', 'pred_jf_tertentu_pns_iii', 'pred_jf_tertentu_pns_iv',
        // JF Tertentu PPPK Predictions
        'pred_jf_tertentu_pppk_v', 'pred_jf_tertentu_pppk_vii', 'pred_jf_tertentu_pppk_ix', 
        'pred_jf_tertentu_pppk_x', 'pred_jf_tertentu_pppk_xi',
        // JF Pelaksana PNS Predictions
        'pred_jf_pelaksana_pns_i', 'pred_jf_pelaksana_pns_ii', 'pred_jf_pelaksana_pns_iii', 'pred_jf_pelaksana_pns_iv',
        // JF Pelaksana PPPK Predictions
        'pred_jf_pelaksana_pppk_i', 'pred_jf_pelaksana_pppk_iii', 'pred_jf_pelaksana_pppk_v', 
        'pred_jf_pelaksana_pppk_vii', 'pred_jf_pelaksana_pppk_ix', 'pred_jf_pelaksana_pppk_x',
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

    public function getPredictionMethodNameAttribute()
    {
        $methods = [
            'combined' => 'Combined Methods (Hybrid)',
            'exponential_smoothing' => 'Exponential Smoothing',
            'linear_trend' => 'Linear Trend Analysis',
            'weighted_moving_average' => 'Weighted Moving Average',
            'arima' => 'ARIMA (Auto-Regressive Integrated Moving Average)'
        ];
        return $methods[$this->prediction_method] ?? 'Unknown';
    }

    // Calculate prediction totals
    public function getTotalPrediksiLakiLakiAttribute()
    {
        $fields = [
            'pred_pend_sd_laki', 'pred_pend_sltp_laki', 'pred_pend_slta_laki', 'pred_pend_di_laki',
            'pred_pend_dii_laki', 'pred_pend_diii_laki', 'pred_pend_div_laki', 'pred_pend_s1_laki', 
            'pred_pend_s2_laki', 'pred_pend_s3_laki'
        ];
        return round(array_sum(array_map(fn($field) => $this->$field ?? 0, $fields)));
    }

    public function getTotalPrediksiPerempuanAttribute()
    {
        $fields = [
            'pred_pend_sd_perempuan', 'pred_pend_sltp_perempuan', 'pred_pend_slta_perempuan', 'pred_pend_di_perempuan',
            'pred_pend_dii_perempuan', 'pred_pend_diii_perempuan', 'pred_pend_div_perempuan', 'pred_pend_s1_perempuan', 
            'pred_pend_s2_perempuan', 'pred_pend_s3_perempuan'
        ];
        return round(array_sum(array_map(fn($field) => $this->$field ?? 0, $fields)));
    }

    public function getTotalPrediksiAttribute()
    {
        return $this->total_prediksi_laki_laki + $this->total_prediksi_perempuan;
    }

    // Total Prediksi JF Tertentu PNS
    public function getTotalPrediksiJfTertentuPnsAttribute()
    {
        return round(($this->pred_jf_tertentu_pns_i ?? 0) + ($this->pred_jf_tertentu_pns_ii ?? 0) + 
                    ($this->pred_jf_tertentu_pns_iii ?? 0) + ($this->pred_jf_tertentu_pns_iv ?? 0));
    }

    // Total Prediksi JF Tertentu PPPK
    public function getTotalPrediksiJfTertentuPppkAttribute()
    {
        return round(($this->pred_jf_tertentu_pppk_v ?? 0) + ($this->pred_jf_tertentu_pppk_vii ?? 0) + 
                    ($this->pred_jf_tertentu_pppk_ix ?? 0) + ($this->pred_jf_tertentu_pppk_x ?? 0) + 
                    ($this->pred_jf_tertentu_pppk_xi ?? 0));
    }

    // Total Prediksi JF Pelaksana PNS
    public function getTotalPrediksiJfPelaksanaPnsAttribute()
    {
        return round(($this->pred_jf_pelaksana_pns_i ?? 0) + ($this->pred_jf_pelaksana_pns_ii ?? 0) + 
                    ($this->pred_jf_pelaksana_pns_iii ?? 0) + ($this->pred_jf_pelaksana_pns_iv ?? 0));
    }

    // Total Prediksi JF Pelaksana PPPK
    public function getTotalPrediksiJfPelaksanaPppkAttribute()
    {
        return round(($this->pred_jf_pelaksana_pppk_i ?? 0) + ($this->pred_jf_pelaksana_pppk_iii ?? 0) + 
                    ($this->pred_jf_pelaksana_pppk_v ?? 0) + ($this->pred_jf_pelaksana_pppk_vii ?? 0) + 
                    ($this->pred_jf_pelaksana_pppk_ix ?? 0) + ($this->pred_jf_pelaksana_pppk_x ?? 0));
    }

    // Total All Prediksi JF
    public function getTotalPrediksiJfAttribute()
    {
        return $this->total_prediksi_jf_tertentu_pns + $this->total_prediksi_jf_tertentu_pppk + 
               $this->total_prediksi_jf_pelaksana_pns + $this->total_prediksi_jf_pelaksana_pppk;
    }
}