@extends('layouts.main')

{{-- Menambahkan CSS Khusus dari Desain Admin ke Halaman Member --}}
@push('styles')
    <style>
        /* === Variabel Desain === */
        :root {
            --primary-color: #6366f1;
            --primary-light: #818cf8;
            --success-color: #10b981;
            --success-light: #34d399;
            --warning-color: #f59e0b;
            --warning-light: #fbbf24;
            --danger-color: #ef4444;
            --danger-light: #f87171;
            --text-dark: #1f2937;
            --text-secondary: #4b5563;
            --text-muted: #6b7280;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --border-radius: 16px;
        }

        /* === Animasi Keyframes === */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* === Tata Letak Utama === */
        .main-content {
            background: var(--bg-light);
            min-height: 100vh;
            padding: 2rem;
        }
        .page-title {
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        /* === Kartu Statistik === */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .stat-card {
            background: var(--bg-white);
            padding: 2rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            height: 100%;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }
        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }
        .stat-card-icon {
            width: 70px; height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
            color: white;
            transition: all 0.3s ease;
        }
        .stat-card:hover .stat-card-icon {
            animation: pulse 2s infinite;
        }
        .stat-card-info { flex: 1; }
        .stat-card-title {
            font-size: 1rem; color: var(--text-muted);
            font-weight: 600; margin-bottom: 0.5rem;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        .stat-card-number {
            font-size: 2.75rem; font-weight: 800;
            color: var(--text-dark); line-height: 1;
        }

        /* Warna Khusus Kartu */
        .stat-card.success { border-top: 4px solid var(--success-color); }
        .stat-card.success .stat-card-icon { background: linear-gradient(135deg, var(--success-color), var(--success-light)); }
        .stat-card.primary { border-top: 4px solid var(--primary-color); }
        .stat-card.primary .stat-card-icon { background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); }
        .stat-card.danger { border-top: 4px solid var(--danger-color); }
        .stat-card.danger .stat-card-icon { background: linear-gradient(135deg, var(--danger-color), var(--danger-light)); }

        /* === Wadah Konten Tambahan === */
        .content-card {
            background: var(--bg-white); padding: 2rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            margin-top: 2rem;
            animation: fadeInUp 1s ease-out;
            grid-column: 1 / -1;
        }
        .card-header {
            margin-bottom: 1.5rem; padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .card-title {
            font-size: 1.5rem; font-weight: 700; color: var(--text-dark);
        }

        /* Kartu Buku yang Dipinjam (menggunakan style lama yang sudah bagus) */
        .borrowed-book-card {
            transition: all 0.3s ease;
        }
        .borrowed-book-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
    </style>
@endpush

@section('content')
<main class="main-content">
    <h1 class="page-title">Dashboard Anda</h1>

    {{-- Baris Kartu Statistik --}}
    <div class="dashboard-grid">
        {{-- Kartu Total Koleksi Buku --}}
        <div class="stat-card success">
            <div class="stat-card-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-card-info">
                <div class="stat-card-title">Total Koleksi Buku</div>
                <div class="stat-card-number">{{ $totalBuku }}</div>
            </div>
        </div>

        {{-- Kartu Buku Sedang Anda Pinjam --}}
        <div class="stat-card primary">
            <div class="stat-card-icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="stat-card-info">
                <div class="stat-card-title">Buku Sedang Dipinjam</div>
                <div class="stat-card-number">{{ $bukuDipinjam }}</div>
            </div>
        </div>

        {{-- Kartu Total Denda Anda --}}
        <div class="stat-card danger">
            <div class="stat-card-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="stat-card-info">
                <div class="stat-card-title">Total Denda Anda</div>
                <div class="stat-card-number">Rp {{ number_format($dendaUser, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Wadah untuk daftar buku yang dipinjam --}}
    <div class="content-card">
        <div class="card-header">
            <h4 class="card-title">Buku yang Sedang Anda Pinjam</h4>
        </div>

        @if(isset($bukuDipinjamList) && $bukuDipinjamList->count() > 0)
            <div class="row">
                @foreach($bukuDipinjamList as $peminjaman)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 borrowed-book-card">
                            <div class="position-relative">
                                @if($peminjaman->buku->gambar)
                                    <img src="{{ asset('storage/' . $peminjaman->buku->gambar) }}"
                                         class="card-img-top"
                                         alt="{{ $peminjaman->buku->judul }}"
                                         style="width: 100%; height: auto; object-fit: contain; aspect-ratio: 3/4; background-color: #f8f9fa;">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <i class="fas fa-book text-white fa-3x"></i>
                                    </div>
                                @endif

                                @if($peminjaman->status == 'dipinjam')
                                    <span class="badge bg-warning position-absolute top-0 end-0 m-2">Dipinjam</span>
                                @elseif($peminjaman->status == 'terlambat')
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Terlambat</span>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $peminjaman->buku->judul }}</h5>
                                <div class="mt-auto">
                                    <small class="text-muted">
                                        <strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}<br>
                                        <strong>Batas Kembali:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}
                                    </small>

                                    @if($peminjaman->denda > 0)
                                        <div class="alert alert-danger mt-2 p-2">
                                            <small><strong>Denda:</strong> Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Anda tidak sedang meminjam buku apapun.
                </div>
            </div>
        @endif
    </div>
</main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animasi Angka pada Kartu Statistik
            document.querySelectorAll('.stat-card-number').forEach(counter => {
                const targetText = counter.innerText;
                const isCurrency = targetText.startsWith('Rp');

                // Hanya animasikan jika berupa angka
                if (!isCurrency) {
                    const target = +targetText;
                    if (isNaN(target)) return;

                    counter.innerText = '0';
                    const duration = 1500; // 1.5 detik
                    let startTime = null;

                    const updateCount = (currentTime) => {
                        if (!startTime) startTime = currentTime;
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                        const current = Math.floor(easeOutQuart * target);

                        counter.innerText = current.toLocaleString();

                        if (progress < 1) {
                            requestAnimationFrame(updateCount);
                        } else {
                            counter.innerText = target.toLocaleString();
                        }
                    };
                    requestAnimationFrame(updateCount);
                }
            });
        });
    </script>
@endpush
