@extends('layouts.main')

@section('main-banner')
@endsection

@section('content')
<div class="container my-5">
    <h3 class="text-center mb-2">Pilih dan Pinjam Buku</h3>
    <p class="text-center text-muted mb-4">Jelajahi koleksi buku yang tersedia di perpustakaan kami.</p>

    {{-- Alert jika ada denda --}}
    @if($totalDendaUser > 0)
        <div class="alert alert-danger text-center">
            Anda masih memiliki denda sebesar <strong>Rp {{ number_format($totalDendaUser, 0, ',', '.') }}</strong>.
            Harap lunasi terlebih dahulu sebelum meminjam buku.
        </div>
    @endif

    {{-- Form pencarian --}}
    @if($totalDendaUser == 0)
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <form method="GET" action="{{ route('peminjamanbuku.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Daftar Buku --}}
    @if($daftarBuku->count() > 0)
        <div class="row">
            @foreach($daftarBuku as $buku)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm h-100">
                        @if($buku->gambar)
                            <img src="{{ asset('storage/' . $buku->gambar) }}"
                                 class="card-img-top"
                                 alt="{{ $buku->judul }}"
                                 style="width: 100%; height: auto; object-fit: contain; aspect-ratio: 3/4; background-color: #f8f9fa;">
                        @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-book-open text-white fa-3x"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold">{{ Str::limit($buku->judul, 45) }}</h6>
                            <p class="card-text small text-muted">{{ $buku->penulis }}</p>
                            <p class="small"><span class="badge bg-info text-dark">{{ $buku->kategori }}</span></p>

                            <p class="small text-muted">
                                Tersedia:
                                <span class="{{ $buku->jumlah_unit == 0 ? 'text-danger fw-bold' : '' }}">
                                    {{ $buku->jumlah_unit }} unit
                                </span>
                            </p>

                            <div class="mt-auto text-center">
                                @if($totalDendaUser > 0)
                                    <button class="btn btn-sm btn-danger w-100" disabled>Ada Denda</button>
                                @elseif($buku->jumlah_unit > 0)
                                    <a href="{{ route('peminjamanbuku.create', ['buku_id' => $buku->id]) }}" class="btn btn-sm btn-primary w-100">Pinjam</a>
                                @else
                                    <button class="btn btn-sm btn-secondary w-100" disabled>Stok Habis</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination angka saja (tanpa panah) --}}
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    @foreach ($daftarBuku->getUrlRange(1, $daftarBuku->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $daftarBuku->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    @else
        <div class="text-center">
            <div class="alert alert-warning">
                Buku yang Anda cari tidak ditemukan.
            </div>
        </div>
    @endif
</div>

{{-- CSS Styling untuk pagination angka --}}
<style>
    .pagination {
        display: flex;
        gap: 6px;
    }

    .pagination .page-link {
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 6px;
        color: #0d6efd;
        border: 1px solid #dee2e6;
        background-color: #fff;
        text-decoration: none;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
    }
</style>
@endsection
