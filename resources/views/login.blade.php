@extends('layouts.app')

@section('title', 'Login - Sistem Pakar KIPI')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-2xl w-full max-w-4xl">
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <h2 class="font-bold text-3xl text-gray-800 mb-4">Login</h2>
                <p class="text-sm text-gray-600 mb-8">Selamat datang kembali! Silakan masukkan detail Anda.</p>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Masuk
                    </button>
                </form>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-600">Belum punya akun?
                        <a href="{{ route('register.form') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>

            <div class="hidden md:block w-1/2">
                <img src="{{ asset('images/bg.png') }}" alt="Ilustrasi Dokter"
                    class="w-full h-full object-cover rounded-r-2xl">
            </div>
        </div>
    </div>
@endsection
