# PANDUAN CEPAT - Cetak Laporan SIPETANG

## 📌 Quick Navigation

| Role | URL | Akses |
|------|-----|-------|
| Staff Validasi | `/staff/validasi-laporan` | Validasi data |
| Staff Admin | `/staff/cetak-laporan` | Cetak & download |
| Juru Rekap | `/dashboard` | Input data saja |

---

## 🎯 Workflow Cepat

### Untuk Staff Validasi:
1. Login → `/staff/validasi-laporan`
2. Lihat list "Menunggu Validasi"
3. Click "✓ Validasi" untuk approve
4. Status berubah → "Divalidasi"

### Untuk Staff Admin/Administrasi:
1. Login → `/staff/cetak-laporan`
2. (Optional) Filter: Search atau Date range
3. Click "Download" button
4. Pilih format: **PDF** atau **Excel**
5. File otomatis download

---

## 🔴 Status Data - Penting!

| Status | Tampil di Validasi? | Tampil di Cetak? | Keterangan |
|--------|:--:|:--:|-----------|
| Draft | ✅ | ❌ | Data baru, belum review |
| Menunggu Validasi | ✅ | ❌ | Menunggu staff validasi |
| **Divalidasi** | ✅ | ✅ | ✅ READY TO PRINT |
| Ditolak | ✅ | ❌ | Ditolak oleh staff |
| Revisi | ✅ | ❌ | User perlu perbaiki |

**KEY: Hanya status "Divalidasi" yang bisa dicetak!**

---

## 📊 Struktur Data Hasil Tangkap

```
hasil_tangkap (Database Table)
├─ id                  → ID unik
├─ user_id             → Who input the data
├─ nama_nelayan        → Nama penangkap ikan
├─ nama_pembeli        → Nama buyer
├─ jenis_ikan          → Jenis hasil tangkap
├─ berat               → Berat total (kg)
├─ harga_jual          → Harga jual (Rp)
├─ status              → Draft / Validasi / Ditolak / Revisi
└─ timestamps          → created_at, updated_at
```

---

## 💾 Database Commands (untuk DBA/Admin)

### Check data yang belum validated:
```sql
SELECT * FROM hasil_tangkap 
WHERE status IN ('Draft', 'Menunggu Validasi')
ORDER BY created_at DESC;
```

### Check semua data validated (ready to print):
```sql
SELECT * FROM hasil_tangkap 
WHERE status = 'Divalidasi'
ORDER BY created_at DESC;
```

### Check rejected data:
```sql
SELECT * FROM hasil_tangkap 
WHERE status IN ('Ditolak', 'Revisi')
ORDER BY created_at DESC;
```

### Count by status:
```sql
SELECT status, COUNT(*) as total 
FROM hasil_tangkap 
GROUP BY status;
```

---

## 🖥️ Controller Methods

**File:** `app/Http/Controllers/Staff/CetakLaporanController.php`

```php
// Tampilkan halaman cetak laporan
public function index(Request $request)
    → Filter: search, date range
    → Return: View dengan $laporans (paginated)

// Download laporan (PDF/Excel)
public function download(Request $request)
    → Input: format (pdf/excel), laporan_id (optional)
    → Return: File download stream

// Generate PDF
private function generatePDF($laporan)
    → Uses: Barryvdh\DomPDF
    → Format: A4 Landscape

// Generate Excel
private function generateExcel($laporan)
    → Uses: PhpOffice\PhpSpreadsheet
    → Format: XLSX dengan auto-fit columns

// Generate HTML
private function generateHTML($laporan)
    → Template untuk PDF content
```

---

## 📦 Dependencies

```json
{
  "barryvdh/laravel-dompdf": "^2.0",
  "phpoffice/phpspreadsheet": "^1.28"
}
```

**Install jika belum ada:**
```bash
composer require barryvdh/laravel-dompdf phpoffice/phpspreadsheet
```

---

## 🔍 Filter & Search Capability

### Search Fields:
- ID laporan
- Nama nelayan
- Nama pembeli
- Jenis ikan

### Filter Options:
- Date range (dari tanggal - sampai tanggal)
- Status (auto: hanya "Divalidasi")

### Pagination:
- 10 records per page
- Supports page navigation

---

## 🎨 UI Elements

### Stat Cards:
- Total Laporan Tervalidasi (count)
- Total Berat (sum)
- Rata-rata Berat (avg)

### Table Columns:
- ID
- Nama Nelayan
- Nama Pembeli
- Jenis Ikan
- Berat (kg)
- Harga Jual
- Tanggal
- Action (Download button)

### Download Button:
- Single: Download 1 record
- All: Download semua filtered records (jika ada button)

---

## 🚨 Common Issues & Solutions

| Issue | Cause | Solusi |
|-------|-------|--------|
| Data tidak muncul | Status bukan "Divalidasi" | Go to validasi page, validate data |
| Download gagal | CSRF token missing | Refresh page, try again |
| File corrupted | Server error | Check error logs, try different format |
| Pagination error | Query error | Clear cache, check filters |
| Slow download | Large dataset | Use date filter to narrow results |

---

## 🔐 Security Notes

✅ CSRF Token protection
✅ SQL injection prevention (using ORM)
✅ Role-based access control
✅ Input validation & sanitization
✅ Secure file download stream

---

## 📞 Contact & Support

- **Technical Issue?** → Contact IT/Developer
- **Data Issue?** → Contact Data Manager
- **Access Problem?** → Contact System Admin
- **Bug Report?** → Submit to Issue Tracker

---

## 📝 Important Notes

⚠️ **Only "Divalidasi" status can be printed**
- Draft records TIDAK tampil di cetak-laporan
- Rejected/Revised records TIDAK tampil di cetak-laporan
- Only approved (Divalidasi) records tampil

⚠️ **File Downloads**
- PDF format: Landscape A4
- Excel format: XLSX dengan auto-fit
- Filename: `Laporan_YYYYMMDDHHMMSS.{pdf|xlsx}`

⚠️ **Performance**
- Use date filters for large datasets
- Avoid downloading 1000+ records at once
- Pagination helps manage data display

---

## ✅ Verification Checklist

Before going live, verify:
- ☐ Database connection working
- ☐ Test data exists with "Divalidasi" status
- ☐ PDF download working
- ☐ Excel download working
- ☐ Filters working correctly
- ☐ Pagination working
- ☐ Error messages displaying properly
- ☐ CSRF tokens present
- ☐ File permissions correct (write to storage)
- ☐ All routes accessible

---

**Last Updated:** 2 Juni 2026  
**Version:** 1.0  
**Status:** Production Ready ✅
