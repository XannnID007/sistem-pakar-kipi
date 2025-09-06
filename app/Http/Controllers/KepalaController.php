<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKepala;
use App\Models\RiwayatDiagnosa;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KepalaController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanKepala::query();

        // Hanya laporan yang mengandung 'Ringan_dan_Sedang' dalam nama file
        $query->where('nama_file', 'like', '%Ringan_dan_Sedang%');

        // Pencarian jika ada input query dari user (opsional)
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_file', 'like', '%' . $request->q . '%')
                    ->orWhereDate('created_at', $request->q);
            });
        }

        $laporan = $query->latest()->get();

        return view('kepala.laporan_kipi', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = LaporanKepala::findOrFail($id);
        return redirect(asset($laporan->file_path));
    }

    public function destroy($id)
    {
        $laporan = LaporanKepala::findOrFail($id);

        // Hapus file dari storage jika ada
        $filePath = public_path($laporan->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function indexBerat(Request $request)
    {
        $query = LaporanKepala::query();

        // Filter hanya laporan KIPI Berat berdasarkan nama file
        $query->where('nama_file', 'like', '%KIPI_Berat%');

        // Jika ada input pencarian
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_file', 'like', '%' . $request->q . '%')
                    ->orWhereDate('created_at', $request->q);
            });
        }

        $laporan = $query->latest()->get();

        return view('kepala.laporan_kipi_berat', compact('laporan'));
    }

    public function destroyLaporanBerat($id)
    {
        $laporan = LaporanKepala::find($id);
        if (!$laporan) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        // Hapus file dari storage jika ada
        if (Storage::exists('public/laporan/' . $laporan->nama_file)) {
            Storage::delete('public/laporan/' . $laporan->nama_file);
        }

        // Hapus dari database
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function statistik(Request $request)
    {
        // Default periode: 30 hari terakhir
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Validasi tanggal
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // 1. Total kasus per kategori
        $totalKasus = RiwayatDiagnosa::whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN LOWER(diagnosa) LIKE "%ringan%" THEN 1 ELSE 0 END) as ringan,
                SUM(CASE WHEN LOWER(diagnosa) LIKE "%sedang%" THEN 1 ELSE 0 END) as sedang,
                SUM(CASE WHEN LOWER(diagnosa) LIKE "%berat%" THEN 1 ELSE 0 END) as berat
            ')
            ->first();

        // 2. Tren kasus per bulan (6 bulan terakhir)
        $trenBulanan = RiwayatDiagnosa::selectRaw('
                DATE_FORMAT(tanggal, "%Y-%m") as bulan,
                COUNT(*) as total_kasus,
                SUM(CASE WHEN LOWER(diagnosa) LIKE "%berat%" THEN 1 ELSE 0 END) as kasus_berat
            ')
            ->where('tanggal', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // 3. Distribusi usia anak
        $distribusiUsia = RiwayatDiagnosa::whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('
                CASE 
                    WHEN usia_anak <= 6 THEN "0-6 bulan"
                    WHEN usia_anak <= 12 THEN "7-12 bulan"
                    WHEN usia_anak <= 24 THEN "13-24 bulan"
                    WHEN usia_anak <= 36 THEN "25-36 bulan"
                    ELSE "37+ bulan"
                END as kelompok_usia,
                COUNT(*) as jumlah
            ')
            ->groupBy('kelompok_usia')
            ->orderByRaw('
                CASE kelompok_usia
                    WHEN "0-6 bulan" THEN 1
                    WHEN "7-12 bulan" THEN 2
                    WHEN "13-24 bulan" THEN 3
                    WHEN "25-36 bulan" THEN 4
                    ELSE 5
                END
            ')
            ->get();

        // 4. Distribusi berdasarkan jenis kelamin
        $distribusiGender = RiwayatDiagnosa::whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('jenis_kelamin, COUNT(*) as jumlah')
            ->groupBy('jenis_kelamin')
            ->get();

        // 5. Top 5 jenis vaksin yang sering terkait KIPI
        $topVaksin = RiwayatDiagnosa::whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('jenis_vaksin, COUNT(*) as jumlah_kasus')
            ->groupBy('jenis_vaksin')
            ->orderBy('jumlah_kasus', 'desc')
            ->limit(5)
            ->get();

        // 6. Tingkat kesembuhan/follow up
        $statusPenanganan = RiwayatDiagnosa::whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('
                COUNT(*) as total_kasus,
                SUM(CASE WHEN is_read = 1 THEN 1 ELSE 0 END) as sudah_ditangani,
                SUM(CASE WHEN is_read = 0 AND LOWER(diagnosa) LIKE "%berat%" THEN 1 ELSE 0 END) as berat_belum_ditangani
            ')
            ->first();

        // 7. Rata-rata CF (Certainty Factor) per kategori
        $rataRataCF = RiwayatDiagnosa::whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('
                AVG(CASE WHEN LOWER(diagnosa) LIKE "%ringan%" THEN nilai_cf END) as cf_ringan,
                AVG(CASE WHEN LOWER(diagnosa) LIKE "%sedang%" THEN nilai_cf END) as cf_sedang,
                AVG(CASE WHEN LOWER(diagnosa) LIKE "%berat%" THEN nilai_cf END) as cf_berat
            ')
            ->first();

        // 8. Jumlah pengguna aktif
        $penggunaAktif = User::where('role', 'pengguna')
            ->whereHas('riwayatDiagnosa', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->count();

        // 9. Tren harian (7 hari terakhir)
        $trenHarian = RiwayatDiagnosa::selectRaw('
                DATE(tanggal) as tanggal,
                COUNT(*) as total_kasus
            ')
            ->where('tanggal', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('kepala.statistik', compact([
            'totalKasus',
            'trenBulanan',
            'distribusiUsia',
            'distribusiGender',
            'topVaksin',
            'statusPenanganan',
            'rataRataCF',
            'penggunaAktif',
            'trenHarian',
            'startDate',
            'endDate'
        ]));
    }
}
