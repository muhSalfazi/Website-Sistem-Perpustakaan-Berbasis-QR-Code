<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">

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
2. Isi Database dengan Data Awal
Setelah migrasi berhasil, isi database dengan data awal menggunakan perintah:
php artisan db:seed
🌐 Tampilan Desain Web
Tampilan desain web saat ini sedang dalam proses pengembangan. Berikut adalah pratinjau desain untuk halaman login dan fitur scan QR:

Pratinjau Halaman Login
![6674d9c5-a120-451a-9057-c1c30d30c603](https://github.com/muhSalfazi/project_E-library/assets/121502387/955d4914-c4ea-4296-a881-f60d7e07973b)
Pratinjau Fitur Scan QR![7a6773ca-d9f5-46c4-b77c-f671b3b4bfbb](https://github.com/muhSalfazi/project_E-library/assets/121502387/7e791fa0-a9a2-4d5c-84b5-8c15615b13d2)

🛠️ Teknologi yang Digunakan
Laravel: Framework PHP untuk pengembangan web.
MySQL: Database management system.
HTML/CSS: Untuk tampilan antarmuka pengguna
Template Admin: Modernize Bootstrap Lite https://demos.adminmart.com/free/bootstrap/modernize-bootstrap-lite/src/html/index.html

📊 Statistik Penggunaan
Gunakan grafik berikut untuk melihat statistik penggunaan aplikasi:

<div class="chart" id="userStatistics"></div>
<script>
    // Contoh penggunaan ApexCharts untuk grafik
    var options = {
        chart: {
            type: 'bar',
            height: 350,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        series: [{
            name: 'Pengguna Aktif',
            data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep']
        }
    };

    var chart = new ApexCharts(document.querySelector("#userStatistics"), options);
    chart.render();
</script>
📜 Lisensi
Proyek ini dilisensikan di bawah MIT License.

</link>







