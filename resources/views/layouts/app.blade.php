<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Sistem Pakar KIPI')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="h-full font-sans antialiased">
    <div id="app" class="flex flex-col min-h-screen">

        <nav class="bg-white shadow-sm sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <a href="{{ auth()->check() ? route('dashboard.user') : url('/') }}"
                            class="text-xl font-bold text-indigo-600 hover:text-indigo-700 transition">
                            KIPI Expert
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-sm font-medium text-gray-700 hidden sm:block">
                                Halo, <span class="font-semibold">{{ Auth::user()->name }}</span>
                            </span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login.form') }}"
                                class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Login</a>
                            <a href="{{ route('register.form') }}"
                                class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            @yield('content')
        </main>

    </div>
</body>

</html>
