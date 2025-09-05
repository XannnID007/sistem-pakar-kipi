<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gejala;
use App\Models\KategoriKipi;
use App\Models\Pengetahuan;
use App\Models\RiwayatDiagnosa;
use Carbon\Carbon;
use App\Models\Notifikasi;

class PakarController extends Controller
{
    public function user(Request $request)
    {
        $query = \App\Models\User::where('role', 'pengguna');
    
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
    
        $users = $query->get();
    
        return view('pakar.user', compact('users'));
    }

    public function dashboard()
{
    $jumlahPakar = User::where('role', 'pakar')->count();
    $jumlahUser = User::where('role', 'pengguna')->count();
    $jumlahGejala = Gejala::count();
    $jumlahKategori = KategoriKipi::count();
    $jumlahPengetahuan = Pengetahuan::count();
    $jumlahKipiBeratBelumDibaca = RiwayatDiagnosa::where('diagnosa', 'berat')
    ->where('is_read', false)
    ->count();
    $jumlahKipiRinganSedang = RiwayatDiagnosa::whereIn('diagnosa', ['ringan', 'sedang'])
    ->count();


    return view('pakar.dashboard', compact('jumlahPakar', 'jumlahUser', 'jumlahGejala', 'jumlahKategori', 
    'jumlahKipiBeratBelumDibaca','jumlahKipiRinganSedang','jumlahPengetahuan'));
}
    
    public function index(Request $request)
{
    $query = User::where('role', 'pakar');

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $pakars = $query->get();
   

    return view('pakar.pakar.index', compact('pakars'));
}
public function create()
{
    return view('pakar.pakar.create');
}


    // Simpan pakar baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'pakar',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('pakar.index')->with('success', 'Pakar berhasil ditambahkan.');
    }

    // Form edit pakar
    public function edit($id)
    {
        $pakar = User::findOrFail($id);
        return view('pakar.pakar.edit', compact('pakar'));
    }

    // Update pakar
    public function update(Request $request, $id)
{
    $pakar = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $pakar->id,
        'password' => 'nullable|string|min:6',
    ]);

    $pakar->name = $validated['name'];
    $pakar->email = $validated['email'];

    // Jika password diisi, update password
    if (!empty($validated['password'])) {
        $pakar->password = bcrypt($validated['password']);
    }

    $pakar->save();

    return redirect()->route('pakar.index')->with('success', 'Data pakar berhasil diperbarui.');
}


    // Hapus pakar
    public function destroy($id)
    {
        $pakar = User::findOrFail($id);
        $pakar->delete();
    
        return redirect()->route('pakar.index')->with('success', 'Data pakar berhasil dihapus.');
    }
    public function riwayatDiagnosa()
{
    $riwayatDiagnosa = RiwayatDiagnosa::join('users', 'riwayat_diagnosa.user_id', '=', 'users.id')
        ->where('users.role', 'pengguna') // Hanya yang role-nya pengguna
        ->select('riwayat_diagnosa.*', 'users.name as nama_pengguna')
        ->orderBy('riwayat_diagnosa.tanggal', 'desc')
        ->get();

    return view('pakar.riwayat', compact('riwayatDiagnosa'));
}
public function laporan(Request $request)
{
    $query = RiwayatDiagnosa::join('users', 'riwayat_diagnosa.user_id', '=', 'users.id')
        ->where('users.role', 'pengguna')
        ->select('riwayat_diagnosa.*', 'users.name as nama_ibu')
        ->orderBy('riwayat_diagnosa.tanggal', 'desc');

    // Filter berdasarkan tanggal
    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
        $query->whereBetween('riwayat_diagnosa.tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
    }

    $riwayatDiagnosa = $query->get();

    return view('pakar.laporan', compact('riwayatDiagnosa'));
}
public function cetakLaporan()
{
    // Ambil data diagnosa dari 1 bulan terakhir
    $riwayatDiagnosa = RiwayatDiagnosa::where('tanggal', '>=', now()->subMonth())
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('pakar.laporan_cetak', compact('riwayatDiagnosa'));
}

}


