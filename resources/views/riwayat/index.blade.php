@extends('layouts.main')

@section('main-banner')
{{-- <div class="container">
    <div class="row">
        <div class="col-lg-6 align-self-center">
            <div class="caption header-text">
                <h6>Welcome In</h6>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm" style="margin-top: 130px;">
    <h3 class="mb-4 text-dark">Riwayat Peminjaman Buku Anda</h3>

    <!-- Filter dan Search -->
    <form action="{{ route('riwayat.peminjaman') }}" method="GET" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari judul buku..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Urutkan Tanggal Pinjam</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Terapkan</button>
        </div>
        <div class="col-md-3">
            @if(request('search') || request('sort'))
                <a href="{{ route('riwayat.peminjaman') }}" class="btn btn-secondary w-100">Reset</a>
            @endif
        </div>
    </form>

    <!-- Tabel Riwayat -->
    @if($riwayats->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayats as $riwayat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $riwayat->buku->judul }}</td>
                            <td>{{ $riwayat->tanggal_pinjam }}</td>
                            <td>{{ $riwayat->tanggal_kembali }}</td>
                            <td>{{ $riwayat->tanggal_pengembalian ?? '-' }}</td>
                            <td>
                                @php
                                    $tglKembali = \Carbon\Carbon::parse($riwayat->tanggal_kembali);
                                    $tglPengembalian = \Carbon\Carbon::parse($riwayat->tanggal_pengembalian);
                                    $hariTerlambat = $tglPengembalian->greaterThan($tglKembali) ? $tglPengembalian->diffInDays($tglKembali) : 0;
                                    $dendaHitung = $hariTerlambat * 10000;
                                @endphp
                                Rp {{ number_format($riwayat->denda ?? $dendaHitung, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Belum ada riwayat peminjaman.</div>
    @endif
</div>
@endsection
