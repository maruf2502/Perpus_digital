@extends('layouts.main')

@section('conten')
    <div class="container mt-5">
        <h2>Tambah Buku Baru</h2>

        {{-- Sukses --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi Kesalahan Input:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.bukus.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
            </div>

            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis') }}" required>
            </div>

            <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required>
            </div>

            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Buku</button>
            <a href="{{ route('admin.bukus.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
