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
        // 1. CEK RESTORE (Prioritas Mutlak)
        if ($tanahKasDesa->wasChanged('deleted_at')) {
            return; 
        }

        // Normalisasi status baru (Huruf Besar & Tanpa Spasi)
        $statusBaru = trim(strtoupper($tanahKasDesa->status_validasi));

        // 2. CEK PERUBAHAN STATUS (Logika Validasi Detail)
        if ($tanahKasDesa->wasChanged('status_validasi')) {
            
            // [A] LOGIKA MENCARI NAMA VALIDATOR
            $validatorName = 'Admin/Sistem';
            if ($tanahKasDesa->divalidasi_oleh) {
                // Cari nama user berdasarkan ID validator
                $validator = User::find($tanahKasDesa->divalidasi_oleh);
                $validatorName = $validator ? $validator->nama_lengkap : 'Kades';
            } elseif (Auth::check()) {
                // Fallback: gunakan user yang sedang login saat ini
                $validatorName = Auth::user()->nama_lengkap;
            }

            // [B] AMBIL KODE BARANG
            $kodeBarang = $tanahKasDesa->kode_barang;

            // [C] PENYUSUNAN KALIMAT DESKRIPSI LENGKAP
            if ($statusBaru === 'DITOLAK') {
                $deskripsi = "Aset {$kodeBarang} telah ditolak oleh {$validatorName}";
                $this->buatLog('DITOLAK', $deskripsi);
                return; // Stop proses
            } 
            elseif ($statusBaru === 'DISETUJUI') {
                $deskripsi = "Aset {$kodeBarang} telah disetujui oleh {$validatorName}";
                $this->buatLog('DISETUJUI', $deskripsi);
                return; // Stop proses
            }
        }

        // 3. CEK EDIT DATA (Dengan Filter Pencegah Log Ganda)
        $kolomData = [
            'kode_barang', 'nama_barang', 'nomor_register', 'luas', 
            'tahun_pengadaan', 'alamat', 'hak', 'tanggal_sertifikat', 
            'nomor_sertifikat', 'asal_usul', 'harga', 'keterangan'
        ];

        if ($tanahKasDesa->wasChanged($kolomData)) {
            // Filter: Jika hanya 'keterangan' yang berubah DAN statusnya 'DITOLAK',
            // Abaikan log ini (karena bagian dari proses penolakan)
            if ($tanahKasDesa->wasChanged('keterangan') && $statusBaru === 'DITOLAK') {
                return; 
            }

            $this->buatLog('EDIT', "Memperbarui detail data aset: {$tanahKasDesa->kode_barang}");
        }
    }

    public function deleted(TanahKasDesa $tanahKasDesa): void
    {
        if ($tanahKasDesa->isForceDeleting()) {
            return;
        }
        $this->buatLog('ARSIP', "Mengarsipkan data aset: {$tanahKasDesa->kode_barang}");
        return; 
    }

    public function restored(TanahKasDesa $tanahKasDesa): void
    {
        $this->buatLog('PULIHKAN', "Memulihkan data aset dari arsip: {$tanahKasDesa->kode_barang}");
        return; 
    }

    public function forceDeleted(TanahKasDesa $tanahKasDesa): void
    {
        $this->buatLog('HAPUS PERMANEN', "Menghapus permanen data aset: {$tanahKasDesa->kode_barang}");
        return; 
    }

    private function buatLog($aksi, $deskripsi)
    {
        $userId = Auth::check() ? Auth::id() : null;

        LogAktivitas::create([
            'user_id' => $userId,
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'timestamp' => now()
        ]);
    }
}