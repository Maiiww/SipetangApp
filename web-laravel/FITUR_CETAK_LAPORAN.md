# Fitur Cetak Laporan - SIPETANG

## 📋 Deskripsi Umum

Fitur **Cetak Laporan** adalah modul untuk mencetak dan mengunduh laporan hasil tangkap yang sudah tervalidasi. Data laporan diambil dari modul **Validasi Laporan** setelah staff melakukan validasi terhadap data hasil tangkap nelayan.

---

## 🔄 Alur Data Lengkap

```
┌─────────────────────┐
│  Juru Rekap Input   │
│  Hasil Tangkap      │
│   (Status: Draft)   │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────────────────────┐
│  Validasi Laporan                   │
│  (Staff Validasi)                   │
│  - Tampilkan Draft                  │
│  - Validasi → Status: "Divalidasi"  │
│  - Tolak → Status: "Revisi"         │
└──────────┬──────────────────────────┘
           │
           ▼
┌─────────────────────────────────────┐
│  Cetak Laporan                      │
│  (Staff Administrasi)               │
│  - Tampilkan "Divalidasi" saja      │
│  - Filter & Search                  │
│  - Download PDF/Excel               │
└─────────────────────────────────────┘
```

---

## 📂 Struktur File & Code

### 1. **Controller: CetakLaporanController**
**Lokasi:** `app/Http/Controllers/Staff/CetakLaporanController.php`

#### Methods:
- **index(Request $request)** - Tampilkan halaman cetak laporan
  - Query hanya records dengan status "Divalidasi"
  - Support filter: search, date range
  - Return: Pagination + stats
  
- **preview(Request $request)** - Preview single laporan (AJAX)
  - Validasi: laporan_id
  - Return: JSON response dengan data laporan

- **download(Request $request)** - Download laporan
  - Validasi: format (pdf/excel), laporan_id (optional)
  - Single atau multiple download
  - Generate file PDF/Excel

#### Helper Methods:
- **generatePDF($laporan)** - Generate PDF file
  - Format: Landscape A4
  - Menggunakan Barryvdh\DomPDF
  
- **generateExcel($laporan)** - Generate Excel file
  - Format: XLSX
  - Menggunakan PhpOffice\PhpSpreadsheet
  
- **generateHTML($laporan)** - Generate HTML template
  - Untuk PDF preview dan PDF generation
  - Format table dengan styling

- **formatNumber($number)** - Format angka ke format Rupiah

---

### 2. **Model: Tangkapan**
**Lokasi:** `app/Models/Tangkapan.php`

#### Fields:
```php
- id                 // Primary key
- user_id            // Foreign key ke User
- nama_pembeli       // Nama pembeli ikan
- nama_nelayan       // Nama nelayan
- jenis_ikan         // Jenis ikan yang ditangkap
- berat              // Berat hasil tangkap (kg)
- harga_jual         // Harga penjualan (Rp)
- status             // Status: Draft, Menunggu Validasi, Divalidasi, Ditolak, Revisi
- catatan            // Catatan/keterangan
- rejected_by        // ID staff yang menolak
- rejected_at        // Timestamp penolakan
- revision_needed    // Flag untuk revisi diperlukan
- created_at         // Timestamp input data
- updated_at         // Timestamp update terakhir
```

#### Relationships:
```php
public function user()           // Get user yang input data
public function rejectedBy()     // Get staff yang menolak
public function notifications() // Get notifikasi untuk data ini
```

---

### 3. **Routes**
**Lokasi:** `routes/web.php`

```php
// Cetak Laporan Routes
Route::get('/cetak-laporan', [CetakLaporanController::class, 'index'])
    ->name('staff.cetak');

Route::post('/cetak-laporan/preview', [CetakLaporanController::class, 'preview'])
    ->name('staff.cetak.preview');

Route::post('/cetak-laporan/download', [CetakLaporanController::class, 'download'])
    ->name('staff.cetak.download');
```

