@extends('layouts.pakar')

@section('title', 'Edit Aturan Pengetahuan')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Formulir Edit Aturan Pengetahuan</h1>

                {{-- Form ini sekarang hanya menggunakan variabel $pengetahuan --}}
                <form action="{{ route('pakar.pengetahuan.update', $pengetahuan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="kode_aturan" class="block text-sm font-medium text-gray-700">Kode Aturan</label>
                        <input type="text" name="kode_aturan" id="kode_aturan" value="{{ $pengetahuan->kode_aturan }}"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="kode_kipi" class="block text-sm font-medium text-gray-700">Kode KIPI</label>
                        <input type="text" name="kode_kipi" id="kode_kipi" value="{{ $pengetahuan->kode_kipi }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="kode_gejala" class="block text-sm font-medium text-gray-700">Kode Gejala</label>
                        <input type="text" name="kode_gejala" id="kode_gejala" value="{{ $pengetahuan->kode_gejala }}"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="mb" class="block text-sm font-medium text-gray-700">Nilai MB</label>
                            <input type="number" step="0.01" min="0" max="1" name="mb" id="mb"
                                value="{{ $pengetahuan->mb }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="md" class="block text-sm font-medium text-gray-700">Nilai MD</label>
                            <input type="number" step="0.01" min="0" max="1" name="md" id="md"
                                value="{{ $pengetahuan->md }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="pt-5 flex justify-end space-x-4">
                        <a href="{{ route('pakar.pengetahuan.index') }}"
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
