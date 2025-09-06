@extends('layouts.pakar')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Gejala Baru</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('pakar.gejala.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="kode" class="block text-sm font-medium text-gray-700">Kode Gejala</label>
                        <input type="text" name="kode" id="kode" value="{{ $kodeBaru }}" readonly
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Gejala</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Contoh: Ruam dan gatal di kulit">
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <a href="{{ route('pakar.gejala.index') }}"
                        class="mr-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">Batal</a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
