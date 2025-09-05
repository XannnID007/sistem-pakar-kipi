@extends('layouts.pakar')

@section('content')
<div class="container mt-4 ">
    <h1 class="mb-4">Basis Pengetahuan</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Baris atas: tombol tambah (kiri) & pencarian (kanan) --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Tombol tambah pengetahuan --}}
        <a href="{{ route('pakar.pengetahuan.create') }}" class="btn btn-primary"><i class="fas fa-plus fa-lg"></i> 
            Tambah Data
        </a>

        {{-- Form pencarian --}}
        <form method="GET" action="{{ route('pakar.pengetahuan.index') }}" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari" 
                value="{{ request('search') }}"
                class="form-control"
            >
            <button type="submit" class="btn btn-primary">
                Cari
            </button>
        </form>
    </div>

    @if($pengetahuans->isEmpty())
        <p class="text-center">Belum ada data pengetahuan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped  align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Aturan</th>
                        <th>Gejala</th>
                        <th>Kode Kategori</th>
                        <th>MB</th>
                        <th>MD</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengetahuans as $item)
                    <tr>
                        <td>{{ $item->kode_aturan }}</td>
                        <td>{{ $item->kode_gejala }} {{ $item->gejala->nama ?? '' }}</td>
                        <td>{{ $item->kode_kipi }}</td>
                        <td>{{ rtrim(rtrim($item->mb, '0'), '.') }}</td>
                        <td>{{ rtrim(rtrim($item->md, '0'), '.') }}</td>

                        <td>
                            <a href="{{ route('pakar.pengetahuan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pakar.pengetahuan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
