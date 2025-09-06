@extends('layouts.pakar')

@section('title', 'Laporan KIPI Berat')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Kasus KIPI Berat</h1>
            <p class="mt-1 text-gray-600">Daftar kasus KIPI Berat yang memerlukan verifikasi dan pengiriman laporan.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Menggunakan variabel $riwayats (plural) sesuai dengan controller Anda --}}
        @if ($riwayats->isEmpty())
            <div class="text-center bg-white rounded-2xl shadow-lg p-12">
                <i class="fas fa-folder-open fa-4x text-gray-300"></i>
                <h3 class="mt-6 text-xl font-bold text-gray-800">Tidak Ada Kasus KIPI Berat</h3>
                <p class="mt-2 text-gray-500">Saat ini tidak ada laporan diagnosa KIPI Berat yang masuk.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach ($riwayats as $item)
                        <li class="p-6 hover:bg-gray-50 transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start">
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <div class="flex items-center">
                                        <p class="text-base font-semibold text-red-600">{{ $item->nama_anak }}</p>
                                        <span
                                            class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $item->usia_anak }}
                                            bulan</span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <strong>Vaksin:</strong> {{ $item->jenis_vaksin }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Tanggal Diagnosa:
                                        {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM YYYY') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 flex items-center space-x-4">
                                    @if ($item->laporan)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-2"></i> Terkirim
                                        </span>
                                    @endif
                                    {{-- Menggunakan route yang benar dari file web.php Anda --}}
                                    <a href="{{ route('pakar.riwayat.berat.detail', $item->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600">
                                        Detail & Kirim <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
