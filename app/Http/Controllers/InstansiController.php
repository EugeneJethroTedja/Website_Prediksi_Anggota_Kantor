<?php

// ============================================
// CONTROLLER 2: InstansiController.php
// app/Http/Controllers/InstansiController.php
// ============================================

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        $instansi = Instansi::withCount('dataAnggota')->paginate(10);
        return view('instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('instansi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        Instansi::create($validated);

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil ditambahkan!');
    }

    public function show(Instansi $instansi)
    {
        $instansi->load('dataAnggota');
        return view('instansi.show', compact('instansi'));
    }

    public function edit(Instansi $instansi)
    {
        return view('instansi.edit', compact('instansi'));
    }

    public function update(Request $request, Instansi $instansi)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        $instansi->update($validated);

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil diupdate!');
    }

    public function destroy(Instansi $instansi)
    {
        $instansi->delete();

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil dihapus!');
    }
}
