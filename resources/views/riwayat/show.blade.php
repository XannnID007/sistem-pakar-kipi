@extends('layouts.app')

@section('title', 'Detail Riwayat Diagnosa')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-6 border-gray-200">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Detail Hasil Diagnosa</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Diagnosa pada tanggal:
                                {{ \Carbon\Carbon::parse($riwayat->tanggal)->isoFormat('D MMMM YYYY, HH:mm') }}
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex space-x-3">
                            <a href="{{ route('riwayat.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <a href="{{ route('riwayat.cetak', $riwayat->id) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                <i class="fas fa-print mr-2"></i>Cetak
                            </a>
                        </div>
                    </div>

                    @if (!empty($hasilTerbaik))
                        <div class="mt-8 bg-indigo-50 rounded-lg p-6">
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="text-center md:text-left">
                                    <p class="text-5xl font-bold text-indigo-600">
                                        {{ number_format($hasilTerbaik['cf'] * 100, 0) }}%</p>
                                    <p class="font-semibold text-lg text-gray-800">Kemungkinan KIPI <span
                                            class="text-indigo-700">{{ $hasilTerbaik['jenis_kipi'] }}</span></p>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-6 md:pl-6 md:border-l border-indigo-200 w-full">
                                    <h4 class="font-semibold text-gray-800 flex items-center"><i
                                            class="fas fa-comment-medical mr-2 text-indigo-600"></i>Saran Penanganan:</h4>
                                    <p class="mt-1 text-gray-600">{{ $hasilTerbaik['saran'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Ringkasan Data</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                            <div><strong class="text-gray-600 w-32 inline-block">Nama Anak:</strong>
                                {{ session('nama_anak', $riwayat->nama_anak) }}</div>
                            <div><strong class="text-gray-600 w-32 inline-block">Jenis Kelamin:</strong>
                                {{ session('jenis_kelamin', $riwayat->jenis_kelamin) }}</div>
                            <div><strong class="text-gray-600 w-32 inline-block">Tanggal Lahir:</strong>
                                {{ \Carbon\Carbon::parse(session('tanggal_lahir', $riwayat->tanggal_lahir))->isoFormat('D MMMM YYYY') }}
                            </div>
                            <div><strong class="text-gray-600 w-32 inline-block">Usia Anak:</strong>
                                {{ session('usia_anak', $riwayat->usia_anak) }} bulan</div>
                            <div><strong class="text-gray-600 w-32 inline-block">Nama Ibu:</strong>
                                {{ session('nama_ibu', $riwayat->nama_ibu) }}</div>
                            <div><strong class="text-gray-600 w-32 inline-block">Jenis Vaksin:</strong>
                                {{ session('jenis_vaksin', $riwayat->jenis_vaksin) }}</div>
                            <div class="sm:col-span-2"><strong class="text-gray-600 w-32 inline-block">Alamat:</strong>
                                {{ session('alamat', $riwayat->alamat) }}</div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Gejala yang Dipilih</h3>
                        <div class="space-y-3">
                            @forelse ($gejalaDipilih as $g)
                                @if ($g['cf_user'] > 0)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-gray-800">{{ $g['nama'] }}</span>
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if ($g['cf_user'] == 1) bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                            @switch($g['cf_user'])
                                                @case(1)
                                                    Yakin
                                                @break

                                                @case(0.5)
                                                    Ragu-ragu
                                                @break

                                                @default
                                                    {{ $g['cf_user'] }}
                                            @endswitch
                                        </span>
                                    </div>
                                @endif
                                @empty
                                    <p class="text-gray-500">Tidak ada gejala yang dipilih untuk diagnosa ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
