<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Kepala Puskesmas')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-50">

        <div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-black/30 lg:hidden" @click="sidebarOpen = false"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 flex flex-col">

            <div class="flex items-center justify-center h-16 border-b border-gray-200 flex-shrink-0">
                <span class="text-indigo-600 text-xl font-bold">Kepala Puskesmas</span>
            </div>

            <nav class="flex-1 overflow-y-auto pt-6">
                @php
                    function is_active_kepala($routes)
                    {
                        return in_array(request()->route()->getName(), $routes);
                    }
                @endphp
                <a href="{{ route('kepala.dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-l-4 @if (is_active_kepala(['kepala.dashboard'])) border-indigo-500 bg-indigo-50 text-indigo-600 font-semibold @else border-transparent @endif">
                    <i class="fas fa-tachometer-alt fa-fw w-6"></i><span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('kepala.laporan.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-l-4 @if (is_active_kepala(['kepala.laporan.index'])) border-indigo-500 bg-indigo-50 text-indigo-600 font-semibold @else border-transparent @endif">
                    <i class="fas fa-clipboard-list fa-fw w-6"></i><span class="ml-3">Laporan Ringan/Sedang</span>
                </a>
                <a href="{{ route('kepala.laporan.berat') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-l-4 @if (is_active_kepala(['kepala.laporan.berat'])) border-indigo-500 bg-indigo-50 text-indigo-600 font-semibold @else border-transparent @endif">
                    <i class="fas fa-file-medical-alt fa-fw w-6"></i><span class="ml-3">Laporan KIPI Berat</span>
                </a>
                <a href=""
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-l-4 border-transparent">
                    <i class="fas fa-chart-bar fa-fw w-6"></i><span class="ml-3">Statistik</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-6 flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden"><i
                        class="fas fa-bars fa-lg"></i></button>
                <div class="flex-1"></div>
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2">
                        {{-- PERBAIKAN: Menggunakan optional() untuk mencegah error --}}
                        <span
                            class="font-semibold text-gray-700 hidden sm:block">{{ optional(Auth::user())->name }}</span>
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 origin-top-right">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt fa-fw w-6 mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">@yield('content')</main>
        </div>
    </div>
</body>

</html>
