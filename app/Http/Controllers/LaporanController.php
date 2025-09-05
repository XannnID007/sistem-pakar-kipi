<?php

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\RiwayatDiagnosa;
class LapranController extends Controller
{
public function cetakLaporan()
{
    $tanggalAwal = now()->subDays(30); // 30 hari ke belakang
    $tanggalAkhir = now();

    $riwayatDiagnosa = RiwayatDiagnosa::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                            ->orderBy('tanggal', 'desc')
                            ->get();

    return view('pakar.laporan_cetak', compact('riwayatDiagnosa', 'tanggalAwal', 'tanggalAkhir'));
}
}