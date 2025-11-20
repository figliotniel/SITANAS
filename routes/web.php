<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Dashboard\DashboardPage;
use App\Livewire\Aset\FormAset;
use App\Livewire\Aset\TambahAset;
use App\Livewire\Aset\EditAset;
use App\Livewire\Aset\DetailPage;
use App\Livewire\Admin\ManajemenUser;
use App\Livewire\Laporan\LaporanPage;
use App\Livewire\Admin\ArsipAset;
use App\Livewire\Public\HalamanPublik;
use App\Livewire\Admin\LogAktivitasPage;
use Illuminate\Http\Request;
use App\Models\TanahKasDesa;

Route::post('/test-input-k6', function (Request $request) {
    
    // Kita isi data wajib dengan dummy dari k6 + default value
    TanahKasDesa::create([
        'kode_barang'       => 'K6-TEST-' . rand(1000, 9999), // Kode acak
        'nup'               => rand(1, 100),
        'asal_perolehan'    => 'Load Testing k6',
        'tanggal_perolehan' => now(),
        
        // Data ini dikirim dari script k6
        'luas'              => $request->luas, 
        'lokasi'            => $request->lokasi,
        'keterangan'        => $request->keterangan,
        
        // Data default lainnya
        'kondisi'           => 'Baik',
        'status_validasi'   => 'Draft',
        'diinput_oleh'      => 1, // Asumsi ada User dengan ID 1 (Admin)
    ]);

    return response()->json(['message' => 'Data Masuk'], 201);
});


Route::get('/publik', HalamanPublik::class)->name('publik');


Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
});


Route::middleware('auth')->group(function () {

    Route::get('/', DashboardPage::class)->name('dashboard');

    Route::get('/tanah/baru', TambahAset::class)->name('aset.tambah');

    Route::get('/tanah/{aset}/edit', EditASet::class)->withTrashed()->name('aset.edit');

    Route::get('/tanah/{aset}', DetailPage::class)->name('aset.detail'); 

    Route::get('/laporan', LaporanPage::class)->name('laporan');

    Route::get('/admin/users', ManajemenUser::class)->name('admin.users');
    Route::get('/admin/arsip', ArsipAset::class)->name('admin.arsip');
    Route::get('/admin/log', LogAktivitasPage::class)->name('admin.log');
    
});