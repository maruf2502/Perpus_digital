@extends('layouts.main')

@section('main-banner')
{{-- <div class="container">
    <div class="row">
        <div class="col-lg-6 align-self-center">
            <div class="caption header-text">
                <h6>Welcome In</h6>
                <h2>LIBRARY!</h2>
                <p>Daftar Pengembalian Buku</p>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm" style="margin-top: 130px;">
    <h3 class="mb-3 text-dark">Daftar Buku yang Dipinjam</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($peminjamans->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Nama Member</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->buku->judul }}</td>
                            <td>{{ $peminjaman->buku->penulis }}</td>
                            <td>{{ $peminjaman->member->nama }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $peminjaman->tanggal_kembali }}</td>
                            <td>
                                @if($peminjaman->tanggal_pengembalian)
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @endif
                            </td>
                            <td>
                                @if(!$peminjaman->tanggal_pengembalian)
                                    <a href="{{ route('pengembalianbuku.form', $peminjaman->id) }}" class="btn btn-sm btn-primary">Kembalikan</a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Tidak ada buku yang sedang dipinjam.</div>
    @endif
</div>
@endsection
