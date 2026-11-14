# SiPustaka (Laravel 11/12 + HMVC)

## 1. Persiapan project
```bash
composer create-project laravel/laravel sipustaka_hmvc
cd sipustaka_hmvc
```
Buat database `db_sipustaka` di phpMyAdmin, lalu di `.env`:
```
DB_CONNECTION=mysql
DB_DATABASE=db_sipustaka
DB_USERNAME=root
DB_PASSWORD=
```

## 2. Pasang nwidart/laravel-modules + merge-plugin
```bash
composer require nwidart/laravel-modules wikimedia/composer-merge-plugin
```
Di `composer.json` tambahkan (lihat `composer.merge.json`):
```json
"extra": {
  "merge-plugin": { "include": ["Modules/*/composer.json"] }
},
"config": { "allow-plugins": { "wikimedia/composer-merge-plugin": true } }
```
Pastikan `autoload.psr-4` punya `"Modules\\": "Modules/"`, lalu:
```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
composer dump-autoload
```

## 3. Buat modul, lalu salin file zip ini
```bash
php artisan module:make Book Loan UserManagement
```
Salin isi zip ke root project (timpa file yang sudah ada: `bootstrap/app.php`, `routes/web.php`, folder `Modules`, dst).

## 4. Model User
Di `app/Models/User.php`, tambahkan `'role'` ke `$fillable`.

## 5. Migrasi, seeder, storage
```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
Akun contoh (password: `password`):
- admin@sipustaka.test (admin)
- user@sipustaka.test (user)

## Catatan
- Namespace modul memakai gaya nwidart v11+ (`Modules\Book\Http\Controllers`). Jika versi Anda memakai `Modules\Book\App\...`, sesuaikan `namespace` dan `use`.
- Bukti 403: login sebagai `user`, buka `/users` atau `/books/create`.
- Bukti AJAX: buka `/loans`, DevTools > Network > Fetch/XHR, lalu tambah/ubah/hapus data.
- Bukti storage: cek folder `storage/app/public/bukti` dan kolom `path` tabel `loans` di phpMyAdmin.
