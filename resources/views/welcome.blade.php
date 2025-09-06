<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar KIPI - Diagnosa Kejadian Ikutan Pasca Imunisasi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans bg-white text-gray-800 antialiased">

    <header x-data="{ scrolled: false }" @scroll.window="scrolled = (window.scrollY > 10)"
        :class="{ 'bg-white/80 backdrop-blur-lg shadow-lg': scrolled, 'bg-transparent': !scrolled }"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold"
                        :class="scrolled ? 'text-indigo-600' : 'text-gray-800'">
                        KIPI Expert
                    </a>
                </div>
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="#features" class="font-medium text-gray-600 hover:text-indigo-600 transition">Fitur</a>
                    <a href="#how-it-works" class="font-medium text-gray-600 hover:text-indigo-600 transition">Cara
                        Kerja</a>
                    <a href="{{ route('login.form') }}"
                        class="font-medium text-gray-600 hover:text-indigo-600 transition">Login</a>
                    <a href="{{ route('register.form') }}"
                        class="inline-flex items-center justify-center px-5 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Register
                    </a>
                </nav>
                <div class="md:hidden">
                    <a href="{{ route('login.form') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="pt-20 lg:pt-0">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-screen">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 tracking-tight">
                        Ketenangan Pikiran untuk Orang Tua Hebat
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 max-w-lg mx-auto lg:mx-0">
                        Identifikasi dini gejala KIPI (Kejadian Ikutan Pasca Imunisasi) pada batita Anda dengan sistem
                        pakar kami yang dirancang untuk memberikan kejelasan dan saran tepercaya.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('login.form') }}"
                            class="inline-block w-full sm:w-auto text-center px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition">
                            Mulai Diagnosa
                        </a>
                        <a href="#how-it-works"
                            class="inline-block w-full sm:w-auto text-center px-8 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                            Lihat Cara Kerja
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <img src="{{ asset('images/kipi.jpg') }}" alt="Dokter memberikan imunisasi pada anak"
                        class="rounded-3xl shadow-2xl">
                </div>
            </div>
        </section>

        <section id="features" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-indigo-600 font-semibold uppercase">Fitur Unggulan</span>
                    <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Dirancang untuk Kebutuhan Anda</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto mb-4">
                            <i class="fas fa-bolt fa-2x"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Diagnosa Cepat & Mudah</h3>
                        <p class="text-gray-600">Proses tanya-jawab interaktif yang memandu Anda menuju hasil diagnosa
                            dalam hitungan menit.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto mb-4">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Akurasi Terjamin</h3>
                        <p class="text-gray-600">Dibangun menggunakan metode *Certainty Factor* berdasarkan basis
                            pengetahuan dari pakar kesehatan.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto mb-4">
                            <i class="fas fa-comment-medical fa-2x"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Saran Praktis</h3>
                        <p class="text-gray-600">Dapatkan rekomendasi penanganan awal yang jelas dan praktis sesuai
                            dengan tingkat keparahan gejala.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-indigo-600 font-semibold uppercase">Proses Diagnosa</span>
                    <h2 class="mt-2 text-3xl font-extrabold text-gray-900">3 Langkah Mudah Menuju Kejelasan</h2>
                </div>
                <div class="relative">
                    <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -translate-y-1/2">
                    </div>

                    <div class="relative grid grid-cols-1 md:grid-cols-3 gap-12">
                        <div class="text-center">
                            <div class="relative">
                                <div
                                    class="text-4xl font-bold text-indigo-600 bg-white border-4 border-gray-200 w-24 h-24 rounded-full flex items-center justify-center mx-auto">
                                    1</div>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold">Isi Data Anak</h3>
                            <p class="mt-2 text-gray-600">Lengkapi data imunisasi dan profil anak Anda.</p>
                        </div>
                        <div class="text-center">
                            <div class="relative">
                                <div
                                    class="text-4xl font-bold text-indigo-600 bg-white border-4 border-gray-200 w-24 h-24 rounded-full flex items-center justify-center mx-auto">
                                    2</div>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold">Jawab Pertanyaan</h3>
                            <p class="mt-2 text-gray-600">Pilih gejala yang paling sesuai dengan kondisi anak.</p>
                        </div>
                        <div class="text-center">
                            <div class="relative">
                                <div
                                    class="text-4xl font-bold text-indigo-600 bg-white border-4 border-gray-200 w-24 h-24 rounded-full flex items-center justify-center mx-auto">
                                    3</div>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold">Dapatkan Hasil</h3>
                            <p class="mt-2 text-gray-600">Lihat persentase kemungkinan dan saran penanganan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} Sistem Pakar KIPI | STMIK Mardira Indonesia.</p>
        </div>
    </footer>

</body>

</html>
