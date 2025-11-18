@extends('layouts.main')

@section('content')
<div class="container bg-white p-4 rounded shadow-sm my-5">
    <h3 class="mb-4">Form Pembayaran Denda</h3>

   <form action="{{ route('admin.laporan.bayar_denda_proses', $member->id) }}" method="POST">
        @csrf

        {{-- Informasi Member --}}
        <div class="form-group mb-3">
            <label>Nama Member</label>
            <input type="text" class="form-control" value="{{ $member->nama }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="text" class="form-control" value="{{ $member->email }}" readonly>
        </div>

        {{-- Daftar Buku yang Didenda --}}
        <div class="form-group mb-3">
            <label>Buku yang Didenda</label>
            @php
                $totalDenda = 0;
            @endphp

            @if($member->peminjamans->count() > 0)
                <ul class="list-group">
                    @foreach($member->peminjamans as $pinjam)
                        @if($pinjam->denda > 0)
                            @php
                                $totalDenda += $pinjam->denda;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $pinjam->buku->judul ?? 'Judul tidak tersedia' }}
                                <span class="badge bg-danger text-white">
                                    Rp {{ number_format($pinjam->denda, 0, ',', '.') }}
                                </span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Tidak ada buku yang sedang didenda.</p>
            @endif
        </div>

        {{-- Tampilkan Total Denda dan Kirim sebagai Hidden Input --}}
        @if($totalDenda > 0)
        <div class="form-group mb-3 text-end fw-bold">
            Total Denda: <span class="text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
            <input type="hidden" name="total_denda" value="{{ $totalDenda }}">
        </div>
        @endif

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('laporan.denda') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
        </div>
    </form>
</div>
@endsection
