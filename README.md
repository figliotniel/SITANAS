# SITANAS (Sistem Informasi Tanah Kas Desa)

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

### 2. Instal Dependensi
Instal pustaka PHP dan JavaScript yang dibutuhkan:

Bash

composer install
npm install
