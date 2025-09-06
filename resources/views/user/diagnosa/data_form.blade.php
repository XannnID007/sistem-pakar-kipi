@extends('layouts.app')

@section('title', 'Lengkapi Data Diri')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                                <label for="nama_ibu" class="block text-sm font-medium text-gray-700">Nama Ibu <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="nama_ibu" name="nama_ibu"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama_ibu') border-red-300 @enderror"
                                    value="{{ old('nama_ibu', session('nama_ibu')) }}" required>
                                @error('nama_ibu')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama_anak" class="block text-sm font-medium text-gray-700">Nama Anak <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="nama_anak" name="nama_anak"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama_anak') border-red-300 @enderror"
                                    value="{{ old('nama_anak', session('nama_anak')) }}" required>
                                @error('nama_anak')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir
                                    Anak <span class="text-red-500">*</span></label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tanggal_lahir') border-red-300 @enderror"
                                    value="{{ old('tanggal_lahir', session('tanggal_lahir')) }}" required>
                                @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="usia_anak" class="block text-sm font-medium text-gray-700">Usia Anak (bulan)
                                    <span class="text-red-500">*</span></label>
                                <input type="number" id="usia_anak" name="usia_anak"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('usia_anak') border-red-300 @enderror"
                                    value="{{ old('usia_anak', session('usia_anak')) }}" min="0" max="60"
                                    required>
                                @error('usia_anak')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin
                                    <span class="text-red-500">*</span></label>
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jenis_kelamin') border-red-300 @enderror"
                                    required>
                                    <option value="" disabled
                                        {{ old('jenis_kelamin', session('jenis_kelamin')) ? '' : 'selected' }}>Pilih Jenis
                                        Kelamin</option>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', session('jenis_kelamin')) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', session('jenis_kelamin')) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat <span
                                        class="text-red-500">*</span></label>
                                <textarea id="alamat" name="alamat" rows="4"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('alamat') border-red-300 @enderror"
                                    required>{{ old('alamat', session('alamat')) }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_vaksin" class="block text-sm font-medium text-gray-700">Jenis Vaksin
                                    Terakhir <span class="text-red-500">*</span></label>
                                <input type="text" id="jenis_vaksin" name="jenis_vaksin"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jenis_vaksin') border-red-300 @enderror"
                                    value="{{ old('jenis_vaksin', session('jenis_vaksin')) }}" required>
                                @error('jenis_vaksin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tempat_imunisasi" class="block text-sm font-medium text-gray-700">Tempat
                                    Imunisasi <span class="text-red-500">*</span></label>
                                <input type="text" id="tempat_imunisasi" name="tempat_imunisasi"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tempat_imunisasi') border-red-300 @enderror"
                                    value="{{ old('tempat_imunisasi', session('tempat_imunisasi')) }}" required>
                                @error('tempat_imunisasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_imunisasi" class="block text-sm font-medium text-gray-700">Tanggal
                                    Imunisasi <span class="text-red-500">*</span></label>
                                <input type="date" id="tanggal_imunisasi" name="tanggal_imunisasi"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tanggal_imunisasi') border-red-300 @enderror"
                                    value="{{ old('tanggal_imunisasi', session('tanggal_imunisasi')) }}" required>
                                @error('tanggal_imunisasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-200">
                        <div class="flex justify-between">
                            <a href="{{ route('dashboard.user') }}"
                                class="inline-flex justify-center rounded-lg border border-gray-300 bg-white py-3 px-8 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                Kembali
                            </a>
                            <button type="submit"
                                class="w-full md:w-auto inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-3 px-8 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Lanjutkan ke Gejala →
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
