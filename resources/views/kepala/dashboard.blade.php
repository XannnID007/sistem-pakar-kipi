@extends('layouts.kepala')

@section('title', 'Dashboard Kepala Puskesmas')

@section('content')
    <div class="bg-gray-50 min-h-full">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                {{-- PERBAIKAN: Menggunakan optional() untuk mencegah error --}}
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Selamat Datang, {{ optional(Auth::user())->name }}!
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Pilih menu laporan di bawah ini untuk melihat data KIPI yang telah tercatat.
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                <a href="{{ route('kepala.laporan.index') }}"
                    class="group block p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 text-center">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Laporan KIPI Ringan & Sedang</h3>
                    <p class="mt-2 text-gray-600">Lihat semua daftar laporan untuk kategori KIPI Ringan dan Sedang.</p>
                    <span class="mt-6 inline-block font-semibold text-indigo-600 group-hover:text-indigo-800">
                        Buka Laporan <i class="fas fa-arrow-right ml-1"></i>
                    </span>
                </a>

                <a href="{{ route('kepala.laporan.berat') }}"
                    class="group block p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 text-center">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-file-medical-alt fa-2x"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Laporan KIPI Berat</h3>
                    <p class="mt-2 text-gray-600">Tinjau laporan khusus untuk kategori KIPI Berat yang memerlukan perhatian
                        lebih.</p>
                    <span class="mt-6 inline-block font-semibold text-indigo-600 group-hover:text-indigo-800">
                        Buka Laporan <i class="fas fa-arrow-right ml-1"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
@endsection
