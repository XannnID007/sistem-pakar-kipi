<?php

namespace App\Http\Controllers;

use App\Models\KategoriKipi;
use Illuminate\Http\Request;

class KategoriKipiController extends Controller
{
    public function index()
    {
        $kategori = KategoriKipi::all();
        return view('kategori_kipi.index', compact('kategori'));
    }
    public function create()
    {
        $last = KategoriKipi::orderBy('id', 'desc')->first();
        $nextNumber = $last ? intval(substr($last->kode, 1)) + 1 : 1;
        $kodeBaru = 'K' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    
        return view('kategori_kipi.create', compact('kodeBaru'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kategori_kipis,kode',
            'jenis_kipi' => 'required|string',
            'saran' => 'required|string',
        ]);
    
        KategoriKipi::create([
            'kode' => $request->kode,
            'jenis_kipi' => $request->jenis_kipi,
            'saran' => $request->saran,
        ]);
    
        return redirect()->route('pakar.kategori_kipi.index')->with('success', 'Kategori KIPI berhasil ditambah');
    }
    
    public function edit(KategoriKipi $kategoriKipi)
    {
        return view('kategori_kipi.edit', compact('kategoriKipi'));
    }

    public function update(Request $request, KategoriKipi $kategoriKipi)
{
    $request->validate([
        'kode' => 'required|unique:kategori_kipis,kode,' . $kategoriKipi->id,
        'jenis_kipi' => 'required|string',
        'saran' => 'required|string',
    ]);

    $kategoriKipi->update($request->all());

    return redirect()->route('pakar.kategori_kipi.index')->with('success', 'Kategori KIPI berhasil diubah');
}

    public function destroy(KategoriKipi $kategoriKipi)
    {
        $kategoriKipi->delete();
        return redirect()->route('pakar.kategori_kipi.index')->with('success', 'Kategori KIPI berhasil dihapus');
    }
}
