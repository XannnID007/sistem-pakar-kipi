@extends('layouts.pakar')

@section('content')
    <h3 class="mb-4">Halaman Dashboard</h3>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card-box">
                <i class="fas fa-notes-medical"></i>  <!-- ikon gejala/medical notes -->
                <div>
                    <h4>{{$jumlahGejala}}</h4>
                    <p>Gejala</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box">
            <i class="fas fa-list-alt"></i>  <!-- ikon aturan (clipboard list) -->
                <div>
                    <h4>{{$jumlahKategori}}</h4>
                    <p>Kategori KIPI</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box">
                <i class="fas fa-book-medical"></i>  <!-- ikon basis pengetahuan (buku medis) -->
                <div>
                <h4>{{$jumlahPengetahuan}}</h4>
                    <p>Data Pengetahuan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box">
                <i class="fas fa-file-medical-alt"></i>  <!-- ikon diagnosa (file medis) -->
                <div>
                    <h4>{{$jumlahKipiBeratBelumDibaca}}</h4>
                    <p>Laporan KIPI Berat</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box">
                <i class="fas fa-file-medical-alt"></i>  <!-- ikon diagnosa (file medis) -->
                <div>
                    <h4>{{$jumlahKipiRinganSedang}}</h4>
                    <p>Laporan KIPI Ringan dan Sedang</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box">
            <i class="fas fa-user-cog"></i>  <!-- ikon diagnosa (file medis) -->
                <div>
                <h4>{{ $jumlahPakar }}</h4>
                <p>Pakar</p>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box">
            <i class="fas fa-users"></i>  <!-- ikon diagnosa (file medis) -->
                <div>
                    <h4>{{ $jumlahUser }}</h4>
                    <p>Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-box">
            <i class="fas fa-clipboard-list"></i> <!-- ikon diagnosa (file medis) -->
                <div>
                    <h4></h4>
                    <p>Laporan</p>
                </div>
            </div>
        </div>
    </div>
@endsection
