@extends('layouts.main')

@section('features')
    <div class="container bg-white p-4 rounded shadow-sm mb-5" style="margin-top: 200px;">
        <h3 class="mb-4 text-dark">Form Edit Buku</h3>

        <form action="{{ route('admin.bukus.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>
                @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="penulis">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required>
                @error('penulis') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="penerbit">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required>
                @error('penerbit') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori', $buku->kategori) }}" required>
                @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
                @error('tahun_terbit') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="jumlah_unit">Jumlah Unit</label>
                <input type="number" class="form-control" id="jumlah_unit" name="jumlah_unit" value="{{ old('jumlah_unit', $buku->jumlah_unit) }}" required>
                @error('jumlah_unit') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="gambar" class="form-label">Ganti Gambar Sampul</label>
                <input class="form-control" type="file" id="gambar" name="gambar">
                @error('gambar') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            @if($buku->gambar)
                <div class="mt-2">
                    <label>Gambar Saat Ini:</label><br>
                    <img src="{{ asset('storage/' . $buku->gambar) }}" alt="Gambar Sampul" style="width: 150px; border-radius: 8px;">
                </div>
            @endif

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.bukus.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
@endsection
