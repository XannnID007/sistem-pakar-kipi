@extends('layouts.app')

@section('title', 'Hasil Diagnosa')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-800">Hasil Diagnosa KIPI</h2>
                        <p class="mt-2 text-sm text-gray-600">Berdasarkan gejala yang Anda pilih, berikut adalah hasil
                            analisanya.</p>
                    </div>

                    @if (!empty($hasilTerbaik))
                        <div class="mt-8 bg-indigo-50 rounded-lg p-6 border border-indigo-200">
                            <h3 class="text-lg font-semibold text-indigo-800">Diagnosa Paling Mungkin</h3>
                            <div class="mt-4 flex flex-col md:flex-row items-center">
                                <div class="text-center md:text-left">
                                    <p class="text-5xl font-bold text-indigo-600">
                                        {{ number_format($hasilTerbaik['cf'] * 100, 0) }}%</p>
                                    <p class="font-semibold text-gray-700">Kemungkinan KIPI <span
                                            class="text-indigo-700">{{ $hasilTerbaik['jenis_kipi'] }}</span></p>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-6 md:pl-6 md:border-l border-indigo-200">
                                    <h4 class="font-semibold text-gray-800">Saran Penanganan:</h4>
                                    <p class="mt-1 text-gray-600">{{ $hasilTerbaik['saran'] }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-8 text-center text-gray-600 p-6 bg-yellow-50 rounded-lg border border-yellow-200">
                            <p>Tidak ada hasil diagnosa yang dapat ditampilkan berdasarkan gejala yang dipilih.</p>
                        </div>
                    @endif

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800">Ringkasan Gejala</h3>
                        <ul class="mt-4 space-y-2">
                            @foreach ($gejalaDipilih as $gejala)
                                @if ($gejala['cf_user'] > 0)
                                    <li class="flex justify-between p-3 bg-gray-50 rounded-md">
                                        <span class="text-gray-700">{{ $gejala['nama'] }}</span>
                                        <span
                                            class="font-semibold
                                    @if ($gejala['cf_user'] == 1.0) text-green-600
                                    @elseif($gejala['cf_user'] == 0.5) text-yellow-600 @endif">
                                            @switch($gejala['cf_user'])
                                                @case(1.0)
                                                    Yakin
                                                @break

                                                @case(0.5)
                                                    Ragu-ragu
                                                @break
                                            @endswitch
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div
                    class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    {{-- Menggunakan route 'diagnosa.ulang' --}}
                    <a href="{{ route('diagnosa.ulang') }}"
                        class="w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Diagnosa Ulang
                    </a>
                    @if (!empty($hasilTerbaik))
                        {{-- Menggunakan route 'riwayat.simpan' --}}
                        <form action="{{ route('riwayat.simpan') }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            <input type="hidden" name="nama_ibu" value="{{ session('nama_ibu') }}">
                            <input type="hidden" name="nama_anak" value="{{ session('nama_anak') }}">
                            <input type="hidden" name="usia_anak" value="{{ session('usia_anak') }}">
                            <input type="hidden" name="diagnosa" value="{{ $hasilTerbaik['jenis_kipi'] }}">
                            <input type="hidden" name="nilai_cf" value="{{ $hasilTerbaik['cf'] }}">
                            <input type="hidden" name="saran" value="{{ $hasilTerbaik['saran'] }}">
                            <input type="hidden" name="gejala_dipilih" value='@json($gejalaDipilih)'>
                            <input type="hidden" name="jenis_kelamin" value="{{ session('jenis_kelamin') }}">
                            <input type="hidden" name="tanggal_lahir" value="{{ session('tanggal_lahir') }}">
                            <input type="hidden" name="alamat" value="{{ session('alamat') }}">
                            <input type="hidden" name="jenis_vaksin" value="{{ session('jenis_vaksin') }}">
                            <input type="hidden" name="tempat_imunisasi" value="{{ session('tempat_imunisasi') }}">
                            <input type="hidden" name="tanggal_imunisasi" value="{{ session('tanggal_imunisasi') }}">

                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                Simpan Hasil ke Riwayat
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
