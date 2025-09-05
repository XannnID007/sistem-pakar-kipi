<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatDiagnosa;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Mail;
use App\Models\LaporanKepala;
use Carbon\Carbon;

class RiwayatDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatDiagnosa::where('user_id', Auth::id());
    
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
    
        if ($request->filled('diagnosa')) {
            $query->where('diagnosa', $request->diagnosa); // ← Tambahan filter diagnosa
        }
    
        $riwayat = $query->orderBy('tanggal', 'desc')->get();
    
        return view('riwayat.index', compact('riwayat'));
    }
    

    public function simpan(Request $request)
    {
        $gejalaDipilih = $request->input('gejala_dipilih', []);
    
        // Cek apakah sudah ada diagnosa serupa yang disimpan hari ini
        $existing = RiwayatDiagnosa::where('user_id', Auth::id())
            ->whereDate('tanggal', now())
            ->where('diagnosa', $request->diagnosa)
            ->first();
    
        if (!$existing) {
            RiwayatDiagnosa::create([
                'user_id'           => Auth::id(),
                'nama_ibu'          => $request->nama_ibu,
                'nama_anak'         => $request->nama_anak,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'usia_anak'         => $request->usia_anak,
                'alamat'            => $request->alamat,
                'jenis_vaksin'      => $request->jenis_vaksin,
                'tempat_imunisasi'  => $request->tempat_imunisasi,
                'tanggal_imunisasi' => $request->tanggal_imunisasi,
                'tanggal'           => now(),
                'diagnosa'          => $request->diagnosa,
                'nilai_cf'          => $request->nilai_cf,
                'saran'             => $request->saran,
                'gejala_dipilih'    => $gejalaDipilih, // sudah json di hidden input
            ]);
        }
    
        return redirect()->route('riwayat.index')->with('success', 'Diagnosa berhasil disimpan ke riwayat.');
    }
    
    public function show($id)
    {
        $riwayat = RiwayatDiagnosa::findOrFail($id);

        // Decode gejala_dipilih
        $gejalaDipilih = json_decode($riwayat->gejala_dipilih, true);
        if (is_string($gejalaDipilih)) {
            $gejalaDipilih = json_decode($gejalaDipilih, true);
        }

        $hasilTerbaik = [
            'jenis_kipi' => $riwayat->diagnosa,
            'cf'         => $riwayat->nilai_cf,
            'saran'      => $riwayat->saran
        ];

        return view('riwayat.show', compact('riwayat', 'gejalaDipilih', 'hasilTerbaik'));
    }

    public function destroy($id)
    {
        $riwayat = RiwayatDiagnosa::findOrFail($id);
        $riwayat->delete();

        return redirect()->route('riwayat.index')->with('success', 'Riwayat diagnosa berhasil dihapus.');
    }

    public function cetak($id)
{
    $riwayat = RiwayatDiagnosa::findOrFail($id);
    $gejalaDipilih = json_decode($riwayat->gejala_dipilih, true);
    if (is_string($gejalaDipilih)) {
        $gejalaDipilih = json_decode($gejalaDipilih, true);
    }
    // Ambil langsung dari kolom yang ada
    $hasilTerbaik = [
        'jenis_kipi' => $riwayat->diagnosa,
        'cf' => $riwayat->nilai_cf,
        'saran' => $riwayat->saran,
    ];

    return view('riwayat.cetak', compact('riwayat', 'gejalaDipilih', 'hasilTerbaik'));
}
public function kipiBerat()
{
    RiwayatDiagnosa::where('diagnosa', 'berat')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    $riwayats = RiwayatDiagnosa::where('diagnosa', 'berat')->latest()->get();

    return view('riwayat.kipi_berat', compact('riwayats'));
}

public function kipi(Request $request)
{
    $query = RiwayatDiagnosa::query();

    if ($request->filled('kategori')) {
        $query->where('diagnosa', $request->kategori);
    } else {
        $query->whereIn('diagnosa', ['ringan', 'sedang']);
    }

    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('tanggal', $request->tahun);
    }

    $riwayat = $query->latest()->get();

    return view('riwayat.kipi', compact('riwayat'));
}

