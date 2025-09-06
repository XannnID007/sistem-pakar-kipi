@extends('layouts.pakar')

@section('title', 'Basis Pengetahuan')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Basis Pengetahuan</h1>
                <p class="mt-1 text-gray-600">Aturan yang menghubungkan gejala dengan kategori KIPI.</p>
            </div>
            <a href="{{ route('pakar.pengetahuan.create') }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                <i class="fas fa-plus mr-2"></i> Tambah Aturan Baru
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                                Aturan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                                KIPI</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gejala</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">MB
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">MD
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Menggunakan variabel $pengetahuans (plural) sesuai method index() --}}
                        @forelse ($pengetahuans as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->kode_aturan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->kode_kipi }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{-- Menampilkan kode gejala dan nama gejala jika relasi ada --}}
                                    {{ $item->kode_gejala }} - ({{ $item->gejala?->nama ?? 'Nama Gejala Tidak Ditemukan' }})
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-green-600">
                                    {{ $item->mb }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-red-600">
                                    {{ $item->md }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                    <a href="{{ route('pakar.pengetahuan.edit', $item->id) }}"
                                        class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <form action="{{ route('pakar.pengetahuan.destroy', $item->id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus aturan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                    <i class="fas fa-folder-open fa-3x text-gray-300"></i>
                                    <p class="mt-4">Belum ada aturan basis pengetahuan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
