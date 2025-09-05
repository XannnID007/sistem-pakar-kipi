@extends('layouts.kepala')

@section('content')
<div class="container mt-5">
    <h2>Dashboard Kepala Puskesmas</h2>

    <div class="row g-4">
        <!-- KIPI Berat -->
        <div class="col-md-4">
            <div class="card-box bg-warning p-3 rounded shadow-sm d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3 text-dark"></i>
                <div>
                    <h4 class="mb-0"></h4>
                    <p class="mb-0">Laporan KIPI Berat</p>
                </div>
            </div>
        </div>

        <!-- KIPI Ringan & Sedang -->
        <div class="col-md-4">
            <div class="card-box bg-info p-3 rounded shadow-sm d-flex align-items-center">
                <i class="fas fa-clipboard-list fa-2x me-3 text-white"></i>
                <div>
                    <h4 class="mb-0"></h4>
                    <p class="mb-0 text-white">Laporan KIPI Ringan & Sedang</p>
                </div>
            </div>
        </div>

        <!-- Statistik Placeholder -->
        <div class="col-md-4">
            <div class="card-box bg-secondary p-3 rounded shadow-sm d-flex align-items-center">
                <i class="fas fa-chart-bar fa-2x me-3 text-white"></i>
                <div>
                    <h4 class="mb-0">-</h4>
                    <p class="mb-0 text-white">Statistik</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
