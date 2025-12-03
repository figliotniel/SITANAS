# SITANAS (Sistem Informasi Tanah Kas Desa) by Kelompok Biru

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)

**SITANAS** adalah aplikasi berbasis web yang dirancang untuk digitalisasi manajemen aset desa, khususnya **Tanah Kas Desa**. Sistem ini memfasilitasi pencatatan inventaris (NUP, Kode Barang), aspek legalitas (Sertifikat), kondisi fisik, hingga proses validasi berjenjang antara operator dan admin.

## 🚀 Fitur Utama

- **Manajemen Aset Tanah**: Pencatatan data tanah yang mendetail meliputi luas, lokasi, batas wilayah, dan koordinat.
- **Validasi Berjenjang**: Alur kerja persetujuan data dengan status *Draft*, *Diproses*, *Disetujui*, atau *Ditolak*, dilengkapi catatan validasi.
- **Arsip & Pemulihan**: Fitur keamanan data dengan *Soft Delete* (Tong Sampah), memungkinkan pemulihan data aset yang terhapus secara tidak sengaja.
- **Cetak Laporan**: Ekspor data detail aset ke format PDF siap cetak.
- **Manajemen Pengguna**: Pengaturan hak akses berbasis peran (*Role-based Access Control*) untuk Admin dan Operator.
- **Keamanan & Backup**: Terintegrasi dengan *Spatie Backup* untuk pencadangan database otomatis demi keamanan data instansi.

## 🛠️ Tech Stack

Aplikasi ini dibangun menggunakan teknologi modern (**TALL Stack**):

- **Backend**: Laravel Framework v12.x
- **Frontend**: Livewire v3.6 (Interaktivitas Full-stack)
- **Styling**: Tailwind CSS v4.0
- **Database**: MySQL / MariaDB
- **Testing**: K6 (Load & Stress Testing)
- **PDF Engine**: Laravel DomPDF

## 📋 Prasyarat Sistem

Sebelum memulai instalasi, pastikan lingkungan pengembangan Anda memiliki:

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database MySQL/MariaDB

## 💻 Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Clone Repositori
Unduh kode sumber proyek ke komputer Anda:
```bash
git clone [https://github.com/username/sitanas.git](https://github.com/username/sitanas.git)
cd sitanas
```

### 2. Instal Dependensi
Instal pustaka PHP dan JavaScript yang dibutuhkan:
``` bash
composer install
npm install
```

### 3. Konfigurasi Environment
Salin file konfigurasi contoh dan sesuaikan dengan pengaturan database lokal Anda:
```bash
cp .env.example .env
```

Buka file .env dan atur koneksi database:

```Code snippet
DB_DATABASE=sitanas_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key & Migrasi Database
Buat kunci aplikasi dan jalankan migrasi database beserta data awal (seeder):
```bash
php artisan key:generate
php artisan migrate --seed
```

#### > Catatan: Perintah --seed akan membuat akun Admin default agar Anda bisa masuk ke sistem.


### 5. Jalankan Aplikasi
Buka dua terminal terpisah untuk menjalankan server backend dan build frontend:

#### Terminal 1 (Server Laravel):
```bash
php artisan serve
```

#### Terminal 2 (Vite Hot Reload):
```bash
npm run dev
Akses aplikasi melalui browser di: http://127.0.0.1:8000
```


## 🧪 Panduan Testing (Stress Test)
SITANAS dilengkapi dengan skenario Stress Testing menggunakan k6 untuk menguji performa server di bawah beban tinggi.
### 1. Pastikan k6 sudah terinstal di sistem Anda.
### 2. Pastikan server Laravel sedang berjalan.
### 3. Jalankan skenario tes:
```bash
k6 run stress_test.js
```
#### > Skrip ini akan mensimulasikan akses dari 150 pengguna virtual secara bersamaan untuk menguji stabilitas aplikasi.

## ☁️ Panduan Deployment (Production)
Langkah-langkah untuk menyebarkan aplikasi ke server produksi (VPS/Hosting):
### 1. Permission Folder: Pastikan folder storage/ dan bootstrap/cache/ memiliki izin tulis (biasanya 775).
### 2. Environment: Ubah pengaturan di file .env:
```Code snippet
APP_ENV=production
APP_DEBUG=false
```

### 3. Optimasi: Jalankan perintah optimasi Laravel:
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Build Frontend: Kompilasi aset CSS dan JS untuk produksi:
```bash
npm run build
```

### 5. Migrasi: Jalankan migrasi database di server produksi:
```bash
php artisan migrate --force
```

## 📄 Lisensi
SITANAS adalah perangkat lunak open-source di bawah lisensi MIT.
