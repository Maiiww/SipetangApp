<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard') - Sipetang</title>

    <!-- Fonts and icons -->
    <style>
        /* ensure sidebar toggle icon remains visible top-left */
        #sidebarToggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: rgba(0, 0, 0, 0.35);
            border-radius: 50%;
            padding: 0.45rem;
            transition: background 0.2s ease;
        }

        #sidebarToggle:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        #sidebarToggle i {
            font-size: 1.2rem;
            color: #f8fafc;
        }

        /* sidebar theme */
        #sidenav-main {
            background: linear-gradient(180deg, #0d2640 0%, #1a4d7d 100%) !important;
            border: none;
            min-height: 100vh;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.1);
        }

        .sidenav-header .navbar-brand {
            gap: 0.75rem;
            align-items: center;
            display: flex;
        }

        .sidenav-header .navbar-brand-box {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #0d2640;
            font-size: 1rem;
            font-weight: 700;
        }

        .sidenav-header .font-weight-bold {
            color: #f8fafc;
            letter-spacing: 0.03em;
            font-size: 1rem;
        }

        .navbar-nav {
            padding: 0 0.75rem;
        }

        .navbar-nav .nav-item.mb-2 {
            margin-bottom: 0.85rem !important;
        }

        .navbar-nav .nav-item.mt-4 {
            margin-top: 2rem !important;
        }

        .navbar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.95rem 1rem;
            border-radius: 1rem;
            margin-bottom: 0.35rem;
            color: #e2e8f0;
            background: rgba(255, 255, 255, 0.08);
            transition: background 0.2s ease, transform 0.2s ease, color 0.2s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            transform: translateX(1px);
        }

        .navbar-nav .nav-link i {
            width: 25px;
            text-align: center;
            color: #cbd5e1;
            font-size: 1rem;
        }

        .navbar-nav .nav-link.active i,
        .navbar-nav .nav-link:hover i {
            color: #ffffff;
        }

        .sidebar-logout {
            margin-top: auto;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-logout a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.9rem 1rem;
            color: #cdd6e2;
            text-decoration: none;
            border-radius: 1rem;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar-logout a:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .navbar-nav .nav-link i {
            width: 25px;
            text-align: center;
            color: #60a5fa;
            font-size: 1rem;
        }

        .navbar-nav .nav-link.active i,
        .navbar-nav .nav-link:hover i {
            color: #ffffff;
        }

        #laporanToggle {
            padding: 0.9rem 1rem;
        }

        #laporanChevron {
            transition: transform 0.2s ease;
            color: #cbd5e1;
        }

        #laporanChevron.rotate {
            transform: rotate(180deg);
        }

        .submenu {
            background: rgba(71, 85, 105, 0.12);
            border-radius: 1rem;
            padding: 0.35rem 0.35rem 0.45rem 0.35rem;
            margin-top: 0.5rem;
            transition: all 0.25s ease;
        }

        .submenu .nav-link {
            padding: 0.85rem 0.9rem;
            padding-left: 2.4rem;
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 0.85rem;
            margin-bottom: 0.3rem;
            color: #e2e8f0;
        }

        .submenu .nav-link:hover,
        .submenu .nav-link.active {
            background: rgba(96, 165, 250, 0.22);
            color: #ffffff;
            transform: translateX(1px);
        }

        .submenu .nav-link-text {
            margin-left: 0;
        }

        .nav-link-text.text-xs {
            color: #94a3b8;
            letter-spacing: 0.08em;
            font-size: 0.72rem;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet" />

    <!-- Argon Dashboard CSS (local copy) -->
    <link href="{{ asset('css/argon-dashboard.css') }}" rel="stylesheet" />

    @stack('head')
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- sidebar styled like Argon template -->
    @php
        $hideNav = in_array(Route::currentRouteName(), ['login', 'register']);
    @endphp
    @unless ($hideNav)
        <!-- sidebar initially hidden, will toggle via button -->
        <aside
            class="sidenav d-none d-xl-block navbar navbar-vertical navbar-expand-xs navbar-dark border-0 border-radius-xl my-3 fixed-left bg-gradient-dark"
            id="sidenav-main">
            <div class="sidenav-header">
                <a class="navbar-brand m-0" href="#">
                    <div class="navbar-brand-box" style="background: white; border-radius: 18px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('images/sipetang-logo.svg') }}" alt="SIPETANG" style="max-width: 38px; max-height: 38px; object-fit: contain;" />
                    </div>
                    <div>
                        <span class="ms-1 font-weight-bold">SIPETANG</span>
                        <p style="margin: 0; font-size: 10px; opacity: .7;">Sistem Informasi Pencatatan Hasil Tangkap</p>
                    </div>
                </a>
            </div>
            <hr class="horizontal dark mt-0" />
            <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <!-- Main Navigation -->
                    <li class="nav-item mb-2">
                        <span class="nav-link-text text-white text-xs font-weight-bold text-uppercase ps-3 opacity-6">Menu
                            Utama</span>
                    </li>
                    <li class="nav-item">
                        <a class="{{ request()->routeIs('dashboard') ? 'nav-link active' : 'nav-link' }}"
                            href="{{ url('/dashboard') }}">
                            <i class="ni ni-tv-2 text-white"></i>
                            <span class="nav-link-text ms-1 text-white">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}"
                            id="laporanToggle" aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}">
                            <i class="ni ni-single-copy-04 text-white"></i>
                            <span class="nav-link-text ms-1 text-white">Laporan</span>
                            <i class="fa fa-chevron-down text-white ms-auto" id="laporanChevron"></i>
                        </a>
                        <ul class="navbar-nav mt-1 submenu {{ request()->is('laporan*') ? 'd-block' : 'd-none' }}"
                            id="laporanSubmenu">
                            <li class="nav-item">
                                <a href="{{ url('/laporan/mingguan') }}"
                                    class="nav-link text-white {{ request()->is('laporan/mingguan') ? 'active' : '' }}">
                                    <span class="nav-link-text">Laporan Mingguan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/laporan/bulanan') }}"
                                    class="nav-link text-white {{ request()->is('laporan/bulanan') ? 'active' : '' }}">
                                    <span class="nav-link-text">Laporan Bulanan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/laporan/tahunan') }}"
                                    class="nav-link text-white {{ request()->is('laporan/tahunan') ? 'active' : '' }}">
                                    <span class="nav-link-text">Laporan Tahunan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="{{ request()->routeIs('laporan.cetak') ? 'nav-link active' : 'nav-link' }}"
                            href="{{ url('/cetak-laporan') }}">
                            <i class="ni ni-bold-down text-white"></i>
                            <span class="nav-link-text ms-1 text-white">Cetak Laporan</span>
                        </a>
                    </li>

                    <!-- Account Section -->
                    <li class="nav-item mt-4 mb-2">
                        <span
                            class="nav-link-text text-white text-xs font-weight-bold text-uppercase ps-3 opacity-6">Akun</span>
                    </li>
                    @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('admin.dashboard') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="ni ni-tv-2 text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Dashboard Admin</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('admin.manajemen.user') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('admin.manajemen.user') }}">
                                <i class="ni ni-single-02 text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Manajemen User</span>
                            </a>
                        </li>
                    @elseif(auth()->check() && strtolower(auth()->user()->role) === 'staff')
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('dashboard') || request()->routeIs('staff.dashboard') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('dashboard') }}">
                                <i class="ni ni-tv-2 text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('staff.validasi') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('staff.validasi') }}">
                                <i class="ni ni-check-bold text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Validasi Laporan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('staff.cetak') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('staff.cetak') }}">
                                <i class="ni ni-bold-down text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Cetak Laporan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('staff.statistik') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('staff.statistik') }}">
                                <i class="ni ni-chart-bar-32 text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Data Statistik</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('staff.notifikasi') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('staff.notifikasi') }}">
                                <i class="ni ni-bell-55 text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Notifikasi</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="{{ request()->routeIs('profile') ? 'nav-link active' : 'nav-link' }}"
                                href="{{ route('profile') }}">
                                <i class="ni ni-single-02 text-white"></i>
                                <span class="nav-link-text ms-1 text-white">Profil Saya</span>
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="sidebar-logout">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>
    @endunless

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar (you can customize or copy from the template) -->
        @unless ($hideNav)
            <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
                navbar-scroll="true">
                <div class="container-fluid py-1 px-3">
                    <!-- page title (breadcrumb removed) -->
                    <button class="btn btn-sm btn-link text-white me-3" id="sidebarToggle"><i
                            class="fa fa-bars"></i></button>
                    <h6 class="font-weight-bolder mb-0">@yield('page-title', 'Dashboard')</h6>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ url('/logout') }}" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        @endunless

        <!-- page content -->
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    <!-- Core JS Files (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <!-- Argon Dashboard JS (CDN) -->
    <script src="https://demos.creative-tim.com/argon-dashboard/assets/js/argon-dashboard.min.js"></script>

    @stack('scripts')
    <script>
        // toggle sidebar visibility
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('sidenav-main');
            if (toggle && sidebar) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('d-none');
                });
            }
            // laporan submenu toggle
            var laporanToggle = document.getElementById('laporanToggle');
            var laporanSub = document.getElementById('laporanSubmenu');
            var laporanChevron = document.getElementById('laporanChevron');
            if (laporanToggle && laporanSub) {
                laporanToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    laporanSub.classList.toggle('d-none');
                    if (laporanChevron) laporanChevron.classList.toggle('rotate');
                });
            }
        });
    </script>
</body>

</html>
