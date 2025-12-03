# SITANAS (Sistem Informasi Tanah Kas Desa)

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)

SITANAS adalah aplikasi berbasis web yang dirancang untuk digitalisasi manajemen aset desa, khususnya **Tanah Kas Desa**. Sistem ini memfasilitasi pencatatan inventaris (NUP, Kode Barang), aspek legalitas (Sertifikat), kondisi fisik, hingga proses validasi berjenjang antara operator dan admin.

## 🚀 Fitur Utama

- **Manajemen Aset Tanah**: CRUD data tanah dengan detail lengkap (Lokasi, Batas, Luas, Koordinat).
- **Validasi Berjenjang**: Sistem status (Draft, Diproses, Disetujui, Ditolak) dengan fitur catatan validasi.
- **Arsip & Pemulihan**: Fitur *Soft Delete* (Tong Sampah) untuk memulihkan data aset yang terhapus.
- **Cetak Laporan**: Ekspor detail aset ke format PDF.
- **Manajemen Pengguna**: Kontrol akses berbasis Role (Admin & User).
- **Keamanan Data**: Terintegrasi dengan *Spatie Backup* untuk pencadangan database otomatis.

## 🛠️ Tech Stack

Aplikasi ini dibangun menggunakan teknologi modern (**TALL Stack**):

- **Backend**: Laravel Framework v12.x
- **Frontend**: Livewire v3.6 (Full-stack interactivity)
- **Styling**: Tailwind CSS v4.0
- **Database**: MySQL / MariaDB
- **Testing**: K6 (untuk Load/Stress Testing)
- **PDF Engine**: Laravel DomPDF

## 📋 Prasyarat Sistem

Sebelum menginstal, pastikan server/komputer Anda memiliki:

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database MySQL

## 💻 Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

1. **Clone Repositori**
   ```bash
   git clone [https://github.com/username/sitanas.git](https://github.com/username/sitanas.git)
   cd sitanas
