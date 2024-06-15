# 📚✨ Project E-Library

Selamat datang di proyek **E-Library**. Ini adalah panduan lengkap untuk menjalankan aplikasi perpustakaan berbasis Laravel ini.

## 🔐 Informasi Login Admin

- **Email**: admin@mail.com
- **Password**: admin

## 🚀 Langkah-langkah Menjalankan Aplikasi

Ikuti langkah-langkah di bawah ini untuk mempersiapkan dan menjalankan aplikasi:

### 1. Jalankan Migrasi Database

Untuk membuat tabel-tabel yang diperlukan dalam database, jalankan perintah berikut:
```bash
php artisan migrate
```

### 2. Isi Database dengan Data Awal

Setelah migrasi berhasil, isi database dengan data awal menggunakan perintah:
```bash
php artisan db:seed
```
🌐 Tampilan Desain Web
Tampilan desain web saat ini sedang dalam proses pengembangan. Berikut adalah pratinjau desain untuk halaman login dan fitur scan QR:
![6674d9c5-a120-451a-9057-c1c30d30c603](https://github.com/muhSalfazi/project_E-library/assets/121502387/8d6d3a1b-3d06-4774-867e-747a847d6c0b)
Pratinjau Fitur Scan QR
![7a6773ca-d9f5-46c4-b77c-f671b3b4bfbb](https://github.com/muhSalfazi/project_E-library/assets/121502387/443ac380-6d9d-4172-8b26-bb63d6004995)
🛠️ Teknologi yang Digunakan
Laravel: Framework PHP untuk pengembangan web.
MySQL: Database management system.
HTML/CSS: Untuk tampilan antarmuka pengguna.
Template Admin: Modernize Bootstrap Lite
📜 Pemberitahuan Animasi dan QR Code
Untuk meningkatkan pengalaman pengguna, proyek ini menggunakan pemberitahuan dengan animasi menggunakan animate.css dan sweetalert, serta fitur QR Code menggunakan html5qrcode dan endroid qr-code.

📊 Tabel Data Interaktif
Data dalam aplikasi ini ditampilkan menggunakan simple-datatable, memudahkan untuk melihat dan mengelola informasi perpustakaan dengan lebih efisien.

📜 Lisensi
Proyek ini dilisensikan di bawah MIT License.

