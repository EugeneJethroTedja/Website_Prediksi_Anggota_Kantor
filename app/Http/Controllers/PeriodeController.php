<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = Periode::withCount('dataAnggotaLengkap')->paginate(10);
        return view('periode.index', compact('periode'));
    }

    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255|unique:periode',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Periode::create($validated);

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil ditambahkan!');
    }

    public function show(Periode $periode)
    {
        $periode->load('dataAnggotaLengkap', 'prediksiLengkap');
        
        // Get date range dari data yang ada
        $dataRange = $periode->dataAnggotaLengkap()
            ->selectRaw('MIN(CONCAT(tahun, "-", LPAD(bulan, 2, "0"))) as min_date')
            ->selectRaw('MAX(CONCAT(tahun, "-", LPAD(bulan, 2, "0"))) as max_date')
            ->first();
        
        return view('periode.show', compact('periode', 'dataRange'));
    }

    public function edit(Periode $periode)
    {
        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, Periode $periode)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255|unique:periode,nama_periode,' . $periode->id,
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $periode->update($validated);

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil diupdate!');
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil dihapus!');
    }
}