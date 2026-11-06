<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prediksi_lengkap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            
            // PREDIKSI PENDIDIKAN - Laki-laki
            $table->decimal('pred_pend_sd_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_sltp_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_slta_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_di_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_dii_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_diii_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_div_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_s1_laki', 10, 2)->default(0);
            $table->decimal('pred_pend_s2_laki', 10, 2)->default(0);
            
            // PREDIKSI PENDIDIKAN - Perempuan
            $table->decimal('pred_pend_sd_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_sltp_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_slta_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_di_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_dii_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_diii_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_div_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_s1_perempuan', 10, 2)->default(0);
            $table->decimal('pred_pend_s2_perempuan', 10, 2)->default(0);
            
            // PREDIKSI GOLONGAN - Laki-laki
            $table->decimal('pred_gol_ia_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_ib_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_ic_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_id_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iia_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iib_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iic_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iid_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iiia_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iiib_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iiic_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iiid_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_iva_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_ivb_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_ivc_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_ivd_laki', 10, 2)->default(0);
            $table->decimal('pred_gol_ive_laki', 10, 2)->default(0);
            
            // PREDIKSI GOLONGAN - Perempuan
            $table->decimal('pred_gol_ia_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_ib_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_ic_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_id_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iia_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iib_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iic_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iid_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iiia_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iiib_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iiic_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iiid_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_iva_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_ivb_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_ivc_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_ivd_perempuan', 10, 2)->default(0);
            $table->decimal('pred_gol_ive_perempuan', 10, 2)->default(0);
            
            // PREDIKSI JABATAN ESELON - Laki-laki
            $table->decimal('pred_jab_2a_laki', 10, 2)->default(0);
            $table->decimal('pred_jab_2b_laki', 10, 2)->default(0);
            $table->decimal('pred_jab_3a_laki', 10, 2)->default(0);
            $table->decimal('pred_jab_3b_laki', 10, 2)->default(0);
            $table->decimal('pred_jab_4a_laki', 10, 2)->default(0);
            $table->decimal('pred_jab_4b_laki', 10, 2)->default(0);
            $table->decimal('pred_jab_5a_laki', 10, 2)->default(0);
            
            // PREDIKSI JABATAN ESELON - Perempuan
            $table->decimal('pred_jab_2a_perempuan', 10, 2)->default(0);
            $table->decimal('pred_jab_2b_perempuan', 10, 2)->default(0);
            $table->decimal('pred_jab_3a_perempuan', 10, 2)->default(0);
            $table->decimal('pred_jab_3b_perempuan', 10, 2)->default(0);
            $table->decimal('pred_jab_4a_perempuan', 10, 2)->default(0);
            $table->decimal('pred_jab_4b_perempuan', 10, 2)->default(0);
            $table->decimal('pred_jab_5a_perempuan', 10, 2)->default(0);
            
            // PREDIKSI AGAMA - Laki-laki
            $table->decimal('pred_agama_islam_laki', 10, 2)->default(0);
            $table->decimal('pred_agama_kristen_laki', 10, 2)->default(0);
            $table->decimal('pred_agama_katholik_laki', 10, 2)->default(0);
            $table->decimal('pred_agama_hindu_laki', 10, 2)->default(0);
            $table->decimal('pred_agama_budha_laki', 10, 2)->default(0);
            
            // PREDIKSI AGAMA - Perempuan
            $table->decimal('pred_agama_islam_perempuan', 10, 2)->default(0);
            $table->decimal('pred_agama_kristen_perempuan', 10, 2)->default(0);
            $table->decimal('pred_agama_katholik_perempuan', 10, 2)->default(0);
            $table->decimal('pred_agama_hindu_perempuan', 10, 2)->default(0);
            $table->decimal('pred_agama_budha_perempuan', 10, 2)->default(0);
            
            $table->decimal('confidence_score', 5, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['periode_id', 'bulan', 'tahun'], 'unique_prediksi_periode_bulan_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi_lengkap');
    }
};