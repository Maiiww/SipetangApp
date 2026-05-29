<?php
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
                    (object) ['title' => 'Notifikasi', 'route_name' => 'staff.notifikasi', 'icon' => 'fa-bell'],
                ])->filter(function ($menu) {
                    return $menu->title !== 'Profil';
                });
            }
        }
    }
?>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-box"
            style="width: 62px; height: 62px; min-width: 62px; min-height: 62px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #ffffff; box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);">
            <img src="<?php echo e(asset('images/sipetang.jpg.png')); ?>" alt="Logo SIPETANG" class="sidebar-logo-image"
                style="width: 84%; height: 84%; object-fit: contain;" />
        </div>
        <div class="sidebar-logo-text">
            <h3>SIPETANG</h3>
            <p>Sistem Informasi Pencatatan Hasil Tangkap</p>
        </div>
    </div>
    <ul class="sidebar-menu">
        <?php $__currentLoopData = $sidebarMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route($menu->route_name)); ?>"
                    class="<?php echo e(request()->routeIs($menu->route_name) ? 'active' : ''); ?>"
                    style="position: relative; display: flex; align-items: center;">
                    <?php if($menu->icon): ?>
                        <i class="fas <?php echo e($menu->icon); ?>"></i>
                    <?php endif; ?>
                    <span><?php echo e($menu->title); ?></span>
                    <?php if($menu->route_name === 'staff.validasi' && $pendingNotificationCount > 0): ?>
                        <span style="margin-left: auto; background: #dc3545; color: #fff; font-size: 0.75rem; min-width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 0 6px; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"><?php echo e($pendingNotificationCount); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <div class="sidebar-logout">
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="sidebar-logout-button">
                <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
<?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/components/sidebar-menu.blade.php ENDPATH**/ ?>