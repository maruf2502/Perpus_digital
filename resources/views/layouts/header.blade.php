@php
$user = Auth::guard('member')->user();
@endphp

<style>
    :root {
        --primary-blue: #0d6efd;
        --dark-blue: #0a58ca;
        --light-blue: #e7f1ff;
        --text-white: #ffffff;
        --text-dark: #343a40;
        --text-muted: #6c757d;
        --bg-white: #ffffff;
        --border-color: #e9ecef;
        --shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        --header-height: 100px;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        padding-top: var(--header-height);
    }

    .main-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: var(--shadow);
    }

    .navbar-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
    }

    .navbar-top {
        background-color: var(--primary-blue);
        height: 100px;
        color: var(--text-white);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--text-white);
    }

    .navbar-brand img {
        width: 180px;
        height: auto;
        object-fit: contain;
    }

    .user-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        background-color: var(--dark-blue);
        padding: 6px 12px;
        border-radius: 50px;
    }

    .user-avatar {
        background-color: var(--text-white);
        color: var(--primary-blue);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .user-role {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .logout-button {
        background-color: var(--light-blue);
        color: var(--dark-blue);
        border: none;
        padding: 10px 18px;
        border-radius: 50px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .logout-button:hover {
        background-color: #dbeaff;
    }

    .navbar-bottom {
        background-color: var(--bg-white);
        height: 50px;
        border-bottom: 1px solid var(--border-color);
    }

    .navbar-bottom .navbar-container {
        justify-content: center;
    }

    .navbar-menu {
        display: flex;
        gap: 0.5rem;
        height: 100%;
    }

    .nav-link {
        color: var(--text-muted);
        text-decoration: none;
        padding: 0 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease-in-out;
    }

    .nav-link:hover {
        color: var(--primary-blue);
    }

    .nav-link.active {
        color: var(--primary-blue);
        font-weight: 600;
        border-bottom-color: var(--primary-blue);
    }

    .mobile-toggle {
        display: none;
    }

    @media (max-width: 992px) {
        .user-role, .logout-button span {
            display: none;
        }

        .logout-button {
            width: 40px;
            height: 40px;
            justify-content: center;
            padding: 0;
        }
    }

    @media (max-width: 768px) {
        body {
            padding-top: 70px;
        }

        .navbar-bottom {
            position: absolute;
            top: 70px;
            width: 100%;
            background-color: var(--bg-white);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-toggle {
            display: block;
            background: none;
            border: none;
            color: var(--text-dark);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .navbar-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: var(--bg-white);
            flex-direction: column;
            align-items: stretch;
            padding: 0.5rem 0;
            border-top: 1px solid var(--border-color);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out;
        }

        .navbar-menu.active {
            max-height: 500px;
        }

        .nav-link {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-link.active {
            border-bottom-color: var(--border-color);
            background-color: var(--light-blue);
        }
    }
</style>

<header class="main-header" id="mainNavbar">
    <div class="navbar-top">
        <div class="navbar-container">
            <a href="{{ $user && $user->hasRole('admin') ? route('admin.dashboard') : route('member.dashboard') }}" class="navbar-brand">
                <img src="{{ asset('template/images/Perpustakaan_Logo.png') }}" alt="Logo">
            </a>

            @if ($user)
                <div class="user-section">
                    <div class="user-profile">
                        <div class="user-avatar">{{ strtoupper(substr($user->nama ?? 'GU', 0, 2)) }}</div>
                        <span class="user-role">{{ $user->getRoleNames()->first() ?? 'Guest' }}</span>
                    </div>
                    <a href="#" class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            @endif
        </div>
    </div>

    <nav class="navbar-bottom">
        <div class="navbar-container">
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-menu" id="navMenu">
                @if ($user && $user->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Beranda</a>
                    <a href="{{ route('admin.bukus.index') }}" class="nav-link {{ Request::routeIs('admin.bukus.*') ? 'active' : '' }}"><i class="fas fa-book"></i> Manajemen Buku</a>
                    <a href="{{ route('admin.members.index') }}" class="nav-link {{ Request::routeIs('admin.members.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Manajemen Anggota</a>
                    <a href="{{ route('admin.daftar.peminjam') }}" class="nav-link {{ Request::routeIs('admin.daftar.peminjam') ? 'active' : '' }}"><i class="fas fa-list"></i> Daftar Peminjaman</a>
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ Request::routeIs('admin.laporan.index') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Laporan</a>
                    <a href="{{ route('admin.laporan.denda') }}" class="nav-link {{ Request::routeIs('admin.laporan.denda') ? 'active' : '' }}"><i class="fas fa-dollar-sign"></i> Daftar Denda</a>
                @elseif ($user && $user->hasRole('member'))
                    <a href="{{ route('member.dashboard') }}" class="nav-link {{ Request::routeIs('member.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Beranda</a>
                    <a href="{{ route('peminjamanbuku.index') }}" class="nav-link {{ Request::routeIs('peminjamanbuku.*') ? 'active' : '' }}"><i class="fas fa-book-reader"></i> Peminjaman Buku</a>
                    <a href="{{ route('pengembalianbuku.index') }}" class="nav-link {{ Request::routeIs('pengembalianbuku.*') ? 'active' : '' }}"><i class="fas fa-undo-alt"></i> Pengembalian Buku</a>
                    <a href="{{ route('riwayat.peminjaman') }}" class="nav-link {{ Request::routeIs('riwayat.peminjaman') ? 'active' : '' }}"><i class="fas fa-history"></i> Riwayat</a>
                @endif
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.getElementById('mainNavbar');
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');

        mobileToggle.addEventListener('click', function () {
            navMenu.classList.toggle('active');
            const icon = mobileToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        document.addEventListener('click', function (event) {
            if (!navbar.contains(event.target)) {
                navMenu.classList.remove('active');
                const icon = mobileToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                navMenu.classList.remove('active');
                const icon = mobileToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            });
        });
    });
</script>
