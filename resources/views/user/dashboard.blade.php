@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Siap untuk memulai diagnosa atau melihat riwayat konsultasi Anda?
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                <a href="{{ route('diagnosa.data') }}"
                    class="group block p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="h-16 w-16 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                                <i class="fas fa-play-circle fa-2x"></i>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-gray-900">Mulai Diagnosa Baru</h3>
                            <p class="mt-2 text-gray-600">Isi data dan jawab beberapa pertanyaan untuk mendapatkan diagnosa
                                awal.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('riwayat.index') }}"
                    class="group block p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 flex items-center justify-center rounded-full bg-pink-100 text-pink-600">
                                <i class="fas fa-history fa-2x"></i>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-gray-900">Lihat Riwayat</h3>
                            <p class="mt-2 text-gray-600">Tinjau kembali hasil dan saran dari diagnosa yang pernah Anda
                                lakukan.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mt-16 text-center">
                <img src="{{ asset('images/bg.png') }}" alt="Ilustrasi Dokter dan Pasien" class="mx-auto w-full max-w-sm">
            </div>
        </div>
    </div>
@endsection
