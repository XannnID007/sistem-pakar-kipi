@extends('layouts.pakar')

@section('title', 'Laporan KIPI Ringan & Sedang')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Laporan KIPI Ringan & Sedang</h1>
            <p class="mt-1 text-gray-600">Tinjau dan kirim laporan diagnosa ke Kepala Puskesmas.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            {{-- Route 'pakar.riwayat.kipi' adalah nama route yang benar untuk method kipi() --}}
            <form action="{{ route('pakar.riwayat.kipi') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select name="bulan" id="bulan"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <input type="number" name="tahun" id="tahun" placeholder="{{ date('Y') }}"
                            value="{{ request('tahun') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        {{-- Tombol reset mengarah ke route yang sama tanpa parameter --}}
                        <a href="{{ route('pakar.riwayat.kipi') }}"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if ($riwayat->isEmpty())
            <div class="text-center bg-white rounded-2xl shadow-lg p-12">
                <i class="fas fa-folder-open fa-4x text-gray-300"></i>
                <h3 class="mt-6 text-xl font-bold text-gray-800">Tidak Ada Laporan Ditemukan</h3>
                <p class="mt-2 text-gray-500">Tidak ada laporan yang cocok dengan filter yang Anda pilih.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach ($riwayat as $item)
                        <li class="p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start">
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <div class="flex items-center">
                                        <p class="text-base font-semibold text-indigo-600">{{ $item->nama_anak }}</p>
                                        <span
                                            class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $item->usia_anak }}
                                            bulan</span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <strong>Diagnosa:</strong> KIPI {{ $item->diagnosa }}
                                        ({{ number_format($item->nilai_cf * 100, 0) }}%)
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Tanggal: {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM YYYY') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 flex items-center">
                                    @if ($item->laporan)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-2"></i> Terkirim
                                        </span>
                                    @else
                                        {{-- Route kirim ini dari file web.php Anda --}}
                                        <form action="{{ route('pakar.riwayat.kipi.kirim') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600">
                                                <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
