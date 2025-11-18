@extends('layouts.main')

@section('main-banner')
    {{-- <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
                        <h6>Welcome In</h6>
                        <h2>LIBRARY!</h2>
                        <p>Form Peminjaman Buku</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm mb-5" style="margin-top: 200px;">
    <h3 class="mb-4 text-dark">Form Peminjaman Buku</h3>

    @if(session('failed'))
        <div class="alert alert-danger">{{ session('failed') }}</div>
    @endif

    <form action="{{ route('peminjamanbuku.store') }}" method="POST">
        @csrf

        {{-- Kolom Judul Buku --}}
        <div class="form-group">
            <label for="judul_buku">Judul Buku</label>
            <input type="text" class="form-control" id="judul_buku" value="{{ $buku->judul }}" readonly>
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
        </div>

        {{-- Kolom Penulis --}}
        <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" class="form-control" id="penulis" value="{{ $buku->penulis }}" readonly>
        </div>

        {{-- Kolom Nama Member --}}
        <div class="form-group">
            <label for="member_name">Nama Member</label>
            <input type="text" class="form-control" value="{{ $member->nama }}" readonly>
            <input type="hidden" name="member_id" value="{{ $member->id }}">
        </div>

        {{-- Kolom Tanggal Pinjam --}}
        <div class="form-group">
            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" readonly>
        </div>

        {{-- Kolom Tanggal Kembali --}}
        <div class="form-group">
            <label for="tanggal_kembali">Pilih Tanggal Kembali</label>
            <select name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
                <option value="">-- Pilih Durasi Pinjam --</option>
                @for ($i = 1; $i <= 4; $i++)
                    @php
                        $tgl = \Carbon\Carbon::now()->addDays($i * 7);
                    @endphp
                    <option value="{{ $tgl->format('Y-m-d') }}">
                        {{ $i * 7 }} Hari ({{ $tgl->translatedFormat('d F Y') }})
                    </option>
                @endfor
            </select>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('peminjamanbuku.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Pinjam Sekarang</button>
        </div>
    </form>
</div>
@endsection
