@php
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;

$sidebarMenus = collect();
if (auth()->check()) {
    if (Schema::hasTable('menus')) {
        $sidebarMenus = Menu::active()
            ->forRole(auth()->user()->role)
            ->orderBy('sort_order')
            ->get();
    }

    if ($sidebarMenus->isEmpty()) {
        $role = strtolower(auth()->user()->role);

        if ($role === 'admin') {
            $sidebarMenus = collect([
                (object) ['title' => 'Beranda', 'route_name' => 'admin.dashboard', 'icon' => 'fa-house'],
                (object) ['title' => 'Manajemen User', 'route_name' => 'admin.manajemen.user', 'icon' => 'fa-users'],
            ]);
        } elseif (in_array($role, ['staff', 'jururekap'])) {
            $sidebarMenus = collect([
                (object) ['title' => 'Beranda', 'route_name' => 'staff.dashboard', 'icon' => 'fa-house'],
                (object) ['title' => 'Validasi Laporan', 'route_name' => 'staff.validasi', 'icon' => 'fa-check-circle'],
                (object) ['title' => 'Cetak Laporan', 'route_name' => 'staff.cetak', 'icon' => 'fa-print'],
                (object) ['title' => 'Data Statistik', 'route_name' => 'staff.statistik', 'icon' => 'fa-chart-bar'],
                (object) ['title' => 'Notifikasi', 'route_name' => 'staff.notifikasi', 'icon' => 'fa-bell'],
            ]);
        }
    }
}
@endphp

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-box" style="width: 62px; height: 62px; min-width: 62px; min-height: 62px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #ffffff; box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);">
            <img src="{{ asset('images/sipetang.jpg.png') }}" alt="Logo SIPETANG" class="sidebar-logo-image" style="width: 84%; height: 84%; object-fit: contain;" />
        </div>
        <div class="sidebar-logo-text">
            <h3>SIPETANG</h3>
            <p>Sistem Informasi Pencatatan Hasil Tangkap</p>
        </div>
    </div>
    <ul class="sidebar-menu">
        @foreach($sidebarMenus as $menu)
            <li>
                <a href="{{ route($menu->route_name) }}" class="{{ request()->routeIs($menu->route_name) ? 'active' : '' }}">
                    @if($menu->icon)
                        <i class="fas {{ $menu->icon }}"></i>
                    @endif
                    <span>{{ $menu->title }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="sidebar-logout">
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="sidebar-logout-button">
                <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
