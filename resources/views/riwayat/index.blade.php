@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Diagnosa Anak</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Ibu</th>
                <th>Nama Anak</th>
                <th>Usia Anak</th>
                <th>Diagnosa</th>
                <th>Nilai CF</th>
                <th>Saran</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $item)
                <tr>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->nama_ibu }}</td>
                    <td>{{ $item->nama_anak }}</td>
                    <td>{{ $item->usia_anak }}</td>
                    <td>{{ $item->diagnosa }}</td>
                    <td>{{ number_format($item->nilai_cf * 100, 2) }}%</td>
                    <td>{{ $item->saran }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('riwayat.show', $item->id) }}" class="btn btn-sm btn-info">Lihat Detail</a>
                            <form action="{{ route('riwayat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada riwayat diagnosa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3 text-end w-100">
    <a href="{{ route('dashboard.user') }}" class="btn btn-secondary">Kembali</a>
</div>
</div>
@endsection
