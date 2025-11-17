<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Dashboard\DashboardPage;
use App\Livewire\Aset\FormAset;
use App\Livewire\Aset\DetailPage;
use App\Livewire\Admin\ManajemenUser;
use App\Livewire\Laporan\LaporanPage;
use App\Livewire\Admin\ArsipAset;
use App\Livewire\Public\HalamanPublik;


Route::get('/publik', HalamanPublik::class)->name('publik');


Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
});


Route::middleware('auth')->group(function () {
    
    // Rute Dashboard
    Route::get('/', DashboardPage::class)->name('dashboard');

    // Rute ASET (STRUKTUR YANG BENAR & AMAN)
    
    // 1. TAMBAH (STATIS: /tanah/tambah). Harus di atas semua rute dinamis /tanah/{aset}.
    Route::get('/tanah/tambah', FormAset::class)->name('aset.tambah');

    // 2. EDIT (DINAMIS: /tanah/{ID}/edit)
    Route::get('/tanah/{aset}/edit', FormAset::class)->withTrashed()->name('aset.edit');
    
    // 3. DETAIL (DINAMIS: /tanah/{ID}). Harus di bawah rute statis.
    Route::get('/tanah/{aset}', DetailPage::class)->name('aset.detail'); 

    // Rute Laporan
    Route::get('/laporan', LaporanPage::class)->name('laporan');

    // Rute Admin
    Route::get('/admin/users', ManajemenUser::class)->name('admin.users');
    Route::get('/admin/arsip', ArsipAset::class)->name('admin.arsip');
    
});