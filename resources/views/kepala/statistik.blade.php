@extends('layouts.kepala')

@section('title', 'Statistik KIPI')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Statistik & Analisis KIPI</h1>
                <p class="mt-2 text-gray-600">Dashboard analitik untuk memantau tren dan pola KIPI</p>
            </div>

            <!-- Filter Tanggal -->
            <div class="mt-4 lg:mt-0">
                <form method="GET" action="{{ route('kepala.statistik') }}" class="flex flex-col sm:flex-row gap-3">
                    <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Kartu Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Kasus</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalKasus->total ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">KIPI Ringan</h3>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalKasus->ringan ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">KIPI Sedang</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ number_format($totalKasus->sedang ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">KIPI Berat</h3>
                        <p class="text-2xl font-bold text-red-600">{{ number_format($totalKasus->berat ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Tren Bulanan -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Kasus 6 Bulan Terakhir</h3>
                <canvas id="trenBulananChart" width="400" height="200"></canvas>
            </div>

            <!-- Distribusi Kategori KIPI -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Kategori KIPI</h3>
                <canvas id="kategoriChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Distribusi Usia -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Berdasarkan Usia</h3>
                <canvas id="usiaChart" width="400" height="200"></canvas>
            </div>

            <!-- Distribusi Jenis Kelamin -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Jenis Kelamin</h3>
                <canvas id="genderChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Top Vaksin & Status Penanganan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Top 5 Vaksin -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 5 Vaksin Terkait KIPI</h3>
                <div class="space-y-3">
                    @forelse($topVaksin as $index => $vaksin)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded-full mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-gray-700">{{ $vaksin->jenis_vaksin }}</span>
                            </div>
                            <span class="text-sm font-semibold text-indigo-600">{{ $vaksin->jumlah_kasus }} kasus</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada data vaksin</p>
                    @endforelse
                </div>
            </div>

            <!-- Status Penanganan -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Penanganan</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center justify-between">
                            <span class="text-green-800 font-medium">Sudah Ditangani</span>
                            <span
                                class="text-green-600 font-bold">{{ number_format($statusPenanganan->sudah_ditangani ?? 0) }}</span>
                        </div>
                        <div class="mt-2 bg-green-200 rounded-full h-2">
                            @php
                                $persentaseDitangani =
                                    $statusPenanganan->total_kasus > 0
                                        ? ($statusPenanganan->sudah_ditangani / $statusPenanganan->total_kasus) * 100
                                        : 0;
                            @endphp
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $persentaseDitangani }}%"></div>
                        </div>
                    </div>

                    <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                        <div class="flex items-center justify-between">
                            <span class="text-red-800 font-medium">KIPI Berat Belum Ditangani</span>
                            <span
                                class="text-red-600 font-bold">{{ number_format($statusPenanganan->berat_belum_ditangani ?? 0) }}</span>
                        </div>
                        @if (($statusPenanganan->berat_belum_ditangani ?? 0) > 0)
                            <p class="text-xs text-red-600 mt-1">⚠️ Memerlukan perhatian segera</p>
                        @endif
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center justify-between">
                            <span class="text-blue-800 font-medium">Pengguna Aktif (Periode Ini)</span>
                            <span class="text-blue-600 font-bold">{{ number_format($penggunaAktif) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata CF -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Rata-rata Certainty Factor (CF) per Kategori</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-green-600 font-semibold">KIPI Ringan</p>
                    <p class="text-2xl font-bold text-green-700">
                        {{ $rataRataCF->cf_ringan ? number_format($rataRataCF->cf_ringan * 100, 1) . '%' : 'N/A' }}
                    </p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-yellow-600 font-semibold">KIPI Sedang</p>
                    <p class="text-2xl font-bold text-yellow-700">
                        {{ $rataRataCF->cf_sedang ? number_format($rataRataCF->cf_sedang * 100, 1) . '%' : 'N/A' }}
                    </p>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <p class="text-red-600 font-semibold">KIPI Berat</p>
                    <p class="text-2xl font-bold text-red-700">
                        {{ $rataRataCF->cf_berat ? number_format($rataRataCF->cf_berat * 100, 1) . '%' : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tren Bulanan Chart
            const trenBulananCtx = document.getElementById('trenBulananChart').getContext('2d');
            new Chart(trenBulananCtx, {
                type: 'line',
                data: {
                    labels: @json($trenBulanan->pluck('bulan')),
                    datasets: [{
                        label: 'Total Kasus',
                        data: @json($trenBulanan->pluck('total_kasus')),
                        borderColor: '#6366f1',
                        backgroundColor: '#6366f1',
                        fill: false,
                        tension: 0.4
                    }, {
                        label: 'KIPI Berat',
                        data: @json($trenBulanan->pluck('kasus_berat')),
                        borderColor: '#ef4444',
                        backgroundColor: '#ef4444',
                        fill: false,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Kategori Chart (Pie)
            const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
            new Chart(kategoriCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Ringan', 'Sedang', 'Berat'],
                    datasets: [{
                        data: [
                            {{ $totalKasus->ringan ?? 0 }},
                            {{ $totalKasus->sedang ?? 0 }},
                            {{ $totalKasus->berat ?? 0 }}
                        ],
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            // Distribusi Usia Chart
            const usiaCtx = document.getElementById('usiaChart').getContext('2d');
            new Chart(usiaCtx, {
                type: 'bar',
                data: {
                    labels: @json($distribusiUsia->pluck('kelompok_usia')),
                    datasets: [{
                        label: 'Jumlah Kasus',
                        data: @json($distribusiUsia->pluck('jumlah')),
                        backgroundColor: '#6366f1',
                        borderColor: '#4f46e5',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Gender Chart (Pie)
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: @json($distribusiGender->pluck('jenis_kelamin')),
                    datasets: [{
                        data: @json($distribusiGender->pluck('jumlah')),
                        backgroundColor: ['#3b82f6', '#ec4899'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
    </script>
@endsection
