@extends('layouts.pakar')

@section('content')
<div class="container mt-4">
    <h3>Tambah Pengetahuan Baru</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pakar.pengetahuan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kode_aturan" class="form-label">Kode Basis</label>
            <input type="text" name="kode_aturan" id="kode_aturan" 
                class="form-control" value="{{ $newKodeaturan }}" readonly>
        </div>

        <input type="text" name="kode_gejala" value="{{ $newKodeGejala }}" readonly>
<p class="text-muted">Nama gejala: {{ $kodenama }}</p>

            
        <div class="mb-3">
            <label for="kode_kipi" class="form-label">Kode Kipi</label>
            <input type="text" class="form-control" id="kode_kipi" name="kode_kipi" value="{{ old('kode_kipi') }}" required>
        </div>

        <div class="mb-3">
            <label for="mb" class="form-label">MB (0 - 1)</label>
            <input type="number" step="0.1" min="0" max="1" class="form-control" id="mb" name="mb" value="{{ old('mb') }}" required>
        </div>

        <div class="mb-3">
            <label for="md" class="form-label">MD (0 - 1)</label>
            <input type="number" step="0.1" min="0" max="1" class="form-control" id="md" name="md" value="{{ old('md') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
