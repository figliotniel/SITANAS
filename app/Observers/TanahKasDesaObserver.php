<?php

namespace App\Observers;

use App\Models\TanahKasDesa;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TanahKasDesaObserver
{
    public function created(TanahKasDesa $tanahKasDesa): void
    {
        $this->buatLog('TAMBAH', "Membuat data aset baru: {$tanahKasDesa->kode_barang}");
    }

    public function updated(TanahKasDesa $tanahKasDesa): void
    {
        // Cek apakah ini "Validasi"
        if ($tanahKasDesa->wasChanged('status_validasi')) {
            // Ambil nama Kades yang memvalidasi (safe check untuk null)
            $validator = User::find($tanahKasDesa->divalidasi_oleh);
            $namaValidator = $validator?->nama_lengkap ?? 'Kades';
            $this->buatLog('VALIDASI', "Aset {$tanahKasDesa->kode_barang} telah di-{$tanahKasDesa->status_validasi} oleh {$namaValidator}", $tanahKasDesa->divalidasi_oleh ?? null);
        } else {
            // Jika tidak, anggap ini "Edit" biasa
            $this->buatLog('EDIT', "Memperbarui data aset: {$tanahKasDesa->kode_barang}");
        }
    }

    public function deleted(TanahKasDesa $tanahKasDesa): void
    {
        $this->buatLog('ARSIP', "Mengarsipkan data aset: {$tanahKasDesa->kode_barang}");
    }

    public function restored(TanahKasDesa $tanahKasDesa): void
    {
        $this->buatLog('PULIHKAN', "Memulihkan data aset dari arsip: {$tanahKasDesa->kode_barang}");
    }

    public function forceDeleted(TanahKasDesa $tanahKasDesa): void
    {
        $this->buatLog('HAPUS PERMANEN', "Menghapus permanen data aset: {$tanahKasDesa->kode_barang}");
    }

    private function buatLog($aksi, $deskripsi, $userId = null)
    {
        LogAktivitas::create([
            'user_id' => $userId ?? Auth::id(), // Otomatis ambil ID user yang login jika tidak diberikan
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'timestamp' => now()
        ]);
    }
}