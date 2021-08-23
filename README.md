<h1 align="center">Selamat datang di SI Perpus Ajax Yajira Datatables 👋</h1>


## Fitur apa saja yang tersedia di Sistem ini?

- Autentikasi Admin dan Anggota

## Admin
- Mengelola Data Anggota
- Mengelola Data Buku
- Mengelola Data Penerbit
- Mengelola Data Klasifikasi
- Mengelola Data Peminjaman
- Mengelola Data Pengembalian
- Mengelola Data Denda
- Mencetak Laporan
- Dan lain-lain

## Anggota
- Melihat Data Buku
- Melakukan Peminjaman
- Melihat Denda
- Dan lain-lain



---

## Install

1. **Clone Repository**

```bash
git clone https://github.com/septianawijayanto/perpus_laravel_ajax_yajra_datatables.git
cd perpus_laravel_ajax
composer install
cp .env.example .env
```

2. **Buka `.env` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai**

```bash
DB_PORT=3306
DB_DATABASE=db_perpus_ajax
DB_USERNAME=root
DB_PASSWORD=

```

3. **Instalasi website**

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

4. **Jalankan website**

```bash
php artisan serve
```
5. **Authentikasi**

```bash
##Admin
Username : admin
Password : admin

##Anggota
Username : anggota
Password : anggota
```

## Author
- **Facebook  <a href="https://www.facebook.com/septianawijayanto/">Septiana Wijayanto</a>**
- **Instagram  <a href="https://www.instagram.com/septianawijayanto/">@septianawijayannto</a>**



## License

- Copyright © 2021 Septiana Wijayanto.
- **Sistem Informasi Laundry is open-sourced software licensed under the MIT license.**
<!-- - **Thanks To <a href="https://github.com/septianawijayanto"> Septiana Wijayanto </a>** -->
