@echo off
setlocal enabledelayedexpansion

cd /d c:\laragon\www\SipetangApp\web-laravel

REM Jalankan seeder
echo Menjalankan TpiSeeder...
php artisan db:seed --class=TpiSeeder --no-ansi

echo.
echo Seeder selesai!
echo.
echo Untuk verifikasi, silakan buka browser di:
echo http://localhost/SipetangApp/web-laravel/public/staff/cetak-laporan
echo.
pause
