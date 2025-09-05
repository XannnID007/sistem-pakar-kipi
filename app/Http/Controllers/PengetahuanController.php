<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengetahuan;
use App\Models\Gejala;

class PengetahuanController extends Controller
{
    public function index(Request $request)
{
    $keyword = $request->input('search');

    $pengetahuans = Pengetahuan::with('gejala')
        ->when($keyword, function ($query, $keyword) {
            $query->where('kode_aturan', 'like', "%{$keyword}%")
                  ->orWhere('kode_kipi', 'like', "%{$keyword}%")
                  ->orWhereHas('gejala', function ($q) use ($keyword) {
                      $q->where('nama', 'like', "%{$keyword}%")
                        ->orWhere('kode', 'like', "%{$keyword}%");
                  });
        })
        ->orderBy('kode_aturan')
        ->get();

    return view('pakar.pengetahuan.index', compact('pengetahuans'));
}

public function create()
{
    // Generate kode aturan otomatis
    $last = Pengetahuan::orderBy('kode_aturan', 'desc')->first();

    if ($last) {
        $num = (int) substr($last->kode_aturan, 1) + 1;
    } else {
        $num = 1;
    }
    $newKodeaturan = 'R' . str_pad($num, 3, '0', STR_PAD_LEFT);

    // Generate kode gejala otomatis
    $lastGejala = Pengetahuan::orderBy('kode_gejala', 'desc')->first();
    if ($lastGejala) {
        $numGejala = (int) substr($lastGejala->kode_gejala, 1) + 1;
    } else {
        $numGejala = 1;
    }
    $newKodeGejala = 'G' . str_pad($numGejala, 3, '0', STR_PAD_LEFT);

    // Ambil nama gejala berdasarkan kode
    $nama = Gejala::where('kode', $newKodeGejala)->value('nama');
    
    // Gabungkan hanya untuk ditampilkan di tampilan (tidak untuk disimpan ke DB)
    $kodenama = $nama ? $newKodeGejala . ' - ' . $nama : $newKodeGejala;
    
    // Kirim ke view
    return view('pakar.pengetahuan.create', compact('newKodeaturan', 'newKodeGejala', 'kodenama'));
}    


    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aturan' => 'required|string|unique:pengetahuan,kode_aturan',
            'kode_kipi' => 'required|string',
            'kode_gejala' => 'required|string',
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1',
        ]);

        Pengetahuan::create($validated);

        return redirect()->route('pakar.pengetahuan.index')->with('success', 'Pengetahuan berhasil ditambahkan.');
    }
    public function edit($id)
{
    $pengetahuan = Pengetahuan::findOrFail($id);
    return view('pakar.pengetahuan.edit', compact('pengetahuan'));
}

public function destroy($id)
{
    Pengetahuan::findOrFail($id)->delete();
    return redirect()->route('pakar.pengetahuan.index')->with('success', 'Data berhasil dihapus.');
}
public function update(Request $request, $id)
{
    $pengetahuan = Pengetahuan::findOrFail($id);

    $validated = $request->validate([
        // kode_aturan biasanya tidak boleh diubah, tapi jika ingin validasi:
        'kode_aturan' => 'required|string|unique:pengetahuan,kode_aturan,' . $pengetahuan->id,
        'kode_kipi' => 'required|string',
        'kode_gejala' => 'required|string',
        'mb' => 'required|numeric|min:0|max:1',
        'md' => 'required|numeric|min:0|max:1',
    ]);

    $pengetahuan->update($validated);

    return redirect()->route('pakar.pengetahuan.index')->with('success', 'Data pengetahuan berhasil diperbarui.');
}


}