public function detailBerat($id)
{
    $riwayat = RiwayatDiagnosa::findOrFail($id);

    // Ambil gejala dari riwayat
    $gejala = [];
    if (is_string($riwayat->gejala_dipilih)) {
        $gejala = json_decode($riwayat->gejala_dipilih, true);
    }
    

    return view('riwayat.detail_kipi_berat', compact('riwayat', 'gejala'));
}
public function print(Request $request)
{
    $query = RiwayatDiagnosa::query();

    if ($request->filled('kategori')) {
        $query->where('diagnosa', $request->kategori);
    } else {
        $query->whereIn('diagnosa', ['ringan', 'sedang']);
    }

    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('tanggal', $request->tahun);
    }

    $riwayat = $query->latest()->get();

    return view('riwayat.kipi_print', compact('riwayat', 'request'));
}


// app/Http/Controllers/RiwayatDiagnosaController.php



public function kirim(Request $request)
{
    $bulan = $request->bulan; // format angka: 01 - 12
    $tahun = $request->tahun;

    // Ambil hanya diagnosa ringan dan sedang
    $riwayat = RiwayatDiagnosa::whereIn('diagnosa', ['Ringan', 'Sedang'])
        ->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
            return $query->whereMonth('tanggal', $bulan)
                         ->whereYear('tanggal', $tahun);
        })->get();

    // Dapatkan nama bulan dalam bahasa Indonesia
    $namaBulan = $bulan ? Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM') : 'Semua';
    $periode = $bulan && $tahun ? "{$namaBulan}_{$tahun}" : ($tahun ? "Tahun_{$tahun}" : 'Semua_Periode');

    // Penamaan file secara eksplisit
    $namaFile = "Laporan_KIPI_Ringan_dan_Sedang_{$periode}_" . now()->format('Ymd_His') . ".pdf";
    $filePath = 'storage/laporan/' . $namaFile;

    // Generate PDF
    $pdf = Pdf::loadView('riwayat.laporan_pdf', [
        'riwayat' => $riwayat,
        'kategori' => 'Ringan_dan_Sedang',
        'request' => $request,
    ])->setPaper('A4', 'landscape');

    // Simpan PDF
    $pdf->save(public_path($filePath));

    // Simpan info file ke database
    LaporanKepala::create([
        'file_path' => $filePath,
        'nama_file' => $namaFile,
    ]);

    return redirect()->back()->with('success', 'Laporan berhasil dikirim ke kepala puskesmas.');
}


public function kirimKIPIBerat($id)
{
    $riwayat = RiwayatDiagnosa::findOrFail($id);

    // Validasi: pastikan hanya KIPI Berat yang dikirim
    if (strtolower($riwayat->kategori) !== 'berat') {
        return redirect()->back()->with('error', 'Hanya data dengan kategori KIPI Berat yang dapat dikirim.');
    }

    $gejala = json_decode($riwayat->gejala_dipilih, true);

    // Penamaan file dengan label jelas
    $namaFile = 'Laporan_KIPI_Berat_' . now()->format('Ymd_His') . '.pdf';
    $filePath = 'storage/laporan/' . $namaFile;

    // Generate PDF dari view detail diagnosa
    $pdf = Pdf::loadView('riwayat.laporan_kipi_berat_pdf', [
        'riwayat' => $riwayat,
        'gejala' => $gejala,
    ])->setPaper('A4', 'portrait');

    // Simpan file ke folder publik
    $pdf->save(public_path($filePath));

    // Simpan metadata laporan ke DB
    LaporanKepala::create([
        'riwayat_id' => $riwayat->id, // kalau ada kolom ini di tabel laporan_kepala
        'file_path' => $filePath,
        'nama_file' => $namaFile,
    ]);

    return redirect()->route('riwayat.kipi_berat')->with('success', 'Laporan KIPI Berat berhasil dikirim ke kepala puskesmas.');
}
}
