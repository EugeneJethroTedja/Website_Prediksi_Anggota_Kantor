<?php

namespace App\Http\Controllers;

use App\Models\DataAnggotaLengkap;
use App\Models\Periode;
use Illuminate\Http\Request;

class DataAnggotaLengkapController extends Controller
{
    public function index(Request $request)
    {
        $query = DataAnggotaLengkap::with('periode');

        // Filter by periode
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $dataAnggota = $query->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(15);

        $periodeList = Periode::all();
        $tahunList = DataAnggotaLengkap::distinct('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('data-anggota-lengkap.index', compact('dataAnggota', 'periodeList', 'tahunList'));
    }

    public function create()
    {
        $periode = Periode::where('is_active', true)->get();
        $bulanList = $this->getBulanList();
        
        // Data structure untuk form
        $pendidikanList = ['SD', 'SLTP', 'SLTA', 'DI', 'DII', 'DIII', 'DIV', 'S1', 'S2', 'S3'];
        
        // UPDATED: Golongan lengkap dengan I-XII
        $golonganList = [
            'I/A', 'I/B', 'I/C', 'I/D',
            'II/A', 'II/B', 'II/C', 'II/D',
            'III/A', 'III/B', 'III/C', 'III/D',
            'IV/A', 'IV/B', 'IV/C', 'IV/D', 'IV/E',
            'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
        ];
        
        $jabatanList = ['2A', '2B', '3A', '3B', '4A', '4B', '5A'];
        $agamaList = ['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha'];
        
        // JF Lists
        $jfTertentuPnsList = ['I', 'II', 'III', 'IV'];
        $jfTertentuPppkList = ['V', 'VII', 'IX', 'X', 'XI'];
        $jfPelaksanaPnsList = ['I', 'II', 'III', 'IV'];
        $jfPelaksanaPppkList = ['I', 'III', 'V', 'VII', 'IX', 'X'];
        
        return view('data-anggota-lengkap.create', compact(
            'periode', 'bulanList', 'pendidikanList', 'golonganList', 'jabatanList', 'agamaList',
            'jfTertentuPnsList', 'jfTertentuPppkList', 'jfPelaksanaPnsList', 'jfPelaksanaPppkList'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        // Check duplicate
        $exists = DataAnggotaLengkap::where('periode_id', $validated['periode_id'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'bulan' => 'Data untuk periode, bulan dan tahun ini sudah ada!'
            ])->withInput();
        }

        DataAnggotaLengkap::create($validated);

        return redirect()->route('data-anggota-lengkap.index')
            ->with('success', 'Data anggota lengkap berhasil ditambahkan!');
    }

    public function show(DataAnggotaLengkap $dataAnggotaLengkap)
    {
        $dataAnggotaLengkap->load('periode');
        
        // Prepare data for display
        $dataPendidikan = $this->preparePendidikanData($dataAnggotaLengkap);
        $dataGolongan = $this->prepareGolonganData($dataAnggotaLengkap);
        $dataJabatan = $this->prepareJabatanData($dataAnggotaLengkap);
        $dataAgama = $this->prepareAgamaData($dataAnggotaLengkap);
        
        // Prepare JF data
        $dataJfTertentuPns = $this->prepareJfTertentuPnsData($dataAnggotaLengkap);
        $dataJfTertentuPppk = $this->prepareJfTertentuPppkData($dataAnggotaLengkap);
        $dataJfPelaksanaPns = $this->prepareJfPelaksanaPnsData($dataAnggotaLengkap);
        $dataJfPelaksanaPppk = $this->prepareJfPelaksanaPppkData($dataAnggotaLengkap);
        
        return view('data-anggota-lengkap.show', compact(
            'dataAnggotaLengkap', 'dataPendidikan', 'dataGolongan', 'dataJabatan', 'dataAgama',
            'dataJfTertentuPns', 'dataJfTertentuPppk', 'dataJfPelaksanaPns', 'dataJfPelaksanaPppk'
        ));
    }

    public function edit(DataAnggotaLengkap $dataAnggotaLengkap)
    {
        $periode = Periode::where('is_active', true)->get();
        $bulanList = $this->getBulanList();
        
        $pendidikanList = ['SD', 'SLTP', 'SLTA', 'DI', 'DII', 'DIII', 'DIV', 'S1', 'S2', 'S3'];
        
        // UPDATED: Golongan lengkap dengan I-XII
        $golonganList = [
            'I/A', 'I/B', 'I/C', 'I/D',
            'II/A', 'II/B', 'II/C', 'II/D',
            'III/A', 'III/B', 'III/C', 'III/D',
            'IV/A', 'IV/B', 'IV/C', 'IV/D', 'IV/E',
            'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
        ];
        
        $jabatanList = ['2A', '2B', '3A', '3B', '4A', '4B', '5A'];
        $agamaList = ['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha'];
        
        // JF Lists
        $jfTertentuPnsList = ['I', 'II', 'III', 'IV'];
        $jfTertentuPppkList = ['V', 'VII', 'IX', 'X', 'XI'];
        $jfPelaksanaPnsList = ['I', 'II', 'III', 'IV'];
        $jfPelaksanaPppkList = ['I', 'III', 'V', 'VII', 'IX', 'X'];
        
        return view('data-anggota-lengkap.edit', compact(
            'dataAnggotaLengkap', 'periode', 'bulanList', 
            'pendidikanList', 'golonganList', 'jabatanList', 'agamaList',
            'jfTertentuPnsList', 'jfTertentuPppkList', 'jfPelaksanaPnsList', 'jfPelaksanaPppkList'
        ));
    }

    public function update(Request $request, DataAnggotaLengkap $dataAnggotaLengkap)
    {
        $validated = $this->validateData($request);

        $dataAnggotaLengkap->update($validated);

        return redirect()->route('data-anggota-lengkap.index')
            ->with('success', 'Data anggota lengkap berhasil diupdate!');
    }

    public function destroy(DataAnggotaLengkap $dataAnggotaLengkap)
    {
        $dataAnggotaLengkap->delete();

        return redirect()->route('data-anggota-lengkap.index')
            ->with('success', 'Data anggota lengkap berhasil dihapus!');
    }

    // PRIVATE HELPER METHODS

    private function validateData(Request $request)
    {
        $rules = [
            'periode_id' => 'required|exists:periode,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
        ];

        // Pendidikan
        foreach (['sd', 'sltp', 'slta', 'di', 'dii', 'diii', 'div', 's1', 's2', 's3'] as $pend) {
            $rules["pend_{$pend}_laki"] = 'required|integer|min:0';
            $rules["pend_{$pend}_perempuan"] = 'required|integer|min:0';
        }

        // Golongan (UPDATED: lengkap dengan I-XII)
        $golonganFields = [
            'ia', 'ib', 'ic', 'id', 'iia', 'iib', 'iic', 'iid', 
            'iiia', 'iiib', 'iiic', 'iiid', 'iva', 'ivb', 'ivc', 'ivd', 'ive',
            'i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii'
        ];
        foreach ($golonganFields as $gol) {
            $rules["gol_{$gol}_laki"] = 'required|integer|min:0';
            $rules["gol_{$gol}_perempuan"] = 'required|integer|min:0';
        }

        // Jabatan
        foreach (['2a', '2b', '3a', '3b', '4a', '4b', '5a'] as $jab) {
            $rules["jab_{$jab}_laki"] = 'required|integer|min:0';
            $rules["jab_{$jab}_perempuan"] = 'required|integer|min:0';
        }

        // Agama
        foreach (['islam', 'kristen', 'katholik', 'hindu', 'budha'] as $agama) {
            $rules["agama_{$agama}_laki"] = 'required|integer|min:0';
            $rules["agama_{$agama}_perempuan"] = 'required|integer|min:0';
        }

        // JF Tertentu PNS
        foreach (['i', 'ii', 'iii', 'iv'] as $jf) {
            $rules["jf_tertentu_pns_{$jf}"] = 'required|integer|min:0';
        }

        // JF Tertentu PPPK
        foreach (['v', 'vii', 'ix', 'x', 'xi'] as $jf) {
            $rules["jf_tertentu_pppk_{$jf}"] = 'required|integer|min:0';
        }

        // JF Pelaksana PNS
        foreach (['i', 'ii', 'iii', 'iv'] as $jf) {
            $rules["jf_pelaksana_pns_{$jf}"] = 'required|integer|min:0';
        }

        // JF Pelaksana PPPK
        foreach (['i', 'iii', 'v', 'vii', 'ix', 'x'] as $jf) {
            $rules["jf_pelaksana_pppk_{$jf}"] = 'required|integer|min:0';
        }

        return $request->validate($rules);
    }

    private function getBulanList()
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    }

    private function preparePendidikanData($data)
    {
        return [
            'SD' => ['laki' => $data->pend_sd_laki, 'perempuan' => $data->pend_sd_perempuan],
            'SLTP' => ['laki' => $data->pend_sltp_laki, 'perempuan' => $data->pend_sltp_perempuan],
            'SLTA' => ['laki' => $data->pend_slta_laki, 'perempuan' => $data->pend_slta_perempuan],
            'DI' => ['laki' => $data->pend_di_laki, 'perempuan' => $data->pend_di_perempuan],
            'DII' => ['laki' => $data->pend_dii_laki, 'perempuan' => $data->pend_dii_perempuan],
            'DIII' => ['laki' => $data->pend_diii_laki, 'perempuan' => $data->pend_diii_perempuan],
            'DIV' => ['laki' => $data->pend_div_laki, 'perempuan' => $data->pend_div_perempuan],
            'S1' => ['laki' => $data->pend_s1_laki, 'perempuan' => $data->pend_s1_perempuan],
            'S2' => ['laki' => $data->pend_s2_laki, 'perempuan' => $data->pend_s2_perempuan],
            'S3' => ['laki' => $data->pend_s3_laki, 'perempuan' => $data->pend_s3_perempuan],
        ];
    }

    private function prepareGolonganData($data)
    {
        // UPDATED: lengkap dengan I-XII
        $golonganMap = [
            'I/A' => 'ia', 'I/B' => 'ib', 'I/C' => 'ic', 'I/D' => 'id',
            'II/A' => 'iia', 'II/B' => 'iib', 'II/C' => 'iic', 'II/D' => 'iid',
            'III/A' => 'iiia', 'III/B' => 'iiib', 'III/C' => 'iiic', 'III/D' => 'iiid',
            'IV/A' => 'iva', 'IV/B' => 'ivb', 'IV/C' => 'ivc', 'IV/D' => 'ivd', 'IV/E' => 'ive',
            'I' => 'i', 'II' => 'ii', 'III' => 'iii', 'IV' => 'iv', 'V' => 'v', 
            'VI' => 'vi', 'VII' => 'vii', 'VIII' => 'viii', 'IX' => 'ix', 
            'X' => 'x', 'XI' => 'xi', 'XII' => 'xii'
        ];

        $golongan = [];
        foreach ($golonganMap as $label => $field) {
            $golongan[$label] = [
                'laki' => $data->{"gol_{$field}_laki"},
                'perempuan' => $data->{"gol_{$field}_perempuan"}
            ];
        }
        return $golongan;
    }

    private function prepareJabatanData($data)
    {
        $jabatan = [];
        foreach (['2a', '2b', '3a', '3b', '4a', '4b', '5a'] as $jab) {
            $jabatan[strtoupper($jab)] = [
                'laki' => $data->{"jab_{$jab}_laki"},
                'perempuan' => $data->{"jab_{$jab}_perempuan"}
            ];
        }
        return $jabatan;
    }

    private function prepareAgamaData($data)
    {
        return [
            'Islam' => ['laki' => $data->agama_islam_laki, 'perempuan' => $data->agama_islam_perempuan],
            'Kristen' => ['laki' => $data->agama_kristen_laki, 'perempuan' => $data->agama_kristen_perempuan],
            'Katholik' => ['laki' => $data->agama_katholik_laki, 'perempuan' => $data->agama_katholik_perempuan],
            'Hindu' => ['laki' => $data->agama_hindu_laki, 'perempuan' => $data->agama_hindu_perempuan],
            'Budha' => ['laki' => $data->agama_budha_laki, 'perempuan' => $data->agama_budha_perempuan],
        ];
    }

    private function prepareJfTertentuPnsData($data)
    {
        return [
            'I' => $data->jf_tertentu_pns_i,
            'II' => $data->jf_tertentu_pns_ii,
            'III' => $data->jf_tertentu_pns_iii,
            'IV' => $data->jf_tertentu_pns_iv,
        ];
    }

    private function prepareJfTertentuPppkData($data)
    {
        return [
            'V' => $data->jf_tertentu_pppk_v,
            'VII' => $data->jf_tertentu_pppk_vii,
            'IX' => $data->jf_tertentu_pppk_ix,
            'X' => $data->jf_tertentu_pppk_x,
            'XI' => $data->jf_tertentu_pppk_xi,
        ];
    }

    private function prepareJfPelaksanaPnsData($data)
    {
        return [
            'I' => $data->jf_pelaksana_pns_i,
            'II' => $data->jf_pelaksana_pns_ii,
            'III' => $data->jf_pelaksana_pns_iii,
            'IV' => $data->jf_pelaksana_pns_iv,
        ];
    }

    private function prepareJfPelaksanaPppkData($data)
    {
        return [
            'I' => $data->jf_pelaksana_pppk_i,
            'III' => $data->jf_pelaksana_pppk_iii,
            'V' => $data->jf_pelaksana_pppk_v,
            'VII' => $data->jf_pelaksana_pppk_vii,
            'IX' => $data->jf_pelaksana_pppk_ix,
            'X' => $data->jf_pelaksana_pppk_x,
        ];
    }
}