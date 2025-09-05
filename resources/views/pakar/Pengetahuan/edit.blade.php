@extends('layouts.pakar')

@section('content')
<div class="container mt-4">
    <h3>Edit Pengetahuan</h3>

    <form action="{{ route('pakar.pengetahuan.update', $pengetahuan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kode_aturan" class="form-label">Kode Aturan</label>
            <input type="text" name="kode_aturan" id="kode_aturan" class="form-control @error('kode_aturan') is-invalid @enderror"
                value="{{ old('kode_aturan', $pengetahuan->kode_aturan) }}" readonly>
            @error('kode_aturan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kode_gejala" class="form-label">Gejala</label>
            <input type="text" name="kode_gejala" id="kode_gejala" class="form-control @error('kode_gejala') is-invalid @enderror"
                value="{{ old('kode_gejala', $pengetahuan->kode_gejala) }}" required>
            @error('kode_gejala')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kode_kipi" class="form-label">Kategori KIPI</label>
            <select name="kode_kipi" id="kode_kipi" class="form-select @error('kode_kipi') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="K001" {{ old('kode_kipi', $pengetahuan->kode_kipi) == 'K001' ? 'selected' : '' }}>Ringan</option>
                <option value="K002" {{ old('kode_kipi', $pengetahuan->kode_kipi) == 'K002' ? 'selected' : '' }}>Sedang</option>
                <option value="K003" {{ old('kode_kipi', $pengetahuan->kode_kipi) == 'K003' ? 'selected' : '' }}>Berat</option>
            </select>
            @error('kode_kipi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="mb" class="form-label">MB (Measure of Belief)</label>
            <input type="number" step="0.1" min="0" max="1" name="mb" id="mb" class="form-control @error('mb') is-invalid @enderror"
                value="{{ old('mb', $pengetahuan->mb) }}" required>
            @error('mb')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="md" class="form-label">MD (Measure of Disbelief)</label>
            <input type="number" step="0.
            1" min="0" max="1" name="md" id="md" class="form-control @error('md') is-invalid @enderror"
                value="{{ old('md', $pengetahuan->md) }}" required>
            @error('md')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('pakar.pengetahuan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
