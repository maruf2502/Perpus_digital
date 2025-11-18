@extends('layouts.main')

@section('main-banner')
<div class="container">
    <div class="row">
        <div class="col-lg-6 align-self-center">
            <div class="caption header-text">
                <h6>Welcome In</h6>
                <h2>LIBRARY!</h2>
                <p>Daftar Buku yang Tersedia untuk Dipinjam</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm">
    <h3 class="mb-3 text-dark">Daftar Buku</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- FORM FILTER & SEARCH -->
    <form action="{{ route('peminjamanbuku.index') }}" method="GET" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Urutkan Judul</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Terapkan</button>
        </div>
        <div class="col-md-3">
            @if(request('search') || request('sort'))
                <a href="{{ route('peminjamanbuku.index') }}" class="btn btn-secondary w-100">Reset Filter</a>
            @endif
        </div>
    </form>

    @if($bukus->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th> <!-- Tambahan -->
                        <th>Kategori</th> <!-- Tambahan -->
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bukus as $buku)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->penerbit }}</td>
                            <td>{{ $buku->tahun_terbit }}</td> <!-- Tambahan -->
                            <td>{{ $buku->kategori }}</td> <!-- Tambahan -->
                            <td><span class="badge bg-success">Tersedia</span></td>
                            <td>
                                <a href="{{ route('peminjamanbuku.create', ['buku_id' => $buku->id]) }}" class="btn btn-sm btn-primary">Pinjam</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Tidak ada buku yang tersedia{{ request('search') ? ' untuk "' . request('search') . '"' : '' }}.
        </div>
    @endif
</div>
@endsection
