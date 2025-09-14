@extends('layouts.kepala')

@section('title', 'Dashboard Kepala Puskesmas')
@section('page-title', 'Dashboard')

@section('content')
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Kepala Puskesmas</h1>
            <p class="mt-2 text-gray-600">Selamat datang di sistem monitoring KIPI</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Laporan Ringan/Sedang -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-file-alt text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Laporan Ringan/Sedang</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\LaporanKepala::where('nama_file', 'like', '%Ringan_dan_Sedang%')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Laporan Berat -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Laporan KIPI Berat</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\LaporanKepala::where('nama_file', 'like', '%KIPI_Berat%')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Kasus Bulan Ini -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Kasus Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\RiwayatDiagnosa::whereMonth('created_at', now()->month)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kasus Hari Ini -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <i class="fas fa-calendar-day text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Kasus Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\RiwayatDiagnosa::whereDate('created_at', today())->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Laporan Terbaru</h3>
            </div>
            <div class="p-6">
                @php
                    $recentReports = \App\Models\LaporanKepala::latest()->take(5)->get();
                @endphp

                @if ($recentReports->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recentReports as $report)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-indigo-100">
                                        <i class="fas fa-file-pdf text-indigo-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-medium text-gray-900">{{ $report->nama_file }}</h4>
                                        <p class="text-sm text-gray-500">{{ $report->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('kepala.laporan.show', $report->id) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    Lihat
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada laporan tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
