@extends('layouts.app')

@section('title', 'Register - Sistem Pakar KIPI')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="max-width: 420px; width: 100%; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-light fs-4">Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Nama" 
                    value="{{ old('name') }}" 
                    required
                    class="form-control form-control-sm"
                    style="font-size: 0.85rem;"
                >
            </div>

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
                    class="form-control form-control-sm"
                    style="font-size: 0.85rem;"
                >
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password', 'toggleIcon1')">
                    <i id="toggleIcon1" class="fa-solid fa-eye text-muted"></i>
                </span>
            </div>

            <div class="mb-3 position-relative">
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation"
                    placeholder="Konfirmasi Password" 
                    required
                    class="form-control form-control-sm"
                    style="font-size: 0.85rem;"
                >
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                    <i id="toggleIcon2" class="fa-solid fa-eye text-muted"></i>
                </span>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    Register
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="mb-0" style="font-size: 0.85rem;">
                Sudah punya akun? <a href="{{ route('login.form') }}">Login di sini</a>
            </p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0" style="padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li style="font-size: 0.85rem;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endpush
