@extends('layouts.pakar')

@section('title', 'Tambah Kategori KIPI')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Formulir Kategori KIPI Baru</h1>

                <form action="{{ route('pakar.kategori_kipi.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="kode" class="block text-sm font-medium text-gray-700">Kode KIPI</label>
                        {{-- Menggunakan variabel $kodeBaru dari controller --}}
                        <input type="text" name="kode" id="kode" value="{{ $kodeBaru }}" readonly
                            class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm">
                    </div>

                    <div>
                        <label for="jenis_kipi" class="block text-sm font-medium text-gray-700">Jenis KIPI</label>
                        <input type="text" name="jenis_kipi" id="jenis_kipi" value="{{ old('jenis_kipi') }}" required
                            placeholder="Contoh: Ringan, Sedang, atau Berat"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="saran" class="block text-sm font-medium text-gray-700">Saran Penanganan</label>
                        <textarea name="saran" id="saran" rows="4" required
                            placeholder="Masukkan saran penanganan untuk kategori KIPI ini..."
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('saran') }}</textarea>
                    </div>

                    <div class="pt-5 flex justify-end space-x-4">
                        <a href="{{ route('pakar.kategori_kipi.index') }}"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">Simpan
                            Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