---

### 4. **Blade Template**
**Lokasi:** `resources/views/Staff/cetak-laporan.blade.php`

#### Components:
- **Header** - Navigation header dengan user icons
- **Page Title** - Judul halaman "Cetak Laporan"
- **Stats Grid** - 3 kartu statistik:
  - Total Laporan Tervalidasi
  - Total Berat (kg)
  - Rata-rata Berat
  
- **Filter Section** - Form untuk:
  - Search (nama nelayan, pembeli, jenis ikan)
  - Date range (dari - sampai)
  - Submit button
  
- **Data Table** - Tabel hasil tangkap dengan kolom:
  - ID
  - Nama Nelayan
  - Nama Pembeli
  - Jenis Ikan
  - Berat (kg)
  - Harga Jual
  - Tanggal
  - Action (Download button)
  
- **Pagination** - Navigasi halaman

- **Empty State** - Pesan ketika tidak ada data

#### JavaScript Functions:
```javascript
// Download single atau all data
function downloadLaporan(format, laporanId = null)

// Quick download all filtered data
function downloadAllData(format = 'pdf')

// Event listener untuk tombol download di table
document.querySelectorAll('.btn-download').forEach(btn => ...)
```

---

## 📊 Status Values

| Status | Deskripsi | Tampil di Cetak? |
|--------|-----------|-----------------|
| Draft | Data baru, belum validasi | ❌ Tidak |
| Menunggu Validasi | Menunggu divalidasi staff | ❌ Tidak |
| **Divalidasi** | ✅ Sudah divalidasi | ✅ **YA** |
| Ditolak | Data ditolak saat validasi | ❌ Tidak |
| Revisi | Perlu revisi dari user | ❌ Tidak |

---

## 📥 Download Formats

### 1. **PDF**
- Format: Portrait/Landscape A4
- Library: `Barryvdh\DomPDF\Facade\Pdf`
- Isi: Header + Data Table + Summary
- Filename: `Laporan_YmdHis.pdf`

### 2. **Excel (XLSX)**
- Format: Modern Excel
- Library: `PhpOffice\PhpSpreadsheet`
- Isi: Header + Data Table + Auto-fit columns
- Filename: `Laporan_YmdHis.xlsx`

---

## 🔐 Database Schema (hasil_tangkap)

```sql
CREATE TABLE hasil_tangkap (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    nama_pembeli VARCHAR(255) NOT NULL,
    nama_nelayan VARCHAR(255) NOT NULL,
    jenis_ikan VARCHAR(255) NOT NULL,
    berat DOUBLE NOT NULL,
    harga_jual BIGINT NOT NULL,
    status VARCHAR(255) DEFAULT 'Draft',
    catatan TEXT NULL,
    rejected_by BIGINT UNSIGNED NULL,
    rejected_at TIMESTAMP NULL,
    revision_needed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (rejected_by) REFERENCES users(id) ON DELETE SET NULL
);
```

---

## 🎯 Fitur-Fitur

### ✅ Sudah Diimplementasikan:

1. **Tampilkan Data Validasi**
   - Query hanya status "Divalidasi"
   - Pagination 10 item per halaman
   - Real-time stats counter

2. **Filter & Search**
   - Search: nama nelayan, pembeli, jenis ikan, ID
   - Date range: dari tanggal - sampai tanggal
   - Reset filter dengan reload halaman

3. **Download Laporan**
   - Single download: Click tombol di table
   - Batch download: Select multiple records
   - Format PDF (landscape A4)
   - Format Excel (XLSX dengan auto-fit)

4. **Data Validation**
   - Server-side validation di controller
   - CSRF token protection
   - Input sanitization

5. **Performance**
   - Pagination untuk mengurangi load
   - Database query optimization
   - Lazy loading data

---

## 🚀 Cara Menggunakan

