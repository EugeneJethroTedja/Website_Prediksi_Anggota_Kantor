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
        Schema::create('data_anggota_lengkap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            
            // PENDIDIKAN - Laki-laki
            $table->integer('pend_sd_laki')->default(0);
            $table->integer('pend_sltp_laki')->default(0);
            $table->integer('pend_slta_laki')->default(0);
            $table->integer('pend_di_laki')->default(0);
            $table->integer('pend_dii_laki')->default(0);
            $table->integer('pend_diii_laki')->default(0);
            $table->integer('pend_div_laki')->default(0);
            $table->integer('pend_s1_laki')->default(0);
            $table->integer('pend_s2_laki')->default(0);
            
            // PENDIDIKAN - Perempuan
            $table->integer('pend_sd_perempuan')->default(0);
            $table->integer('pend_sltp_perempuan')->default(0);
            $table->integer('pend_slta_perempuan')->default(0);
            $table->integer('pend_di_perempuan')->default(0);
            $table->integer('pend_dii_perempuan')->default(0);
            $table->integer('pend_diii_perempuan')->default(0);
            $table->integer('pend_div_perempuan')->default(0);
            $table->integer('pend_s1_perempuan')->default(0);
            $table->integer('pend_s2_perempuan')->default(0);
            
            // GOLONGAN - Laki-laki
            $table->integer('gol_ia_laki')->default(0);
            $table->integer('gol_ib_laki')->default(0);
            $table->integer('gol_ic_laki')->default(0);
            $table->integer('gol_id_laki')->default(0);
            $table->integer('gol_iia_laki')->default(0);
            $table->integer('gol_iib_laki')->default(0);
            $table->integer('gol_iic_laki')->default(0);
            $table->integer('gol_iid_laki')->default(0);
            $table->integer('gol_iiia_laki')->default(0);
            $table->integer('gol_iiib_laki')->default(0);
            $table->integer('gol_iiic_laki')->default(0);
            $table->integer('gol_iiid_laki')->default(0);
            $table->integer('gol_iva_laki')->default(0);
            $table->integer('gol_ivb_laki')->default(0);
            $table->integer('gol_ivc_laki')->default(0);
            $table->integer('gol_ivd_laki')->default(0);
            $table->integer('gol_ive_laki')->default(0);
            
            // GOLONGAN - Perempuan
            $table->integer('gol_ia_perempuan')->default(0);
            $table->integer('gol_ib_perempuan')->default(0);
            $table->integer('gol_ic_perempuan')->default(0);
            $table->integer('gol_id_perempuan')->default(0);
            $table->integer('gol_iia_perempuan')->default(0);
            $table->integer('gol_iib_perempuan')->default(0);
            $table->integer('gol_iic_perempuan')->default(0);
            $table->integer('gol_iid_perempuan')->default(0);
            $table->integer('gol_iiia_perempuan')->default(0);
            $table->integer('gol_iiib_perempuan')->default(0);
            $table->integer('gol_iiic_perempuan')->default(0);
            $table->integer('gol_iiid_perempuan')->default(0);
            $table->integer('gol_iva_perempuan')->default(0);
            $table->integer('gol_ivb_perempuan')->default(0);
            $table->integer('gol_ivc_perempuan')->default(0);
            $table->integer('gol_ivd_perempuan')->default(0);
            $table->integer('gol_ive_perempuan')->default(0);
            
            // JABATAN ESELON - Laki-laki
            $table->integer('jab_2a_laki')->default(0);
            $table->integer('jab_2b_laki')->default(0);
            $table->integer('jab_3a_laki')->default(0);
            $table->integer('jab_3b_laki')->default(0);
            $table->integer('jab_4a_laki')->default(0);
            $table->integer('jab_4b_laki')->default(0);
            $table->integer('jab_5a_laki')->default(0);
            
            // JABATAN ESELON - Perempuan
            $table->integer('jab_2a_perempuan')->default(0);
            $table->integer('jab_2b_perempuan')->default(0);
            $table->integer('jab_3a_perempuan')->default(0);
            $table->integer('jab_3b_perempuan')->default(0);
            $table->integer('jab_4a_perempuan')->default(0);
            $table->integer('jab_4b_perempuan')->default(0);
            $table->integer('jab_5a_perempuan')->default(0);
            
            // AGAMA - Laki-laki
            $table->integer('agama_islam_laki')->default(0);
            $table->integer('agama_kristen_laki')->default(0);
            $table->integer('agama_katholik_laki')->default(0);
            $table->integer('agama_hindu_laki')->default(0);
            $table->integer('agama_budha_laki')->default(0);
            
            // AGAMA - Perempuan
            $table->integer('agama_islam_perempuan')->default(0);
            $table->integer('agama_kristen_perempuan')->default(0);
            $table->integer('agama_katholik_perempuan')->default(0);
            $table->integer('agama_hindu_perempuan')->default(0);
            $table->integer('agama_budha_perempuan')->default(0);
            
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi data periode-bulan-tahun
            $table->unique(['periode_id', 'bulan', 'tahun'], 'unique_periode_bulan_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_anggota_lengkap');
    }
};