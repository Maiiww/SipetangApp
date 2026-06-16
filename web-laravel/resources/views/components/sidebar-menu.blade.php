@php
    use Illuminate\Support\Facades\Schema;
    use App\Models\Menu;
    use App\Models\Laporan;

    $sidebarMenus = collect();
    $pendingNotificationCount = 0;
    if (auth()->check()) {
        $role = strtolower(auth()->user()->role);

        if ($role === 'jururekap') {
            $pendingNotificationCount = \App\Models\Tangkapan::where('user_id', auth()->id())
                ->where('status', 'Ditolak')
                ->count();

            $sidebarMenus = collect([
                (object) ['title' => 'Beranda',          'route_name' => 'jururekap.dashboard', 'icon' => 'fa-home'],
                (object) ['title' => 'Kelola Data',      'route_name' => 'jururekap.kelola',    'icon' => 'fa-tasks'],
                (object) ['title' => 'Riwayat & Revisi', 'route_name' => 'jururekap.riwayat',   'icon' => 'fa-history'],
                (object) ['title' => 'Profil Saya',      'route_name' => 'jururekap.profile',   'icon' => 'fa-user'],
            ]);
        } else {
            if (Schema::hasTable('menus')) {
                $sidebarMenus = Menu::active()
                    ->forRole(auth()->user()->role)
                    ->orderBy('sort_order')
                    ->get()
                    ->filter(function ($menu) use ($role) {
                        if ($menu->title === 'Profil') return false;
                        if ($menu->title === 'Notifikasi') return false;
                        if ($role === 'admin' && in_array($menu->title, ['Beranda', 'Dashboard', 'Dashboard Admin'])) return false;
                        return true;
                    });
            }

            if (Schema::hasTable('laporans') && $role === 'staff') {
                $pendingNotificationCount = Laporan::where('status', 'pending')->count();
            }

            if ($sidebarMenus->isEmpty()) {
                if ($role === 'admin') {
                    $sidebarMenus = collect([
                        (object) [
                            'title'      => 'Manajemen User',
                            'route_name' => 'admin.manajemen.user',
                            'icon'       => 'fa-users',
                        ],
                    ]);
                } elseif ($role === 'staff') {
                    $sidebarMenus = collect([
                        (object) ['title' => 'Dashboard',        'route_name' => 'staff.dashboard', 'icon' => 'fa-border-all'],
                        (object) ['title' => 'Validasi Laporan', 'route_name' => 'staff.validasi',  'icon' => 'fa-check-circle'],
                        (object) ['title' => 'Cetak Laporan',    'route_name' => 'staff.cetak',     'icon' => 'fa-print'],
                        (object) ['title' => 'Data Statistik',   'route_name' => 'staff.statistik', 'icon' => 'fa-chart-bar'],
                    ])->filter(function ($menu) {
                        return $menu->title !== 'Profil';
                    });
                }
            }
        }
    }
@endphp

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-box"
            style="width: 62px; height: 62px; min-width: 62px; min-height: 62px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #ffffff; box-shadow: 0 12px 20px rgba(0,0,0,0.12);">
            <img src="{{ asset('images/sipetang.jpg.png') }}" alt="Logo SIPETANG" class="sidebar-logo-image"
                style="width: 86%; height: 86%; object-fit: contain;" />
        </div>
        <div class="sidebar-logo-text">
            <h3>SIPETANG</h3>
            <p>Sistem Informasi Pencatatan Hasil Tangkap</p>
        </div>
    </div>

    <ul class="sidebar-menu">
        @foreach ($sidebarMenus as $menu)
            <li>
                <a href="{{ route($menu->route_name) }}"
                    class="{{ request()->routeIs($menu->route_name) ? 'active' : '' }}"
                    style="position: relative; display: flex; align-items: center;">
                    @if ($menu->icon)
                        <i class="fas {{ $menu->icon }}"></i>
                    @endif
                    <span>{{ $menu->title }}</span>
                    @if (($menu->route_name === 'staff.validasi' || $menu->route_name === 'jururekap.riwayat') && $pendingNotificationCount > 0)
                        <span
                            style="margin-left: auto; background: #dc3545; color: #fff; font-size: 0.72rem; min-width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 0 5px; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-weight: 700;">{{ $pendingNotificationCount }}</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    <div class="sidebar-logout">
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="button" class="sidebar-logout-button" onclick="confirmLogout(event)">
                <i class="fas fa-arrow-right-from-bracket"></i> <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

<script>
    if (typeof Swal === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        document.head.appendChild(script);
    }

    function confirmLogout(event) {
        event.preventDefault();

        const performLogout = () => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin keluar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#0a3b99',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar?')) {
                    document.getElementById('logout-form').submit();
                }
            }
        };

        if (typeof Swal === 'undefined') {
            setTimeout(performLogout, 150);
        } else {
            performLogout();
        }
    }
</script>

<style>
    .sidebar {
        width: 260px !important;
        background: linear-gradient(180deg, #0a3b99 0%, #1d65d0 100%) !important;
        color: white !important;
        padding: 34px 26px !important;
        display: flex !important;
        flex-direction: column !important;
        position: fixed !important;
        height: 100vh !important;
        box-shadow: 4px 0 36px rgba(0, 0, 0, 0.18) !important;
        overflow-y: auto !important;
        z-index: 20 !important;
        top: 0 !important;
        left: 0 !important;
    }

    .sidebar-logo {
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
        margin-bottom: 38px !important;
        font-weight: 700 !important;
    }

    .sidebar-logo-box {
        background: white !important;
        width: 62px !important;
        height: 62px !important;
        min-width: 62px !important;
        min-height: 62px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12) !important;
    }

    .sidebar-logo-image {
        width: 86% !important;
        height: 86% !important;
        object-fit: contain !important;
    }

    .sidebar-logo-text h3 {
        font-size: 18px !important;
        margin: 0 !important;
        letter-spacing: 0.5px !important;
        font-weight: 700 !important;
        color: white !important;
    }

    .sidebar-logo-text p {
        font-size: 11px !important;
        opacity: 0.82 !important;
        margin: 4px 0 0 !important;
        line-height: 1.35 !important;
        color: white !important;
    }

    .sidebar-menu {
        flex: 1 !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .sidebar-menu li {
        margin-bottom: 12px !important;
    }

    .sidebar-menu a {
        color: rgba(255, 255, 255, 0.9) !important;
        text-decoration: none !important;
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
        padding: 14px 18px !important;
        border-radius: 18px !important;
        transition: background 0.25s ease, transform 0.15s ease, color 0.25s ease !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        letter-spacing: normal !important;
    }

    .sidebar-menu a:hover {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
    }

    .sidebar-menu a.active {
        background: #ffffff !important;
        color: #0a3b99 !important;
        box-shadow: 0 14px 30px rgba(9, 45, 112, 0.14) !important;
    }

    .sidebar-menu a.active i {
        color: #0a3b99 !important;
    }

    .sidebar-menu a:active {
        transform: scale(0.98) !important;
    }

    .sidebar-menu i {
        width: 20px !important;
        text-align: center !important;
        font-size: 18px !important;
    }

    .sidebar-logout {
        margin-top: auto !important;
        padding-top: 24px !important;
        border-top: 1px solid rgba(255, 255, 255, 0.18) !important;
    }

    .sidebar-logout-button {
        color: #ffffff !important;
        background: #1a4d7d !important;
        border-radius: 25px !important;
        padding: 12px 20px !important;
        width: 100% !important;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
    }

    .sidebar-logout-button:hover {
        background: #0f3a5f !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
    }

    .sidebar-logout-button i {
        font-size: 16px !important;
    }
</style>