### 1. **Staff Validasi - Input & Validasi**
```
1. Go to: /staff/validasi-laporan
2. Lihat list data yang "Menunggu Validasi"
3. Click tombol "Validasi" untuk approve
4. Data status berubah → "Divalidasi"
```

### 2. **Staff Administrasi - Cetak Laporan**
```
1. Go to: /staff/cetak-laporan
2. (Optional) Filter data dengan:
   - Search: nama nelayan/pembeli
   - Date range: dari - sampai
3. Click "Cari" untuk apply filter
4. Lihat data yang sudah tervalidasi di table
5. Click "Download" button → Pilih format PDF/Excel
6. File akan di-download ke komputer
```

### 3. **Download All Data**
- Click button "Download Semua" (jika ada)
- Pilih format: PDF atau Excel
- Semua data filtered akan di-download

---

## 🔧 Troubleshooting

### ❌ Data Tidak Muncul di Cetak Laporan?
**Solusi:**
- Pastikan data sudah divalidasi di validasi-laporan
- Check status di database = "Divalidasi"
- Refresh halaman browser

### ❌ Download File Gagal?
**Solusi:**
- Check CORS settings jika cross-domain
- Verify CSRF token ada di HTML head
- Check server permissions untuk write file

### ❌ Format PDF/Excel Tidak Benar?
**Solusi:**
- Update library: `composer update`
- Check PHP version compatibility
- Clear cache: `php artisan cache:clear`

---

## 📝 Testing

### Unit Test:
```bash
# Run feature test untuk CetakLaporanController
php artisan test tests/Feature/Staff/CetakLaporanControllerTest.php
```

### Manual Test:
1. Create test data with status "Divalidasi"
2. Go to cetak-laporan page
3. Test filter dengan berbagai kombinasi
4. Test download PDF & Excel
5. Verify file content dan format

---

## 📚 Related Files

- Model: `app/Models/Tangkapan.php`
- Model: `app/Models/User.php`
- Controller: `app/Http/Controllers/Staff/ValidasiController.php` (untuk validasi)
- Migration: `database/migrations/*hasil_tangkap*.php`
- Blade: `resources/views/Staff/validasi-laporan.blade.php` (validasi UI)

---

## 🎨 UI/UX Features

- **Responsive Design**: Mobile-friendly layout
- **Dark Mode Ready**: Can be extended with dark mode CSS
- **Loading States**: Skeleton loaders (can be added)
- **Error Messages**: User-friendly error notifications
- **Animations**: Smooth transitions on button clicks
- **Icons**: Font Awesome 6.0 integration

---

## 🔐 Security Notes

- ✅ CSRF Token validation di semua POST requests
- ✅ SQL injection protection (using Laravel ORM)
- ✅ Mass assignment protection (using fillable array)
- ✅ Authorization checks (middleware based)
- ✅ Input validation (server-side)

---

## 📈 Performance Notes

- Query optimization dengan selective columns
- Pagination untuk reduce memory load
- Download stream instead of loading all in memory
- Database indexing pada status field

---

## 🎯 Future Enhancements

- [ ] Email export (kirim laporan via email)
- [ ] Scheduling reports (auto-generate laporan harian)
- [ ] Custom report templates
- [ ] Data visualization (charts & graphs)
- [ ] Batch upload Excel untuk validasi
- [ ] Advanced filtering (TPI, species, weight range)
- [ ] Export to Word (.docx)
- [ ] Print preview before download

---

## 👥 User Roles

| Role | Access | Permissions |
|------|--------|-------------|
| Admin | ✅ Yes | Full access |
| Staff Validasi | ❌ No (Hanya validasi-laporan) | Validate only |
| Staff Admin | ✅ Yes | View & Download |
| Juru Rekap | ❌ No | Input only |

---

## 📞 Support

Untuk bantuan atau bug report:
1. Contact: IT Department
2. Email: support@sipetang.local
3. System: Create ticket in helpdesk

---

**Last Updated:** 2 Juni 2026  
**Version:** 1.0  
**Status:** ✅ Production Ready
