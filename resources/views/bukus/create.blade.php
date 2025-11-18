@extends('layouts.main')

@section('features')
<div class="container bg-white p-4 rounded shadow-sm" style="margin-top: 130px;">
    <h3 class="mb-4 text-dark">Form Tambah Buku</h3>

    <form action="{{ route('admin.bukus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
            @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="penulis">Penulis</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis') }}" required>
            @error('penulis') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="penerbit">Penerbit</label>
            <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required>
            @error('penerbit') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="kategori">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori') }}" required>
            @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required>
            @error('tahun_terbit') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="jumlah_unit">Jumlah Unit</label>
            <input type="number" class="form-control" id="jumlah_unit" name="jumlah_unit" value="{{ old('jumlah_unit') }}" required>
            @error('jumlah_unit') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-4">
            <label for="gambar">Gambar Sampul</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            @error('gambar') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.bukus.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>
@endsection
