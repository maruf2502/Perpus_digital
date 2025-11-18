@extends('layouts.main')

@section('main-banner')
@endsection

@section('features')
<div class="container bg-white p-4 rounded shadow-sm mb-5" style="margin-top: 120px;">
    <h3 class="mb-4 text-dark">Form Pengembalian Buku</h3>

    @if(session('failed'))
        <div class="alert alert-danger">{{ session('failed') }}</div>
    @endif


    <form action="{{ route('pengembalianbuku.kembalikan', $peminjaman->id) }}" method="POST">

        @csrf

        {{-- Informasi Buku --}}
        <div class="form-group mb-3">
            <label>Judul Buku</label>
            <input type="text" class="form-control" value="{{ $peminjaman->buku->judul }}" readonly>
        </div>

        {{-- Informasi Member --}}
        <div class="form-group mb-3">
            <label>Nama Member</label>
            <input type="text" class="form-control" value="{{ $peminjaman->member->nama }}" readonly>
        </div>

        {{-- Tanggal Pinjam --}}
        <div class="form-group mb-3">
            <label>Tanggal Pinjam</label>
            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}" readonly>
        </div>

        {{-- Tanggal Kembali (Jatuh Tempo) --}}
        <div class="form-group mb-3">
            <label>Jatuh Tempo</label>
            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}" readonly>
            <input type="hidden" id="tanggal_kembali_value" value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d') }}">
        </div>

        {{-- Input Tanggal Pengembalian --}}
        <div class="form-group mb-3">
            <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="form-control" value="{{ now()->toDateString() }}" required>
            @error('tanggal_pengembalian')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Denda --}}
        <div class="form-group mb-3">
            <label>Denda</label>
            <input type="text" id="denda_display" class="form-control text-danger" value="Rp 0" readonly>
            <input type="number" name="denda" id="denda_input" class="form-control d-none" readonly>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('pengembalianbuku.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Konfirmasi Pengembalian</button>
        </div>
    </form>
</div>

<style>
    .d-none { display: none; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const tanggalKembali = new Date(document.getElementById('tanggal_kembali_value').value); // fix di sini
    const inputPengembalian = document.getElementById('tanggal_pengembalian');
    const inputDenda = document.getElementById('denda_input');
    const displayDenda = document.getElementById('denda_display');
    const dendaPerHari = 10000;

    function hitungDenda() {
        const tglPengembalian = new Date(inputPengembalian.value);
        const selisihHari = Math.floor((tglPengembalian - tanggalKembali) / (1000 * 60 * 60 * 24));
        const denda = selisihHari > 0 ? selisihHari * dendaPerHari : 0;

        inputDenda.value = denda;
        displayDenda.value = `Rp ${denda.toLocaleString('id-ID')}`;
    }

    inputPengembalian.addEventListener('change', hitungDenda);
    hitungDenda(); // hitung saat pertama kali load
});
</script>
@endsection
