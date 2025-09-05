<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan KIPI</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        h2, h4 { text-align: center; margin: 0; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="no-print" style="text-align: center; margin-top: 20px;">
@if (session('success'))
    <div id="success-alert" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;">
        ✅ {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 2000); // 3000 ms = 3 detik
    </script>
@endif


    <form method="POST" action="{{route('pakar.riwayat.kipi.kirim')}}" style="display: inline;">
        @csrf
        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
        <input type="hidden" name="bulan" value="{{ request('bulan') }}">
        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
        <button type="submit">📤 Kirim ke Kepala Puskesmas</button>
    </form>

    <button onclick="window.print()"> Cetak Laporan</button>
    <a href="{{ url()->previous() }}">🔙 Kembali</a>
</div>


    <h2>Laporan Diagnosa KIPI Ringan & Sedang</h2>
    <h4>
    Periode:
    @if($request->bulan && $request->tahun)
        {{ \Carbon\Carbon::createFromDate($request->tahun, $request->bulan, 1)->locale('id')->isoFormat('MMMM YYYY') }}
    @elseif($request->tahun)
        Tahun {{ $request->tahun }}
    @else
        Semua Periode
    @endif
</h4>


    <table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anak</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Usia Anak</th>
            <th>Nama Ibu</th>
            <th>Alamat</th>
            <th>Jenis Vaksin</th>
            <th>Tempat Imunisasi</th>
            <th>Tanggal Imunisasi</th>
            <th>Tanggal Diagnosa</th>
            <th>Diagnosa</th>
            <th>Tingkat Keyakinan</th>
            <th>Gejala</th>
            <th>Saran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($riwayat as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->nama_anak }}</td>
            <td>{{ $item->jenis_kelamin}}</td>
            <td>{{ $item->tanggal_lahir}}</td>
            <td>{{ $item->usia_anak }}</td>
            <td>{{ $item->nama_ibu }}</td>
            <td> {{$item->alamat}}</td>
            <td>{{ $item->jenis_vaksin ?? '-' }}</td>
            <td>{{ $item->tempat_imunisasi ?? '-' }}</td>
            <td>
                @if($item->tanggal_imunisasi)
                    {{ \Carbon\Carbon::parse($item->tanggal_imunisasi)->format('d-m-Y') }}
                @else
                    -
                @endif
            </td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
            <td>{{ ucfirst($item->diagnosa) }}</td>
            <td>{{ number_format($item->nilai_cf * 100) }}%</td>
            <td>
                @php
                    $gejalaArray = json_decode($item->gejala_dipilih, true);
                    $gejalaYakin = collect($gejalaArray)->where('cf_user', 1);
                @endphp

                @if ($gejalaYakin->count())
                    <ul style="padding-left: 20px; margin: 0;">
                        @foreach($gejalaYakin as $gejala)
                            <li>{{ $gejala['nama'] ?? '-' }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
            <td>{{ $item->saran }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
