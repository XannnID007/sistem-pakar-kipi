<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;
use App\Models\Pengetahuan;
use Illuminate\Support\Facades\Log;

class DiagnosisController extends Controller
{
    public function showDataForm()
    {
        
        return view('user.diagnosa.data_form');
    }

    public function storeData(Request $request)
    {
        $request->validate([
            'nama_ibu'        => 'required|string|max:255',
            'nama_anak'       => 'required|string|max:255',
            'usia_anak'       => 'required|integer|min:0|max:60',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'   => 'required|date',
            'alamat'          => 'required|string|max:500',
            'jenis_vaksin'    => 'required|string|max:255',
            'tempat_imunisasi'=> 'required|string|max:255',
            'tanggal_imunisasi'=> 'required|date',
        ]);
    
        session([
            'nama_ibu'        => $request->nama_ibu,
            'nama_anak'       => $request->nama_anak,
            'usia_anak'       => $request->usia_anak,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'alamat'          => $request->alamat,
            'jenis_vaksin'    => $request->jenis_vaksin,
            'tempat_imunisasi'=> $request->tempat_imunisasi,
            'tanggal_imunisasi'=> $request->tanggal_imunisasi,
        ]);
    
        return redirect()->route('diagnosa.gejala');
    }
    

    public function showGejalaForm()
    {
        $gejalas = Gejala::all(); 
        return view('user.diagnosa.gejala_form', compact('gejalas'));
    }

    public function prosesDiagnosa(Request $request)
    {

        $inputGejala = $request->input('gejala');
        Log::info('Input gejala dari user:', $inputGejala); 
        $gejalaDipilih = []; 

if (!$inputGejala || count($inputGejala) === 0) {
    return redirect()->back()->with('error', 'Silakan pilih minimal satu gejala.');
}

$kodeGejalaDipilih = array_keys($inputGejala);
$data = Pengetahuan::whereIn('kode_gejala', $kodeGejalaDipilih)->get();
$kelompok = $data->groupBy('kode_kipi');

$hasilDiagnosa = [];
Log::info('Input gejala user:', $inputGejala);
foreach ($kelompok as $kodeKipi => $aturan) {
    $cfCombine = null;
    Log::info("Memproses KIPI: $kodeKipi");
    foreach ($aturan as $item) {
        $cfUser = floatval($inputGejala[$item->kode_gejala]['jawaban'] ?? 0);
        
        $mb = floatval($item->mb) * $cfUser;
        $md = floatval($item->md) * $cfUser;
        $cf  = $mb - $md;
        
        Log::info("Diagnosa - KIPI: {$kodeKipi}, Gejala: {$item->kode_gejala}, MB: {$item->mb}, MD: {$item->md}, cfUser: {$cfUser}, CF: {$cf}");

        // Gabungkan CF dengan rumus certainty factor
        if (is_null($cfCombine)) {
            $cfCombine = $cf;
        } else {
            $cfCombine = $cfCombine + ($cf * (1 - $cfCombine));
        }
    }

    if (!is_null($cfCombine)) {
        $hasilDiagnosa[] = [
            'kode_kipi'  => $kodeKipi,
            'cf'         => round($cfCombine, 4),
            'jenis_kipi' => $aturan->first()->kategoriKipi->jenis_kipi ?? 'Tidak Diketahui',
            'saran'      => $aturan->first()->kategoriKipi->saran ?? '-',
        ];
    }
}

// Urutkan berdasarkan CF tertinggi
usort($hasilDiagnosa, fn($a, $b) => $b['cf'] <=> $a['cf']);
$hasilTerbaik = $hasilDiagnosa[0] ?? null;

// Ambil gejala yang dipilih
$gejalaDipilih = [];

foreach ($inputGejala as $kode => $jawaban) {
    $gejala = Gejala::where('kode', $kode)->first();
    if ($gejala) {
        $gejalaDipilih[] = [
            'kode'     => $kode,
            'nama'     => $gejala->nama,
            'cf_user'  => floatval($jawaban['jawaban']),
        ];
    }
}
session(['gejala_dipilih' => $gejalaDipilih]);

return view('user.diagnosa.hasil', compact('hasilDiagnosa', 'hasilTerbaik', 'gejalaDipilih'));


    }
    // Jangan pakai huruf kapital, dan pastikan sesuai dengan route
public function diagnosaUlang()
{
    if (!session()->has('nama_ibu') || !session()->has('nama_anak') || !session()->has('usia_anak')) {
        return redirect()->route('diagnosa.data_form')->with('error', 'Silakan isi data diri terlebih dahulu.');
    }

    $gejalas = \App\Models\Gejala::all();

    return view('user.diagnosa.gejala_form', compact('gejalas'));
}

}
