@extends('layouts.main')

@section('main-banner')
{{-- <div class="container">
    <div class="row">
        <div class="col-lg-6 align-self-center">
            <div class="caption header-text">
                <h6>Welcome In</h6>
                <h2>LIBRARY!</h2>
                <p>Daftar Member</p>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm" style="margin-top: 130px;">
    <h3 class="mb-3 text-dark">Daftar Member</h3>

    <!-- FORM FILTER & SEARCH -->
    <form action="{{ route('admin.members.index') }}" method="GET" class="row mb-4 g-2">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email" value="{{ request('search') }}">
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
                <a href="{{ route('admin.members.index') }}" class="btn btn-secondary w-100">Reset Filter</a>
            @endif
        </div>
    </form>

    @if($members->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>{{ ($members->currentPage() - 1) * $members->perPage() + $loop->iteration }}</td>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->nama }}</td>
                            <td>{{ $member->alamat }}</td>
                            <td>{{ $member->nomer_telepon }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus member ini?')">
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

        <!-- PAGINATION TANPA PANAH -->
        <div class="d-flex justify-content-center mt-4">
            @if ($members->lastPage() > 1)
                <nav>
                    <ul class="pagination">
                        @for ($i = 1; $i <= $members->lastPage(); $i++)
                            <li class="page-item {{ $i == $members->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $members->url($i) }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </nav>
            @endif
        </div>
    @else
        <div class="alert alert-info">
            @if(request('search'))
                Tidak ada hasil yang ditemukan untuk pencarian "<strong>{{ request('search') }}</strong>".
            @else
                Tidak ada member yang tersedia.
            @endif
        </div>
    @endif

    <!-- Tombol Tambah Member -->
    <div class="mt-4">
        <a href="{{ route('admin.members.create') }}"
           class="btn"
           style="background-color: blue; color: white; border: 2px solid green;">
            + Tambah Member
        </a>
    </div>
</div>
@endsection
