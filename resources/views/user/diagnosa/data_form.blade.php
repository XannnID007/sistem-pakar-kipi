@extends('layouts.app')

@section('title', 'Lengkapi Data Diri')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Langkah 1: Lengkapi Data Anak</h2>
                    <p class="mt-2 text-sm text-gray-600">Informasi ini diperlukan untuk memberikan hasil diagnosa yang lebih
                        akurat.</p>
                </div>

                <form action="{{ route('diagnosa.storeData') }}" method="POST" class="mt-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                        <div class="space-y-6">
                            <div>
                                <label for="nama_ibu" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                                <input type="text" id="nama_ibu" name="nama_ibu"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('nama_ibu') }}" required>
                            </div>
                            <div>
                                <label for="nama_anak" class="block text-sm font-medium text-gray-700">Nama Anak</label>
                                <input type="text" id="nama_anak" name="nama_anak"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('nama_anak') }}" required>
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir
                                    Anak</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('tanggal_lahir') }}" required>
                            </div>
                            <div>
                                <label for="usia_anak" class="block text-sm font-medium text-gray-700">Usia Anak
                                    (bulan)</label>
                                <input type="number" id="usia_anak" name="usia_anak"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('usia_anak') }}" min="0" max="60" required>
                            </div>
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis
                                    Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" @if (old('jenis_kelamin') == 'Laki-laki') selected @endif>Laki-laki
                                    </option>
                                    <option value="Perempuan" @if (old('jenis_kelamin') == 'Perempuan') selected @endif>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="4"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label for="jenis_vaksin" class="block text-sm font-medium text-gray-700">Jenis Vaksin
                                    Terakhir</label>
                                <input type="text" id="jenis_vaksin" name="jenis_vaksin"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('jenis_vaksin') }}" required>
                            </div>
                            <div>
                                <label for="tempat_imunisasi" class="block text-sm font-medium text-gray-700">Tempat
                                    Imunisasi</label>
                                <input type="text" id="tempat_imunisasi" name="tempat_imunisasi"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('tempat_imunisasi') }}" required>
                            </div>
                            <div>
                                <label for="tanggal_imunisasi" class="block text-sm font-medium text-gray-700">Tanggal
                                    Imunisasi</slabel>
                                    <input type="date" id="tanggal_imunisasi" name="tanggal_imunisasi"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        value="{{ old('tanggal_imunisasi') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="w-full md:w-auto inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-3 px-8 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                Lanjutkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
