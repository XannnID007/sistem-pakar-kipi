@extends('layouts.pakar')

@section('content')
<div class="container">
    <h2>Edit Kategori KIPI</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pakar.kategori_kipi.update', $kategoriKipi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" name="kode" id="kode" class="form-control" value="{{ old('kode', $kategoriKipi->kode) }}" required>
        </div>

        <div class="mb-3">
            <label for="jenis_kipi" class="form-label">Jenis KIPI</label>
            <input type="text" name="jenis_kipi" id="jenis_kipi" class="form-control" value="{{ old('jenis_kipi', $kategoriKipi->jenis_kipi) }}" required>
        </div>

        <div class="mb-3">
            <label for="saran" class="form-label">Saran</label>
            <textarea name="saran" id="saran" class="form-control" rows="3" required>{{ old('saran', $kategoriKipi->saran) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('pakar.kategori_kipi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
