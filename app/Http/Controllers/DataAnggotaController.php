<?php

// ============================================
// CONTROLLER 3: DataAnggotaController.php
// app/Http/Controllers/DataAnggotaController.php
// ============================================

namespace App\Http\Controllers;

use App\Models\DataAnggota;
use App\Models\Instansi;
use Illuminate\Http\Request;

class DataAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = DataAnggota::with('instansi');
        
        // Filter berdasarkan instansi
        if ($request->filled('instansi_id')) {
            $query->where('instansi_id', $request->instansi_id);
        }
        
        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        
        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        
        // Pencarian
        if ($request->filled('search')) {
            $query->whereHas('instansi', function($q) use ($request) {
                $q->where('nama_instansi', 'like', '%' . $request->search . '%');
            });
        }
        
        $dataAnggota = $query->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(15);
        
        $allInstansi = Instansi::all();
        
        return view('data-anggota.index', compact('dataAnggota', 'allInstansi'));
    }

    public function create()
    {
        $instansi = Instansi::all();
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return view('data-anggota.create', compact('instansi', 'bulanList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansi,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_perempuan' => 'required|integer|min:0',
            'jumlah_laki_laki' => 'required|integer|min:0',
            'rata_rata_gaji' => 'required|numeric|min:0'
        ]);

        // Cek apakah data untuk bulan dan tahun tersebut sudah ada
        $exists = DataAnggota::where('instansi_id', $validated['instansi_id'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'bulan' => 'Data untuk bulan dan tahun ini sudah ada!'
            ])->withInput();
        }

        DataAnggota::create($validated);

        return redirect()->route('data-anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function edit(DataAnggota $dataAnggotum)
    {
        $instansi = Instansi::all();
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return view('data-anggota.edit', compact('dataAnggotum', 'instansi', 'bulanList'));
    }

    public function update(Request $request, DataAnggota $dataAnggotum)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansi,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_perempuan' => 'required|integer|min:0',
            'jumlah_laki_laki' => 'required|integer|min:0',
            'rata_rata_gaji' => 'required|numeric|min:0'
        ]);

        $dataAnggotum->update($validated);

        return redirect()->route('data-anggota.index')
            ->with('success', 'Data anggota berhasil diupdate!');
    }

    public function destroy(DataAnggota $dataAnggotum)
    {
        $dataAnggotum->delete();

        return redirect()->route('data-anggota.index')
            ->with('success', 'Data anggota berhasil dihapus!');
    }
}