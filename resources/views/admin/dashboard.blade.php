@extends('layouts.main')

{{-- Menambahkan CSS Khusus hanya untuk Halaman Dashboard --}}
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
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --border-radius: 16px;
            --border-radius-sm: 8px;
        }

        /* === Animasi Keyframes === */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }
            100% {
                background-position: calc(200px + 100%) 0;
            }
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
            background: var(--bg-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .grid-col-span-full {
            grid-column: 1 / -1;
        }

        @media (min-width: 1024px) {
            .grid-col-span-2 {
                grid-column: span 2;
            }

            .dashboard-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* === Desain Ulang Kartu Statistik === */
        .stat-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
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

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-light);
        }

        .stat-card-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-card-icon {
            animation: pulse 2s infinite;
        }

        .stat-card-info {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .stat-card-title {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-card-number {
            font-size: 2.75rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
        }

        /* === Warna Khusus untuk Kartu === */
        .stat-card.primary {
            border-top: 4px solid var(--primary-color);
        }

        .stat-card.primary .stat-card-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

        .stat-card.success {
            border-top: 4px solid var(--success-color);
        }

        .stat-card.success .stat-card-icon {
            background: linear-gradient(135deg, var(--success-color), var(--success-light));
            color: white;
        }

        .stat-card.warning {
            border-top: 4px solid var(--warning-color);
        }

        .stat-card.warning .stat-card-icon {
            background: linear-gradient(135deg, var(--warning-color), var(--warning-light));
            color: white;
        }

        /* === Wadah untuk Chart dan Aktivitas === */
        .content-card {
            background: var(--bg-white);
            padding: 2rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out;
        }

        .content-card:hover {
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--bg-gradient);
            border-radius: 2px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-title::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--primary-color);
            border-radius: 50%;
            display: inline-block;
        }

        /* === Form Select Styling === */
        .form-select-custom {
            background: var(--bg-white);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-select-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* === Daftar Aktivitas Terbaru === */
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 400px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--border-color) transparent;
        }

        .activity-list::-webkit-scrollbar {
            width: 6px;
        }

        .activity-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .activity-list::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
        }

        .activity-list::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: var(--border-radius-sm);
            margin-bottom: 0.5rem;
        }

        .activity-item:hover {
            background: var(--bg-light);
            transform: translateX(8px);
        }

        .activity-item:not(:last-child) {
            border-bottom: 1px solid var(--border-color);
        }

        .activity-icon {
            font-size: 1.4rem;
            padding: 0.75rem;
            background: var(--bg-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .activity-item:hover .activity-icon {
            transform: scale(1.1);
        }

        .activity-content {
            flex: 1;
        }

        .activity-content p {
            margin: 0 0 0.5rem 0;
            font-size: 1rem;
            line-height: 1.5;
        }

        .activity-content p strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        .activity-content p em {
            color: var(--primary-color);
            font-weight: 600;
            font-style: normal;
        }

        .activity-time {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* === Chart Container === */
        .chart-container {
            height: 400px;
            position: relative;
            padding: 1rem;
            background: linear-gradient(145deg, #f8fafc 0%, #ffffff 100%);
            border-radius: var(--border-radius-sm);
        }

        .donut-chart-container {
            height: 350px;
            max-width: 500px;
            margin: auto;
            padding: 1rem;
        }

        /* === Empty State === */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* === Responsive Adjustments === */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .page-title {
                font-size: 2rem;
                margin-bottom: 1.5rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .card-header {
                flex-direction: column;
                gap: 1rem;
            }
        }

        /* === Loading Animation === */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* === Hover Effects untuk Cards === */
        @media (hover: hover) {
            .content-card:hover {
                transform: translateY(-2px);
            }
        }
    </style>
@endpush

@section('content')
    <main class="main-content">
        <h1 class="page-title">Dashboard Admin Perpustakaan</h1>

        <div class="dashboard-grid">
            {{-- Baris Kartu Statistik --}}
            <div class="grid-col-span-full">
                <div class="dashboard-grid">
                    {{-- Kartu Total Anggota --}}
                    <a href="{{ route('admin.members.index') }}" class="stat-card-link">
                        <div class="stat-card primary">
                            <div class="stat-card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-card-info">
                                <div class="stat-card-title">Total Anggota</div>
                                <div class="stat-card-number">{{ $totalAnggota }}</div>
                            </div>
                        </div>
                    </a>

                    {{-- Kartu Total Buku --}}
                    <a href="{{ route('admin.bukus.index') }}" class="stat-card-link">
                        <div class="stat-card success">
                            <div class="stat-card-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-card-info">
                                <div class="stat-card-title">Total Buku</div>
                                <div class="stat-card-number">{{ $totalBuku }}</div>
                            </div>
                        </div>
                    </a>

                    {{-- Kartu Sedang Meminjam --}}
                    <a href="{{ route('admin.daftar.peminjam') }}" class="stat-card-link">
                        <div class="stat-card warning">
                            <div class="stat-card-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <div class="stat-card-info">
                                <div class="stat-card-title">Sedang Meminjam</div>
                                <div class="stat-card-number">{{ $anggotaMeminjam }}</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Card untuk Grafik Peminjaman --}}
            <div class="content-card grid-col-span-2">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        Grafik Peminjaman Buku
                    </h4>
                    <form method="GET" class="d-flex">
                        <select name="tahun" class="form-select-custom" onchange="this.form.submit()">
                            @foreach ($tahunList as $thn)
                                <option value="{{ $thn }}" {{ $thn == $tahun ? 'selected' : '' }}>
                                    {{ $thn }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="chart-container">
                    <canvas id="grafikPeminjaman"></canvas>
                </div>
            </div>

            {{-- Card untuk Aktivitas Terbaru --}}
            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-clock"></i>
                        Aktivitas Terbaru
                    </h4>
                </div>
                <ul class="activity-list">
                    @forelse ($aktivitasTerbaru as $aktivitas)
                        <li class="activity-item">
                            <div class="activity-icon"
                                style="color: {{ ['#6366f1', '#10b981', '#f59e0b', '#ef4444'][$loop->index % 4] }};
                                       background-color: {{ ['rgba(99,102,241,0.1)', 'rgba(16,185,129,0.1)', 'rgba(245,158,11,0.1)', 'rgba(239,68,68,0.1)'][$loop->index % 4] }};">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <div class="activity-content">
                                <p><strong>{{ $aktivitas->member->nama }}</strong> meminjam
                                    <em>{{ Str::limit($aktivitas->buku->judul, 30) }}</em></p>
                                <span class="activity-time">{{ $aktivitas->created_at->diffForHumans() }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="activity-item">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada aktivitas terbaru.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- Card untuk Donut Chart Komposisi Buku --}}
            <div class="content-card grid-col-span-full">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-chart-pie"></i>
                        Komposisi Kategori Buku
                    </h4>
                </div>
                <div class="donut-chart-container">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    {{-- Memuat library Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animasi Angka pada Kartu Statistik yang Lebih Smooth
            document.querySelectorAll('.stat-card-number').forEach((counter, index) => {
                const target = +counter.innerText;
                if (isNaN(target)) return;

                counter.innerText = '0';
                const duration = 2000; // 2 detik
                const startTime = performance.now();

                const updateCount = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Easing function untuk animasi yang lebih smooth
                    const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                    const current = Math.floor(easeOutQuart * target);

                    counter.innerText = current.toLocaleString();

                    if (progress < 1) {
                        requestAnimationFrame(updateCount);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };

                // Delay berdasarkan index untuk efek berurutan
                setTimeout(() => {
                    requestAnimationFrame(updateCount);
                }, index * 200);
            });

            // Inisialisasi Grafik Peminjaman dengan Styling yang Lebih Baik
            const grafikPeminjamanCtx = document.getElementById('grafikPeminjaman');
            if (grafikPeminjamanCtx) {
                const gradient = grafikPeminjamanCtx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
                gradient.addColorStop(1, 'rgba(99, 102, 241, 0.1)');

                new Chart(grafikPeminjamanCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: @json($grafikData ?? []),
                            backgroundColor: gradient,
                            borderColor: '#6366f1',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                titleColor: '#f9fafb',
                                bodyColor: '#f9fafb',
                                borderColor: '#6366f1',
                                borderWidth: 1,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        weight: '500'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        weight: '500'
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            // Inisialisasi Donut Chart dengan Styling yang Lebih Baik
            const kategoriChartCtx = document.getElementById('kategoriChart');
            if (kategoriChartCtx) {
                new Chart(kategoriChartCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($labelsKategori ?? []),
                        datasets: [{
                            data: @json($dataKategori ?? []),
                            backgroundColor: [
                                '#6366f1',
                                '#10b981',
                                '#f59e0b',
                                '#ef4444',
                                '#8b5cf6',
                                '#06b6d4',
                                '#f97316'
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverOffset: 15,
                            hoverBorderWidth: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 14,
                                        weight: '600'
                                    },
                                    color: '#374151'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                titleColor: '#f9fafb',
                                bodyColor: '#f9fafb',
                                borderColor: '#6366f1',
                                borderWidth: 1,
                                cornerRadius: 8,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((context.parsed / total) * 100);
                                        return `${context.label}: ${context.parsed} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 2000,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            // Efek hover pada kartu statistik
            document.querySelectorAll('.stat-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
@endpush
