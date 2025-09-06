@extends('layouts.kepala')

@section('title', 'Dashboard Kepala Puskesmas')

@section('content')
    <div class="bg-gray-50 min-h-full">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Selamat Datang, {{ optional(Auth::user())->name }}!
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Sistem Monitoring dan Analisis KIPI Puskesmas
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Laporan KIPI Ringan & Sedang -->
                <a href="{{ route('kepala.laporan.index') }}"
                    class="group block p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900 text-center">Laporan KIPI Ringan & Sedang</h3>
                    <p class="mt-2 text-gray-600 text-center">Lihat dan kelola laporan kasus KIPI dengan tingkat ringan
                        hingga sedang.</p>
                    <div class="mt-6 flex items-center justify-center">
                        <span
                            class="inline-block font-semibold text-green-600 group-hover:text-green-800 transition-colors">
                            Buka Laporan <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>

                <!-- Laporan KIPI Berat -->
                <a href="{{ route('kepala.laporan.berat') }}"
                    class="group block p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-file-medical-alt fa-2x"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900 text-center">Laporan KIPI Berat</h3>
                    <p class="mt-2 text-gray-600 text-center">Tinjau dan monitor kasus KIPI berat yang memerlukan perhatian
                        khusus.</p>
                    <div class="mt-6 flex items-center justify-center">
                        <span class="inline-block font-semibold text-red-600 group-hover:text-red-800 transition-colors">
                            Buka Laporan <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>

                <!-- NEW: Statistik & Analisis -->
                <a href=""
                    class="group block p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-chart-bar fa-2x"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900 text-center">Statistik & Analisis</h3>
                    <p class="mt-2 text-gray-600 text-center">Dashboard analitik untuk memantau tren dan pola kejadian KIPI.
                    </p>
                    <div class="mt-6 flex items-center justify-center">
                        <span class="inline-block font-semibold text-blue-600 group-hover:text-blue-800 transition-colors">
                            Lihat Statistik <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Quick Stats Summary -->
            <div class="mt-16 bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Ringkasan Singkat</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-gray-50 rounded-xl">
                        <div class="h-12 w-12 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Monitoring Aktif</h3>
                        <p class="text-gray-600 text-sm mt-2">Sistem monitoring KIPI berjalan 24/7 untuk memastikan deteksi
                            dini</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-xl">
                        <div class="h-12 w-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Keamanan Vaksin</h3>
                        <p class="text-gray-600 text-sm mt-2">Memantau dan menganalisis keamanan program imunisasi</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-xl">
                        <div class="h-12 w-12 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Analisis Lanjutan</h3>
                        <p class="text-gray-600 text-sm mt-2">Dashboard analitik untuk mendukung pengambilan keputusan</p>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Sistem Pakar KIPI - Monitoring Kejadian Ikutan Pasca Imunisasi
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Last Updated: {{ now()->format('d M Y, H:i') }} WIB
                </p>
            </div>
        </div>
    </div>
@endsection
