@extends('layouts.main')

@section('main-banner')
{{-- <div class="main-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 align-self-center">
        <div class="caption header-text">
          <h6>Welcome In</h6>
          <h2>LIBRARY!</h2>
          <p>Edit Member</p>
        </div>
      </div>
    </div>
  </div>
</div> --}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm mb-5" style="margin-top: 200px;">
  <h3 class="mb-4 text-dark">Form Edit Member</h3>

  <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
      <label for="nama">Nama</label>
      <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $member->nama) }}" required>
      @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group mb-3">
      <label for="alamat">Alamat</label>
      <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $member->alamat) }}" required>
      @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group mb-3">
      <label for="nomer_telepon">Nomor Telepon</label>
      <input type="text" class="form-control" id="nomer_telepon" name="nomer_telepon" value="{{ old('nomer_telepon', $member->nomer_telepon) }}" required>
      @error('nomer_telepon') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group mb-3">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $member->email) }}" required>
      @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group mb-4">
      <label for="password">Password (Opsional)</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
      @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="d-flex justify-content-between">
      <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Kembali</a>
      <button type="submit" class="btn btn-success">Update</button>
    </div>
  </form>
</div>
@endsection
