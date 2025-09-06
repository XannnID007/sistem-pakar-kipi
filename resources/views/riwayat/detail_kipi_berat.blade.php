@extends('layouts.pakar')

@section('title', 'Detail Laporan KIPI Berat')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Detail Laporan KIPI Berat</h2>
                            <p class="mt-1 text-sm text-gray-500">Verifikasi data sebelum mengirim laporan.</p>
                        </div>
                        <a href="{{ route('riwayat.kipi_berat') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Data Pasien & Imunisasi</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                            <div><strong class="text-gray-600 w-32 inline-block">Nama Anak:</strong>
                                {{ $riwayat->nama_anak }}</div>
                            <div><strong class="text-gray-600 w-32 inline-block">Usia Anak:</strong>
                                {{ $riwayat->usia_anak }} bulan</div>
                            <div><strong class="text-gray-600 w-32 inline-block">Nama Ibu:</strong> {{ $riwayat->nama_ibu }}
                            </div>
                            <div><strong class="text-gray-600 w-32 inline-block">Jenis Kelamin:</strong>
                                {{ $riwayat->jenis_kelamin }}</div>
                            <div class="sm:col-span-2"><strong class="text-gray-600 w-32 inline-block">Alamat:</strong>
                                {{ $riwayat->alamat }}</div>
                            <div class="sm:col-span-2 pt-4 mt-4 border-t"></div>
                            <div><strong class="text-gray-600 w-32 inline-block">Jenis Vaksin:</strong>
                                {{ $riwayat->jenis_vaksin }}</div>
                            <div><strong class="text-gray-600 w-32 inline-block">Tgl Imunisasi:</strong>
                                {{ \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Gejala yang Dipilih</h3>
                            <div class="space-y-3">
                                {{-- Menggunakan variabel $gejala yang benar dari controller --}}
                                @if (!empty($gejala))
                                    @foreach ($gejala as $g)
                                        @if ($g['cf_user'] > 0)
                                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                                <span class="text-gray-800">{{ $g['nama'] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-gray-500">Data gejala tidak tersedia.</p>
                                @endif
                            </div>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-red-800 border-b pb-2 mb-4">Hasil Diagnosa</h3>
                            <p class="text-4xl font-bold text-red-600">{{ number_format($riwayat->nilai_cf * 100, 0) }}%</p>
                            <p class="font-semibold text-lg text-gray-800">Kemungkinan KIPI <span
                                    class="text-red-700">{{ $riwayat->diagnosa }}</span></p>
                            <div class="mt-4">
                                <h4 class="font-semibold text-gray-800">Saran Penanganan:</h4>
                                <p class="mt-1 text-gray-600">{{ $riwayat->saran }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    @if ($riwayat->laporan)
                        <div class="bg-green-100 text-green-800 p-4 rounded-md text-center">
                            <i class="fas fa-check-circle mr-2"></i> Laporan ini sudah dikirim.
                        </div>
                    @else
                        <form action="{{ route('pakar.riwayat.berat.kirim', $riwayat->id) }}" method="POST">
                            @csrf
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="w-full sm:w-auto inline-flex justify-center items-center rounded-md border border-transparent bg-red-600 py-3 px-8 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                                    Kirim Laporan ke Kepala Puskesmas
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
