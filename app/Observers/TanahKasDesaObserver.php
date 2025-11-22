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
        if ($tanahKasDesa->wasChanged('status_validasi')) {
            $validator = User::find($tanahKasDesa->divalidasi_oleh)->nama_lengkap ?? 'System';
            $status = $tanahKasDesa->status_validasi;
            
            $this->rekamLog(
                $tanahKasDesa,
                'VALIDASI',
                "Status aset diubah menjadi {$status} oleh {$validator}",
                [
                    'old' => ['status_validasi' => $tanahKasDesa->getOriginal('status_validasi')],
                    'new' => ['status_validasi' => $status, 'catatan' => $tanahKasDesa->catatan_validasi]
                ]
            );
            return;
        }

        $perubahan = $tanahKasDesa->getChanges();
        unset($perubahan['updated_at']); 

        if (count($perubahan) > 0) {
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
        // Soft Delete = Arsip
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
        ]);
    }
}