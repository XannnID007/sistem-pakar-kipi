@extends('layouts.pakar')

@section('content')
<div class="container mb-3">
    <h1>Gejala</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol tambah gejala --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <a href="{{ route('pakar.gejala.create') }}" class="btn btn-primary "><i class="fas fa-plus fa-lg"></i> Tambah Data</a>

    {{-- Form pencarian --}}
        <form method="GET" action="{{ route('pakar.gejala.index') }}" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari gejala" 
                value="{{ request('search') }}"
                class="form-control"
            >
            <button type="submit" class="btn btn-primary">
                Cari
            </button>
        </form>
    </div>


    {{-- Tabel daftar gejala --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Gejala</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gejalas as $gejala)
                <tr>
                    <td>{{ $gejala->kode }}</td>
                    <td>{{ $gejala->nama }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <a href="{{ route('pakar.gejala.edit', $gejala->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit</a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('pakar.gejala.destroy', $gejala->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus gejala ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
