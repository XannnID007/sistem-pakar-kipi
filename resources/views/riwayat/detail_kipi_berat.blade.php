@extends('layouts.pakar')

@section('content')

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header text-white text-center" style="background-color: rgb(21, 140, 156);">
            <h4 class="mb-0">Detail Diagnosa KIPI Berat</h4>
        </div>
        <div class="card-body">

            <h5 class="mb-3">Data Anak</h5>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr><th>Nama Anak</th><td>{{ $riwayat->nama_anak ?? '-' }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ $riwayat->jenis_kelamin ?? '-' }}</td></tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>
                            {{ $riwayat->tanggal_lahir 
                                ? \Carbon\Carbon::parse($riwayat->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') 
                                : '-' }}
                        </td>
                    </tr>
                    <tr><th>Usia Anak (bulan)</th><td>{{ $riwayat->usia_anak ?? '-' }} bulan</td></tr>
                    <tr><th>Nama Ibu</th><td>{{ $riwayat->nama_ibu ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $riwayat->alamat ?? '-' }}</td></tr>
                </tbody>
            </table>

            <h5 class="mt-4 mb-3">Data Imunisasi</h5>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr><th>Jenis Vaksin</th><td>{{ $riwayat->jenis_vaksin ?? '-' }}</td></tr>
                    <tr><th>Tempat Imunisasi</th><td>{{ $riwayat->tempat_imunisasi ?? '-' }}</td></tr>
                    <tr>
                        <th>Tanggal Imunisasi</th>
                        <td>
                            {{ $riwayat->tanggal_imunisasi 
                                ? \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->locale('id')->isoFormat('D MMMM Y') 
                                : '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mt-4 mb-3">Gejala yang Dipilih</h5>
            @php
                $filteredGejala = collect($gejala)->filter(fn($item) => $item['cf_user'] != 0 && $item['cf_user'] != 0.5);
            @endphp

            @if($filteredGejala->isNotEmpty())
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Gejala</th>
                            <th>Tingkat Keyakinan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filteredGejala as $index => $g)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $g['nama'] ?? '-' }}</td>
                                <td>
                                    @switch($g['cf_user'])
                                        @case(1)
                                            Yakin - 1
                                            @break
                                        @default
                                            {{ $g['cf_user'] }}
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Tidak ada gejala dengan keyakinan tinggi yang dipilih.</p>
            @endif

            <h5 class="mt-4 mb-2">Hasil Diagnosa</h5>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Hasil Diagnosa</th>
                        <th>Saran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ isset($riwayat->nilai_cf) ? number_format($riwayat->nilai_cf * 100, 2) . '%' : '-' }}
                            <br>kemungkinan KIPI {{ $riwayat->diagnosa ?? '-' }}
                        </td>
                        <td>{{ $riwayat->saran ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <form method="POST" action="{{ route('pakar.riwayat.berat.kirim', $riwayat->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        📤 Kirim Laporan
                    </button>
                </form>
                <a href="{{ route('riwayat.kipi_berat') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
