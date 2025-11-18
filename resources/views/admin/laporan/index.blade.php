@extends('layouts.main')

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">Laporan Perpustakaan</h2>

        {{-- Filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.index') }}"
                    class="row g-3 justify-content-center align-items-end">
                    <div class="col-md-4">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            @foreach (range(1, 12) as $bln)
                                <option value="{{ $bln }}" {{ $bln == $bulan ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            @for ($i = now()->year; $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- Laporan Statistik (Kartu Ringkasan) --}}
        <div class="row text-center mb-4">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-muted">Total Buku</h5>
                        <h2 class="display-4">{{ $totalBuku }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-muted">Total Anggota</h5>
                        <h2 class="display-4">{{ $totalAnggota }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-muted">Peminjam Bulan Ini</h5>
                        <h2 class="display-4">{{ $anggotaMeminjam }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-muted">Buku Dipinjam Bulan Ini</h5>
                        <h2 class="display-4">{{ $bukuDipinjam }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Cetak --}}
        {{-- <div class="text-center my-4">
            <a href="{{ route('admin.laporan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank"
                class="btn btn-danger btn-lg shadow-sm">
                <i class="fas fa-print me-2"></i>Cetak Laporan
            </a>
        </div> --}}

        <hr class="my-5">

        <!-- ======================================================= -->
        <!-- TABEL-TABEL DETAIL LAPORAN DENGAN DESAIN BARU -->
        <!-- ======================================================= -->
        <div class="row">

            <!-- Tabel 1: Peminjaman pada Bulan Terpilih -->
            <div class="col-12 mb-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="m-0 text-white"><i class="fas fa-book me-2"></i>Daftar Peminjaman pada {{ $namaBulan }}
                            {{ $tahun }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Peminjam</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Jatuh Tempo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($peminjamanAktif as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->buku->judul ?? 'N/A' }}</td>
                                            <td>{{ $item->member->nama ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center p-4">Tidak ada peminjaman pada periode ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel 2: Anggota Aktif -->
            <div class="col-md-6 mb-5">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="m-0 text-white"><i class="fas fa-book me-2""></i>Anggota Aktif pada {{ $namaBulan }}
                            {{ $tahun }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($anggotaAktif as $anggota)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $anggota->nama }}</td>
                                            <td>{{ $anggota->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center p-4">Tidak ada anggota yang aktif meminjam.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel 3: Anggota Tidak Aktif -->
            <div class="col-md-6 mb-5">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="m-0 text-white"><i class="fas fa-book me-2"></i>Anggota Tidak Aktif pada {{ $namaBulan }}
                            {{ $tahun }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($anggotaTidakAktif as $anggota)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $anggota->nama }}</td>
                                            <td>{{ $anggota->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center p-4">Semua anggota meminjam pada periode ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel 4: Laporan Denda -->
            <div class="col-12 mb-5">
                <div class="card shadow border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="m-0 text-white"><i class="fas fa-book me-2"></i>Laporan Denda pada {{ $namaBulan }}
                            {{ $tahun }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Anggota</th>
                                        <th>Total Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($anggotaDenganDenda as $member)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $member->nama }}</td>
                                            <td>Rp {{ number_format($member->total_denda, 0, ',', '.') }}</td>
                                            <td>
                                            <a href="{{ route('admin.laporan.bayar_denda', $member->id) }}" class="btn btn-sm btn-success">Bayar Denda</a>
                                            </td>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center p-4">Tidak ada denda pada periode ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel 5: Total Data Buku -->
            <div class="col-12 mb-5">
                <div class="card shadow">
                    <div class="card-header bg-dark">
                        <h5 class="m-0 text-white"><i class="fas fa-book me-2"></i>Daftar Seluruh Buku</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($semuaBuku as $buku)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $buku->judul }}</td>
                                            <td>{{ $buku->penulis }}</td>
                                            <td>{{ $buku->jumlah_unit }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center p-4">Tidak ada data buku.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
