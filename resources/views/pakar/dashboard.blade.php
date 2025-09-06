@extends('layouts.pakar')
@section('title', 'Dashboard Pakar')
@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Selamat Datang, {{ optional(Auth::user())->name }}!</h1>
            <p class="mt-2 text-lg text-gray-600">Berikut adalah ringkasan data utama dalam sistem.</p>
        </div>
        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 flex items-center">
                <div class="bg-indigo-100 text-indigo-600 rounded-full p-4"><i class="fas fa-stethoscope fa-2x"></i></div>
                <div class="ml-5">
                    <p class="text-3xl font-bold text-gray-900">{{ $jumlahGejala }}</p>
                    <p class="text-sm text-gray-500">Total Gejala</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 flex items-center">
                <div class="bg-pink-100 text-pink-600 rounded-full p-4"><i class="fas fa-layer-group fa-2x"></i></div>
                <div class="ml-5">
                    <p class="text-3xl font-bold text-gray-900">{{ $jumlahKategori }}</p>
                    <p class="text-sm text-gray-500">Kategori KIPI</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 flex items-center">
                <div class="bg-green-100 text-green-600 rounded-full p-4"><i class="fas fa-book-medical fa-2x"></i></div>
                <div class="ml-5">
                    <p class="text-3xl font-bold text-gray-900">{{ $jumlahPengetahuan }}</p>
                    <p class="text-sm text-gray-500">Basis Pengetahuan</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 flex items-center">
                <div class="bg-yellow-100 text-yellow-600 rounded-full p-4"><i class="fas fa-users fa-2x"></i></div>
                <div class="ml-5">
                    <p class="text-3xl font-bold text-gray-900">{{ $jumlahUser }}</p>
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Akses Cepat & Manajemen Data</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <h4 class="font-bold text-lg text-gray-800">Manajemen Pengetahuan</h4>
                    <p class="text-sm text-gray-500 mt-1 mb-4">Atur data-data inti sistem pakar.</p>
                    <div class="space-y-3"><a href="{{ route('pakar.gejala.index') }}"
                            class="block w-full text-center p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Lihat
                            Gejala</a><a href="{{ route('pakar.kategori_kipi.index') }}"
                            class="block w-full text-center p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Lihat
                            Kategori KIPI</a><a href="{{ route('pakar.pengetahuan.index') }}"
                            class="block w-full text-center p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Lihat
                            Basis Pengetahuan</a></div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <h4 class="font-bold text-lg text-gray-800">Manajemen Pengguna</h4>
                    <p class="text-sm text-gray-500 mt-1 mb-4">Kelola akun pakar dan pengguna.</p>
                    <div class="space-y-3"><a href="{{ route('pakar.user') }}"
                            class="block w-full text-center p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Lihat
                            Pengguna</a><a href="{{ route('pakar.index') }}"
                            class="block w-full text-center p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Lihat
                            Pakar</a></div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <h4 class="font-bold text-lg text-gray-800">Laporan Diagnosa</h4>
                    <p class="text-sm text-gray-500 mt-1 mb-4">Tinjau laporan diagnosa yang masuk.</p>
                    <div class="space-y-3"><a href="{{ route('pakar.riwayat.kipi') }}"
                            class="block w-full text-center p-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">Laporan
                            Ringan/Sedang</a><a href="{{ route('riwayat.kipi_berat') }}"
                            class="block w-full text-center p-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Laporan
                            KIPI Berat</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection
