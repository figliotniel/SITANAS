<?php

namespace App\Observers;

use App\Models\TanahKasDesa;
use App\Models\LogAktivitas;
use App\Models\User;
use App\Mail\NotifikasiValidasiAset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TanahKasDesaObserver
{
    public function created(TanahKasDesa $tanahKasDesa): void
    {
        // 1. Rekam Log Tambah
        $this->rekamLog(
            $tanahKasDesa,
            'TAMBAH',
            "Menambahkan aset baru: {$tanahKasDesa->kode_barang}",
            ['attributes' => $tanahKasDesa->toArray()]
        );

        // 2. Kirim Email Notifikasi (Selalu kirim untuk data baru)
        $this->kirimNotifikasiKeKades($tanahKasDesa, 'BARU');
    }

    public function updated(TanahKasDesa $tanahKasDesa): void
    {
        // A. CEK VALIDASI (Kades melakukan persetujuan/penolakan)
        if ($tanahKasDesa->wasChanged('status_validasi')) {
            // Jika status berubah jadi DISETUJUI atau DITOLAK, itu aksi Validasi
            if (in_array($tanahKasDesa->status_validasi, ['Disetujui', 'Ditolak'])) {
                $validatorName = $this->getValidatorName($tanahKasDesa);
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
                return; // Stop, jangan catat edit
            }
        }

        // B. CEK SOFT DELETE (Agar tidak tercatat ganda)
        if ($tanahKasDesa->wasChanged('deleted_at')) return;

        // C. CEK EDIT DATA (Admin mengupdate data)
        $perubahan = $tanahKasDesa->getChanges();
        
        // Hapus kolom teknis yang tidak perlu dicatat
        unset($perubahan['updated_at'], $perubahan['divalidasi_oleh'], $perubahan['catatan_validasi']);

        // Jika ada data fisik yang berubah (Harga, Luas, Lokasi, dll)
        if (count($perubahan) > 0) {
            $dataLama = [];
            foreach ($perubahan as $key => $value) {
                $dataLama[$key] = $tanahKasDesa->getOriginal($key);
            }

            // 1. Rekam Log Edit
            $this->rekamLog(
                $tanahKasDesa,
                'EDIT',
                "Mengubah data aset: {$tanahKasDesa->kode_barang}",
                ['old' => $dataLama, 'new' => $perubahan]
            );

            // 2. Kirim Email Notifikasi (PERBAIKAN DI SINI)
            // Kirim email jika statusnya 'Diproses'.
            // Logika ini menangkap dua kasus:
            // a. Status berubah dari Disetujui -> Diproses (Edit ulang)
            // b. Status tetap Diproses -> Diproses (Edit revisi)
            if ($tanahKasDesa->status_validasi == 'Diproses') {
                $this->kirimNotifikasiKeKades($tanahKasDesa, 'UPDATE');
            }
        }
    }

    public function deleted(TanahKasDesa $tanahKasDesa): void
    {
        if ($tanahKasDesa->isForceDeleting()) return;
        $this->rekamLog($tanahKasDesa, 'ARSIP', "Mengarsipkan aset: {$tanahKasDesa->kode_barang}");
    }

    public function restored(TanahKasDesa $tanahKasDesa): void
    {
        $this->rekamLog($tanahKasDesa, 'PULIHKAN', "Memulihkan aset dari arsip: {$tanahKasDesa->kode_barang}");
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

    // --- HELPER FUNCTIONS ---

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

    private function getValidatorName($aset)
    {
        if ($aset->divalidasi_oleh) {
            return User::find($aset->divalidasi_oleh)->nama_lengkap ?? 'Pejabat Desa';
        }
        return Auth::check() ? Auth::user()->nama_lengkap : 'Sistem';
    }

    private function kirimNotifikasiKeKades($aset, $tipe)
    {
        try {
            // Cari semua user dengan role_id = 2 (Kepala Desa)
            $listKades = User::where('role_id', 2)->get();

            foreach ($listKades as $kades) {
                if ($kades->email) {
                    Mail::to($kades->email)->send(new NotifikasiValidasiAset($aset, $tipe));
                }
            }
        } catch (\Exception $e) {
            Log::error('Gagal kirim email notifikasi: ' . $e->getMessage());
        }
    }
}