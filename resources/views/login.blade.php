@extends('layouts.app')

@section('title', 'Login - Sistem Pakar KIPI')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 79vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-light fs-4">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email" 
                    value="{{ old('email') }}" 
                    required
                    class="form-control form-control-sm"
                    style="font-size: 0.85rem;"
                >
            </div>

            <div class="mb-3 position-relative">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Password" 
                    required
                    class="form-control form-control-sm pe-5"
                    style="font-size: 0.85rem;"
                >
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword()">
                    <i id="toggleIcon" class="fa-solid fa-eye text-muted"></i>
                </span>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-sm" style="font-size: 0.9rem;">
                Login
            </button>
        </form>

        <div class="text-center mt-3 fs-7">
            <p style="font-size: 0.8rem;">Belum punya akun? 
                <a href="{{ route('register.form') }}" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.8rem;">
                    Daftar di sini
                </a>
            </p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3" style="font-size: 0.85rem;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
