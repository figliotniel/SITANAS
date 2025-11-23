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
        $this->rekamLog(
            $tanahKasDesa,
            'TAMBAH',
            "Menambahkan aset baru: {$tanahKasDesa->kode_barang}",
            ['attributes' => $tanahKasDesa->toArray()]
        );
    }

    public function updated(TanahKasDesa $tanahKasDesa): void
    {
        // 1. Cek Validasi (Jika status berubah)
        if ($tanahKasDesa->wasChanged('status_validasi')) {
            
            // Cari nama validator
            $validatorName = 'Sistem';
            if ($tanahKasDesa->divalidasi_oleh) {
                $validator = User::find($tanahKasDesa->divalidasi_oleh);
                $validatorName = $validator ? $validator->nama_lengkap : 'Kades/Pejabat';
            } elseif (Auth::check()) {
                $validatorName = Auth::user()->nama_lengkap;
            }

            $status = $tanahKasDesa->status_validasi;
            
            $this->rekamLog(
                $tanahKasDesa,
                'VALIDASI',
                "Status aset {$tanahKasDesa->kode_barang} diubah menjadi {$status} oleh {$validatorName}",
                [
                    'old' => ['status_validasi' => $tanahKasDesa->getOriginal('status_validasi')],
                    'new' => ['status_validasi' => $status, 'catatan' => $tanahKasDesa->catatan_validasi]
                ]
            );
            return; // Stop disini, jangan lanjut ke log edit
        }

        // 2. Cek Soft Delete (update deleted_at)
        // Agar tidak tercatat ganda sebagai 'Edit' saat dihapus
        if ($tanahKasDesa->wasChanged('deleted_at')) {
            return;
        }

        // 3. Cek Edit Data (Perubahan Field Lain)
        $perubahan = $tanahKasDesa->getChanges();
        
        // Hapus kolom timestamp dari daftar perubahan agar log bersih
        unset($perubahan['updated_at']); 
        unset($perubahan['divalidasi_oleh']); // Biasanya berubah bareng status
        unset($perubahan['catatan_validasi']);

        if (count($perubahan) > 0) {
            // Ambil data lama (Original) dari field yang berubah
            $dataLama = [];
            foreach ($perubahan as $key => $value) {
                $dataLama[$key] = $tanahKasDesa->getOriginal($key);
            }

            $this->rekamLog(
                $tanahKasDesa,
                'EDIT',
                "Mengubah data aset: {$tanahKasDesa->kode_barang}",
                [
                    'old' => $dataLama,
                    'new' => $perubahan
                ]
            );
        }
    }

    public function deleted(TanahKasDesa $tanahKasDesa): void
    {
        // Cek jika ini Force Delete, biar ditangani method forceDeleted
        if ($tanahKasDesa->isForceDeleting()) {
            return;
        }

        $this->rekamLog(
            $tanahKasDesa,
            'ARSIP',
            "Mengarsipkan aset: {$tanahKasDesa->kode_barang}"
        );
    }

    public function restored(TanahKasDesa $tanahKasDesa): void
    {
        $this->rekamLog(
            $tanahKasDesa,
            'PULIHKAN',
            "Memulihkan aset dari arsip: {$tanahKasDesa->kode_barang}"
        );
    }

    public function forceDeleted(TanahKasDesa $tanahKasDesa): void
    {
        $this->rekamLog(
            $tanahKasDesa,
            'HAPUS PERMANEN',
            "Menghapus permanen aset: {$tanahKasDesa->kode_barang}",
            ['old_attributes' => $tanahKasDesa->toArray()]
        );
    }

    /**
     * Helper function untuk menyimpan ke tabel log_aktivitas
     */
    private function rekamLog($model, $aksi, $deskripsi, $properties = [])
    {
        LogAktivitas::create([
            'user_id'      => Auth::id(),
            'aksi'         => $aksi,
            'deskripsi'    => $deskripsi,
            'subject_type' => get_class($model),
            'subject_id'   => $model->id,
            'properties'   => $properties,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
            // 'timestamp' => now() // HAPUS INI: Gunakan created_at bawaan Laravel saja
        ]);
    }
}