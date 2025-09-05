<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        $query = Gejala::query();
    
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
        }
    
        $gejalas = $query->orderBy('kode')->get();
    
        return view('pakar.gejala.index', compact('gejalas'));
    }
    
    public function create()
    {
        // Ambil data terakhir
        $last = Gejala::orderBy('id', 'desc')->first();

        // Hitung nomor berikutnya
        $nextNumber = $last ? intval(substr($last->kode, 1)) + 1 : 1;

        // Buat kode format G001, G002, dst
        $kodeBaru = 'G' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('pakar.gejala.create', compact('kodeBaru'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'kode' => 'required|unique:gejalas,kode',
            'nama' => 'required|string|max:255|unique:gejalas,nama',
        ], [
            'kode.unique' => 'Kode gejala sudah digunakan.',
            'nama.unique' => 'Nama gejala sudah ada.',
        ]);

        // Simpan ke database
        Gejala::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('pakar.gejala.index')->with('success', 'Data gejala berhasil ditambah');
    }

    public function edit(Gejala $gejala)
    {
        return view('pakar.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, Gejala $gejala)
    {
        // Validasi, perbolehkan kode/nama sama jika milik sendiri
        $request->validate([
            'kode' => 'required|unique:gejalas,kode,' . $gejala->id,
            'nama' => 'required|string|max:255|unique:gejalas,nama,' . $gejala->id,
        ]);

        $gejala->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('pakar.gejala.index')->with('success', 'Data gejala berhasil diubah');
    }

    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return redirect()->route('pakar.gejala.index')->with('success', 'Data gejala berhasil dihapus');
    }
}
