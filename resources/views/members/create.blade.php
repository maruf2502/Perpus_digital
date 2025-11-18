@extends('layouts.main')

@section('main-banner')
    {{-- <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
                        <h6>Welcome In</h6>
                        <h2>LIBRARY!</h2>
                        <p>Form Tambah Member</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm mb-5" style="margin-top: 220px; min-height: 100vh;">
    <h3 class="mb-4 text-dark">Form Tambah Member</h3>

    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" required>
            @error('alamat')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nomer_telepon">Nomor Telepon</label>
            <input type="text" class="form-control" id="nomer_telepon" name="nomer_telepon" placeholder="08xxxxxxxxxx" required>
            @error('nomer_telepon')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="role">Pilih Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
                <option value="guest">Guest</option>
            </select>
            @error('role')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>
@endsection
