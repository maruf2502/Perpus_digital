@extends('layouts.main')

@section('main-banner')
{{-- <div class="container">
    <div class="row">
        <div class="col-lg-6 align-self-center">
            <div class="caption header-text">
                <h6>Welcome In</h6>
                <h2>LIBRARY!</h2>
                <p>Data Buku</p>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm" style="margin-top: 130px;">
    <h3 class="mb-3 text-dark">Data Buku</h3>

    <!-- Filter & Search -->
    <form action="{{ route('admin.bukus.index') }}" method="GET" class="row mb-3 g-2">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari judul, penulis, tahun, kategori..." value="{{ request('search') }}">
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
                <a href="{{ route('admin.bukus.index') }}" class="btn btn-secondary w-100">Reset</a>
            @endif
        </div>
    </form>

    @if($bukus->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Kategori</th>
                        <th>Tahun Terbit</th>
                        <th>Jumlah Unit</th> <!-- Tambahan -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bukus as $buku)
                        <tr>
                            <td>{{ ($bukus->currentPage() - 1) * $bukus->perPage() + $loop->iteration }}</td>
                            <td>{{ $buku->id }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->penerbit }}</td>
                            <td>{{ $buku->kategori }}</td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>{{ $buku->jumlah_unit }}</td> <!-- Tambahan -->
                            <td>
                                <a href="{{ route('admin.bukus.edit', $buku->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.bukus.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION: angka saja -->
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    @for ($i = 1; $i <= $bukus->lastPage(); $i++)
                        <li class="page-item {{ $i == $bukus->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $bukus->url($i) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor
                </ul>
            </nav>
        </div>
    @else
        <div class="alert alert-info">
            @if(request('search'))
                Tidak ada buku yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>".
            @else
                Tidak ada buku yang tersedia.
            @endif
        </div>
    @endif

    <!-- Tombol Tambah Buku -->
    <div class="mt-4">
        <a href="{{ route('admin.bukus.create') }}"
           class="btn"
           style="background-color: blue; color: white; border: 2px solid green;">
            + Tambah Buku
        </a>
    </div>
</div>
@endsection
