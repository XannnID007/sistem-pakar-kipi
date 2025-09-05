@extends('layouts.app')

@section('content')
<style>
    .card {
        padding: 20px;
        margin-top: 85px;
    }
    h3, h4, h5, h6 {
        font-size: 1.1rem;
    }
    table th, table td {
        font-size: 13px;
        padding: 6px 10px;
        vertical-align: middle;
    }
    .btn {
        font-size: 13px;
        padding: 6px 14px;
    }
</style>

<div class="card shadow-sm mx-auto" style="max-width: 700px;">
    <h5 class="text-center mb-3">Hasil Diagnosa Kejadian Ikutan Pasca Imunisasi (KIPI)</h5>
    <p class="text-center text-muted mb-4">
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
    </p>

    {{-- Tabel Data Anak --}}
    <table class="table table-bordered mb-4">
        <thead class="table-light text-center">
            <tr>
                <th colspan="2">Data Anak</th>
            </tr>
        </thead>
        <tbody>
            <tr><td><strong>Nama Anak</strong></td><td>{{ session('nama_anak', '-') }}</td></tr>
            <tr><td><strong>Jenis Kelamin</strong></td><td>{{ session('jenis_kelamin', '-') }}</td></tr>
            <tr>
                <td><strong>Tanggal Lahir</strong></td>
                <td>{{ \Carbon\Carbon::parse(session('tanggal_lahir'))->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr><td><strong>Usia Anak (bulan)</strong></td><td>{{ session('usia_anak', '-') }}</td></tr>
            <tr><td><strong>Nama Ibu</strong></td><td>{{ session('nama_ibu', '-') }}</td></tr>
            <tr><td><strong>Alamat</strong></td><td>{{ session('alamat', '-') }}</td></tr>
            <tr><td><strong>Jenis Vaksin</strong></td><td>{{ session('jenis_vaksin', '-') }}</td></tr>
            <tr><td><strong>Tempat Imunisasi</strong></td><td>{{ session('tempat_imunisasi', '-') }}</td></tr>
            <tr>
                <td><strong>Tanggal Imunisasi</strong></td>
                <td>{{ \Carbon\Carbon::parse(session('tanggal_imunisasi'))->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Gejala yang Dipilih --}}
    <h6 class="mt-4 mb-2">Gejala yang Dipilih</h6>
    @if (!empty($gejalaDipilih))
        <table class="table table-bordered table-sm">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Gejala</th>
                    <th style="width: 120px;">Keyakinan</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($gejalaDipilih as $index => $g)
        @if ($g['cf_user'] > 0)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $g['nama'] }}</td>
            <td class="text-center">
                @switch($g['cf_user'])
                    @case(1)
                        Yakin - 1
                        @break
                    @case(0.5)
                        Ragu-ragu - 0.5
                        @break
                    @case(0)
                        Tidak yakin - 0
                        @break
                    @default
                        {{ $g['cf_user'] }}
                @endswitch
            </td>
        </tr>
        @endif
    @endforeach
</tbody>

        </table>
    @else
        <p class="text-muted">Tidak ada gejala yang dipilih.</p>
    @endif

    {{-- Hasil Diagnosa --}}
    <h6 class="mt-3 mb-2">Hasil Diagnosa</h6>
    @if (!empty($hasilTerbaik) && isset($hasilTerbaik['cf'], $hasilTerbaik['jenis_kipi']))
        <table class="table table-bordered table-sm">
            <thead class="table-light text-center">
                <tr>
                    <th>Hasil Diagnosa</th>
                    <th>Saran</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center align-middle" style="width: 200px;">
                        <h4 class="text-success fw-bold mb-1">
                            {{ number_format($hasilTerbaik['cf'] * 100, 0) }}%
                        </h4>
                        <small>Kemungkinan KIPI <strong>{{ $hasilTerbaik['jenis_kipi'] }}</strong></small>
                    </td>
                    <td>{{ $hasilTerbaik['saran'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p class="text-muted">Tidak ada hasil diagnosa yang ditampilkan.</p>
    @endif

    {{-- Tombol Simpan --}}
    @if (!empty($hasilTerbaik) && isset($hasilTerbaik['cf'], $hasilTerbaik['jenis_kipi']))
        <form action="{{ route('riwayat.simpan') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="nama_ibu" value="{{ session('nama_ibu') }}">
            <input type="hidden" name="nama_anak" value="{{ session('nama_anak') }}">
            <input type="hidden" name="usia_anak" value="{{ session('usia_anak') }}">
            <input type="hidden" name="diagnosa" value="{{ $hasilTerbaik['jenis_kipi'] }}">
            <input type="hidden" name="nilai_cf" value="{{ $hasilTerbaik['cf'] }}">
            <input type="hidden" name="saran" value="{{ $hasilTerbaik['saran'] }}">
            <input type="hidden" name="gejala_dipilih" value='@json($gejalaDipilih)'>
            <input type="hidden" name="jenis_kelamin" value="{{ session('jenis_kelamin') }}">
            <input type="hidden" name="tanggal_lahir" value="{{ session('tanggal_lahir') }}">
            <input type="hidden" name="alamat" value="{{ session('alamat') }}">
            <input type="hidden" name="jenis_vaksin" value="{{ session('jenis_vaksin') }}">
            <input type="hidden" name="tempat_imunisasi" value="{{ session('tempat_imunisasi') }}">
            <input type="hidden" name="tanggal_imunisasi" value="{{ session('tanggal_imunisasi') }}">

            <button type="submit" class="btn btn-success me-2">Simpan ke Riwayat</button>
        </form>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('diagnosa.ulang') }}" class="btn btn-primary">Diagnosa Ulang</a>
    </div>
</div>
@endsection
