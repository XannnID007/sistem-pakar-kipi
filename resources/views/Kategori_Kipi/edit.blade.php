@extends('layouts.pakar')

@section('title', 'Edit Kategori KIPI')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Formulir Edit Kategori KIPI</h1>

                {{-- Menggunakan variabel $kategoriKipi dari controller --}}
                <form action="{{ route('pakar.kategori_kipi.update', $kategoriKipi->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="kode" class="block text-sm font-medium text-gray-700">Kode KIPI</label>
                        <input type="text" name="kode" id="kode" value="{{ $kategoriKipi->kode }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="jenis_kipi" class="block text-sm font-medium text-gray-700">Jenis KIPI</label>
                        <input type="text" name="jenis_kipi" id="jenis_kipi" value="{{ $kategoriKipi->jenis_kipi }}"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="saran" class="block text-sm font-medium text-gray-700">Saran Penanganan</label>
                        <textarea name="saran" id="saran" rows="4" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $kategoriKipi->saran }}</textarea>
                    </div>

                    <div class="pt-5 flex justify-end space-x-4">
                        <a href="{{ route('pakar.kategori_kipi.index') }}"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
