<nav class="navbar navbar-expand-lg sticky-top py-3" style="background-color: var(--sipetang-navy); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    <div class="container">
        <!-- Logo Bulat dan Teks SIPETANG -->
        <a class="navbar-brand d-flex align-items-center gap-3 text-white" href="#">
            <img src="<?php echo e(asset('assets/../../images/logo.png')); ?>" alt="Logo Dinas" width="45" height="45" class="rounded-circle border border-2 border-white shadow-sm" style="object-fit: cover; background-color: white;">
            <span style="font-weight: 800; font-size: 1.75rem; letter-spacing: 0.5px;">SIPETANG</span>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars text-white fs-4"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-2 gap-lg-4">
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 hover-opacity-100 fs-5 fw-medium" href="#beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 hover-opacity-100 fs-5 fw-medium" href="#tentang">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 hover-opacity-100 fs-5 fw-medium" href="#layanan">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 hover-opacity-100 fs-5 fw-medium" href="#faq">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 hover-opacity-100 fs-5 fw-medium" href="#kontak">Kontak</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .hover-opacity-100:hover { opacity: 1 !important; color: var(--sipetang-orange) !important; transition: all 0.3s ease; }
</style><?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/layouts/header.blade.php ENDPATH**/ ?>