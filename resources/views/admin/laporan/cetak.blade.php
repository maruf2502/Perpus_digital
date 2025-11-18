<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        h2 { text-align: center; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        td, th { border: 1px solid #000; padding: 10px; text-align: left; }
    </style>
</head>
<body onload="window.print()">

    @php
        use Carbon\Carbon;
        // Tampilkan nama bulan berdasarkan angka $bulan
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
    @endphp

    <h2>Laporan Perpustakaan</h2>
    <h4>Bulan {{ $namaBulan }} - Tahun {{ $tahun }}</h4>
    <table>
        <tr>
            <th>Jumlah Buku Masuk Bulan Ini</th>
            <td>{{ $jumlahBukuBulanIni }}</td>
        </tr>
        <tr>
            <th>Jumlah Buku Dipinjam</th>
            <td>{{ $jumlahBukuDipinjam }}</td>
        </tr>
        <tr>
            <th>Jumlah Anggota Aktif</th>
            <td>{{ $anggotaAktif }}</td>
        </tr>
    </table>

</body>
</html>
