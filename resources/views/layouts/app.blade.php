<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Pakar KIPI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome (di <head>) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f9ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgb(21, 140, 156);
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            z-index: 1000;
        }

        .nav-left {
            font-weight: bold;
            font-size: 16px;
            color: white;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-right span {
            font-size: 13px;
            font-weight: 600;
            color: white;
        }

        .nav-right a,
        .nav-right button {
            color: white;
            font-weight: 600;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .nav-right a:hover,
        .nav-right button:hover {
            color: #b2e0e5;
        }

        main {
            flex-grow: 1;
            padding: 30px 30px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .container {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            text-align: left;
            flex-wrap: wrap;
        }

        .welcome h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .menu {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 25px;
            flex-wrap: wrap;
        }

        .menu a {
            display: block;
            width: 180px;
            padding: 20px;
            background: white;
            border: 2px solid #2563eb;
            border-radius: 12px;
            text-decoration: none;
            color: black;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
        }

        .menu a:hover {
            background-color: #2563eb;
            color: white;
        }

        .menu-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .illustration {
            margin-top: 30px;
        }
        footer {
            background-color: rgb(4, 95, 107);
            color: white;
            padding: 12px 0;
            width: 100%;
            text-align: center;
            font-size: 14px;
            position: relative;
            user-select: none;
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-left">
        Sistem Pakar KIPI
    </div>
    <div class="nav-right">
        @auth
            <span>{{ Auth::user()->name }}</span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline-flex; align-items: center;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register.form') }}">Register</a>
        @endauth
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer>
    Sistem Pakar Diagnosa Gejala KIPI &copy; 2025
</footer>

</body>
</html>
