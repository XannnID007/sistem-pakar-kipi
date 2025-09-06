@extends('layouts.kepala')

@section('title', 'Laporan KIPI Berat')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan KIPI Berat</h1>
                <p class="mt-1 text-gray-600">Daftar kasus KIPI Berat yang memerlukan perhatian khusus.</p>
            </div>
            <a href="{{ route('kepala.dashboard') }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                Kembali ke Dashboard
            </a>
        </div>

        @if ($laporan->isEmpty())
            <div class="text-center bg-white rounded-2xl shadow-lg p-12">
                <i class="fas fa-folder-open fa-4x text-gray-300"></i>
                <h3 class="mt-6 text-xl font-bold text-gray-800">Belum Ada Laporan</h3>
                <p class="mt-2 text-gray-500">Saat ini tidak ada laporan KIPI Berat yang masuk.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach ($laporan as $item)
                        <li class="p-6 hover:bg-gray-50 transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start">
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <div class="flex items-center">
                                        <p class="text-base font-medium text-red-600 truncate">{{ $item->nama_file }}</p>
                                        <span
                                            class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">BERAT</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Tanggal Kirim:
                                        {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 flex items-center space-x-4">
                                    <a href="{{ asset($item->file_path) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-file-pdf mr-2"></i> Lihat PDF
                                    </a>
                                    <form action="{{ route('kepala.laporan.berat.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-full text-gray-400 hover:bg-red-100 hover:text-red-600 transition"
                                            title="Hapus Laporan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
