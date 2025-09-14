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

<body class="h-full font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-xl transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 flex flex-col">

            <!-- Sidebar Header -->
            <div class="flex items-center justify-center h-16 bg-indigo-600 flex-shrink-0">
                <span class="text-white text-xl font-bold">Kepala Puskesmas</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 space-y-2">
                @php
                    function is_active_kepala($routes) {
                        $currentRoute = request()->route()->getName();
                        return in_array($currentRoute, $routes);
                    }
                @endphp
                
                <a href="{{ route('kepala.dashboard') }}"
                    class="flex items-center px-6 py-3 mx-4 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 @if(is_active_kepala(['kepala.dashboard'])) bg-indigo-50 text-indigo-600 border-r-4 border-indigo-500 font-semibold @endif">
                    <i class="fas fa-tachometer-alt w-6 text-center"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                
                <a href="{{ route('kepala.laporan.index') }}"
                    class="flex items-center px-6 py-3 mx-4 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 @if(is_active_kepala(['kepala.laporan.index'])) bg-indigo-50 text-indigo-600 border-r-4 border-indigo-500 font-semibold @endif">
                    <i class="fas fa-clipboard-list w-6 text-center"></i>
                    <span class="ml-3">Laporan Ringan/Sedang</span>
                </a>
                
                <a href="{{ route('kepala.laporan.berat') }}"
                    class="flex items-center px-6 py-3 mx-4 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 @if(is_active_kepala(['kepala.laporan.berat'])) bg-indigo-50 text-indigo-600 border-r-4 border-indigo-500 font-semibold @endif">
                    <i class="fas fa-file-medical-alt w-6 text-center"></i>
                    <span class="ml-3">Laporan KIPI Berat</span>
                </a>
                
                <a href="{{ route('kepala.statistik') }}"
                    class="flex items-center px-6 py-3 mx-4 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 @if(is_active_kepala(['kepala.statistik'])) bg-indigo-50 text-indigo-600 border-r-4 border-indigo-500 font-semibold @endif">
                    <i class="fas fa-chart-bar w-6 text-center"></i>
                    <span class="ml-3">Statistik</span>
                </a>
            </nav>

            <!-- Footer Sidebar -->
            <div class="flex-shrink-0 p-4 border-t border-gray-200">
                <div class="text-xs text-gray-500 text-center">
                    Sistem Pakar KIPI<br>
                    v1.0
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-6 shadow-sm flex-shrink-0">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden">
                    <i class="fas fa-bars fa-lg"></i>
                </button>

                <!-- Breadcrumb atau title (opsional) -->
                <div class="hidden md:block">
                    <h2 class="text-lg font-semibold text-gray-800">
                        @yield('page-title', 'Dashboard')
                    </h2>
                </div>

                <!-- User dropdown -->
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" 
                        class="flex items-center space-x-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600 text-sm"></i>
                            </div>
                            <span class="font-semibold text-gray-700 hidden sm:block">{{ Auth::user()->name ?? 'User' }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </div>
                    </button>
                    
                    <div x-show="dropdownOpen" 
                         @click.away="dropdownOpen = false" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
                        
                        <div class="px-4 py-2 text-sm text-gray-500 border-b border-gray-100">
                            Signed in as<br>
                            <strong class="text-gray-700">{{ Auth::user()->name ?? 'User' }}</strong>
                        </div>
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-sign-out-alt w-4 mr-3 text-gray-400"></i> 
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>