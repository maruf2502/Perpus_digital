@extends('layouts.main')

@section('main-banner')
{{--
<div class="container">
    <div class="row">
        <div class="col-lg-6 align-self-center">
            <div class="caption header-text">
                <h6>Welcome In</h6>
                <h2>LIBRARY!</h2>
                <p>Daftar Member yang Sedang Meminjam Buku</p>
            </div>
        </div>
    </div>
</div>
--}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm" style="margin-top: 120px;">
    <h3 class="mb-4 text-dark">Daftar Member yang Sedang Meminjam Buku</h3>

    <!-- Filter dan Search -->
    <form action="{{ route('admin.daftar.peminjam') }}" method="GET" class="row mb-3 g-2">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email member..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Urutkan Nama</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Terapkan</button>
        </div>
        <div class="col-md-3">
            @if(request('search') || request('sort'))
                <a href="{{ route('admin.daftar.peminjam') }}" class="btn btn-secondary w-100">Reset</a>
            @endif
        </div>
    </form>

    @if($peminjamans->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Member</th>
                        <th>Email</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $index => $peminjaman)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $peminjaman->member->nama }}</td>
                            <td>{{ $peminjaman->member->email }}</td>
                            <td>{{ $peminjaman->buku->judul }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $peminjaman->tanggal_kembali }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Tidak ada member yang sedang meminjam buku.</div>
    @endif
</div>
@endsection
