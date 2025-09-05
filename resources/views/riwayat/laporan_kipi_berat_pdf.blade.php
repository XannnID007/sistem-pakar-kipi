<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Diagnosa KIPI Berat</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2 { text-align: center; margin-bottom: 0; }
    </style>
</head>
<body>

    <h2>Laporan Diagnosa KIPI Berat</h2>

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
            <tr>
                <td>1</td>
                <td>{{ $riwayat->nama_anak }}</td>
                <td>{{ $riwayat->jenis_kelamin }}</td>
                <td>{{ $riwayat->tanggal_lahir }}</td>
                <td>{{ $riwayat->usia_anak }}</td>
                <td>{{ $riwayat->nama_ibu }}</td>
                <td>{{ $riwayat->alamat }}</td>
                <td>{{ $riwayat->jenis_vaksin ?? '-' }}</td>
                <td>{{ $riwayat->tempat_imunisasi ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d-m-Y') }}</td>
                <td>{{ ucfirst($riwayat->diagnosa) }}</td>
                <td>{{ number_format($riwayat->nilai_cf * 100, 2) }}%</td>
                <td>
                    <ul style="padding-left: 20px; margin: 0;">
                        @foreach ($gejala as $g)
                            @if (isset($g['cf_user']) && $g['cf_user'] == 1)
                                <li>{{ $g['nama'] ?? '-' }}</li>
                            @endif
                        @endforeach
                    </ul>
                </td>
                <td>{{ $riwayat->saran }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
