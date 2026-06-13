@php
    use Illuminate\Support\Facades\Schema;
    use App\Models\Menu;
    use App\Models\Laporan;

    $sidebarMenus = collect();
    $pendingNotificationCount = 0;
    if (auth()->check()) {
        if (Schema::hasTable('menus')) {
            $sidebarMenus = Menu::active()
                ->forRole(auth()->user()->role)
                ->orderBy('sort_order')
                ->get()
                ->filter(function ($menu) {
                    $role = strtolower(auth()->user()->role);
                    // Exclude 'Profil' for all roles
                    if ($menu->title === 'Profil') {
                        return false;
                    }
                    // Exclude 'Notifikasi' for all roles
                    if ($menu->title === 'Notifikasi') {
                        return false;
                    }
                    // Exclude 'Beranda'/'Dashboard' for admin role
                    if ($role === 'admin' && in_array($menu->title, ['Beranda', 'Dashboard', 'Dashboard Admin'])) {
                        return false;
                    }
                    return true;
                });
        }

        if (Schema::hasTable('laporans')) {
            $pendingNotificationCount = Laporan::where('status', 'pending')->count();
        }

        if ($sidebarMenus->isEmpty()) {
            $role = strtolower(auth()->user()->role);

            if ($role === 'admin') {
                $sidebarMenus = collect([
                    (object) [
                        'title' => 'Manajemen User',
                        'route_name' => 'admin.manajemen.user',
                        'icon' => 'fa-users',
                    ],
                ]);
            } elseif (in_array($role, ['staff', 'jururekap'])) {
                $sidebarMenus = collect([
                    (object) ['title' => 'Beranda', 'route_name' => 'staff.dashboard', 'icon' => 'fa-house'],
                    (object) [
                        'title' => 'Validasi Laporan',
                        'route_name' => 'staff.validasi',
                        'icon' => 'fa-check-circle',
                    ],
                    (object) ['title' => 'Cetak Laporan', 'route_name' => 'staff.cetak', 'icon' => 'fa-print'],
                    (object) ['title' => 'Data Statistik', 'route_name' => 'staff.statistik', 'icon' => 'fa-chart-bar'],
                ])->filter(function ($menu) {
                    return $menu->title !== 'Profil';
                });
            }
        }
    }
@endphp

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-box"
            style="width: 62px; height: 62px; min-width: 62px; min-height: 62px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #ffffff; box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);">
            <img src="{{ asset('images/sipetang.jpg.png') }}" alt="Logo SIPETANG" class="sidebar-logo-image"
                style="width: 84%; height: 84%; object-fit: contain;" />
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
                    @if ($menu->route_name === 'staff.validasi' && $pendingNotificationCount > 0)
                        <span
                            style="margin-left: auto; background: #dc3545; color: #fff; font-size: 0.75rem; min-width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 0 6px; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">{{ $pendingNotificationCount }}</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    <div class="sidebar-logout">
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="button" class="sidebar-logout-button" onclick="confirmLogout(event)">
                <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

<script>
    // Load SweetAlert2 dynamically if not already loaded
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
            // Give dynamic script a brief moment to initialize
            setTimeout(performLogout, 150);
        } else {
            performLogout();
        }
    }
</script>

<style>
    .sidebar-menu a {
        font-size: 17px !important;
    }
    .sidebar-menu i {
        font-size: 20px !important;
    }
    .sidebar-logo-box {
        width: 72px !important;
        height: 72px !important;
        min-width: 72px !important;
        min-height: 72px !important;
    }
    .sidebar-logo-image {
        width: 86% !important;
        height: 86% !important;
    }
    .sidebar-logo-text h3 {
        font-size: 24px !important;
    }
    .sidebar-logo-text p {
        font-size: 14px !important;
        line-height: 1.4 !important;
    }
    .sidebar-logout-button {
        font-size: 15.5px !important;
    }
</style>

