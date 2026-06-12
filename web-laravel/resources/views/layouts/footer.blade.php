
<footer style="background-color: #082050; color: rgba(255,255,255,0.8); padding: 60px 0 30px;">
    <div class="container">
        <div class="row g-5 mb-5">
            <div class="col-lg-5">
                <!-- Logo SIPETANG Bulat (Konsisten dengan Header) -->
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('assets/../../images/logo.png') }}" alt="Logo SIPETANG" width="40" height="40" class="rounded-circle border border-2 border-white shadow-sm" style="object-fit: cover; background-color: white;">
                    <h4 class="text-white fw-bold mb-0">SIPETANG</h4>
                </div>
                
                <p class="small pe-lg-5 mb-4">Sistem Informasi Pencatatan Hasil Tangkap terintegrasi untuk mendukung modernisasi dan efisiensi birokrasi pada Dinas Perikanan Kabupaten Subang.</p>
                
                <div class="d-flex gap-3">
                    <a href="https://www.instagram.com/dinasperikanansubang" target="_blank" class="text-white opacity-75 fs-5 hover-opacity-100"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@dinasperikanankabupatensub2885" target="_blank" class="text-white opacity-75 fs-5 hover-opacity-100"><i class="fab fa-youtube"></i></a>
                    <a href="tel:(0260) 4113251" target="_blank" class="text-white opacity-75 fs-5 hover-opacity-100"><i class="fas fa-phone"></i></a>
                </div>
            </div>

            <div class="col-lg-3 offset-lg-1">
                <h5 class="text-white fw-bold mb-4">Navigasi Utama</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="#tentang" class="text-white text-decoration-none opacity-75 hover-opacity-100">Tentang Sistem</a>
                    <a href="#tpi" class="text-white text-decoration-none opacity-75 hover-opacity-100">Jaringan TPI</a>
                    <a href="#faq" class="text-white text-decoration-none opacity-75 hover-opacity-100">Pusat Bantuan</a>
                </div>
            </div>

            <div class="col-lg-3">
                <h5 class="text-white fw-bold mb-4">Akses Cepat</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ url('/login') }}" class="text-white text-decoration-none opacity-75 hover-opacity-100">Beranda Statistik</a>
                    <a href="{{ url('/login') }}" class="text-white text-decoration-none opacity-75 hover-opacity-100">Validasi Laporan</a>
                    <a href="{{ url('/login') }}" class="text-white text-decoration-none opacity-75 hover-opacity-100">Cetak Dokumen</a>
                </div>
            </div>
        </div>

        <div class="border-top pt-4 text-center small opacity-50" style="border-color: rgba(255,255,255,0.1) !important;">
            &copy; 2026 Dinas Perikanan Kabupaten Subang | Neutron Tech Solutions
        </div>
    </div>
</footer>

<style>
    .hover-opacity-100:hover { opacity: 1 !important; color: var(--sipetang-orange) !important; transition: all 0.3s ease; }
</style>