@extends('layouts.kepala')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: rgb(21, 140, 156)">
            <h4 class="mb-0">Laporan KIPI Berat</h4>
        </div>
        <div class="card-body">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger" id="error-alert">{{ session('error') }}</div>
            @endif

            {{-- Script auto-close alert --}}
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert') || document.getElementById('error-alert');
                    if (alert) {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3000);
            </script>

            {{-- Form pencarian --}}
            <form method="GET" action="{{ route('kepala.laporan.berat') }}" class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama file atau tanggal">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn text-white w-100" style="background-color: rgb(21, 140, 156)">🔍 Cari</button>
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Tanggal Kirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_file }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ asset('storage/laporan/' . $item->nama_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                </a>
                                <form method="POST" action="{{ route('kepala.laporan.berat.destroy', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada laporan KIPI berat yang dikirim.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
