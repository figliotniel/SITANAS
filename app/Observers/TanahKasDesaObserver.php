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
<<<<<<< HEAD
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
=======
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
>>>>>>> 489b41eeaee4e3396c74feb7f1bc92bd40f53897
        }
    }

    public function deleted(TanahKasDesa $tanahKasDesa): void
    {
<<<<<<< HEAD
        // Soft Delete = Arsip
        $this->rekamLog(
            $tanahKasDesa,
            'ARSIP',
            "Mengarsipkan aset: {$tanahKasDesa->kode_barang}"
        );
=======
        if ($tanahKasDesa->isForceDeleting()) {
            return;
        }
        $this->buatLog('ARSIP', "Mengarsipkan data aset: {$tanahKasDesa->kode_barang}");
        return; 
>>>>>>> 489b41eeaee4e3396c74feb7f1bc92bd40f53897
    }

    public function restored(TanahKasDesa $tanahKasDesa): void
    {
<<<<<<< HEAD
        $this->rekamLog(
            $tanahKasDesa,
            'PULIHKAN',
            "Memulihkan aset dari arsip: {$tanahKasDesa->kode_barang}"
        );
=======
        $this->buatLog('PULIHKAN', "Memulihkan data aset dari arsip: {$tanahKasDesa->kode_barang}");
        return; 
>>>>>>> 489b41eeaee4e3396c74feb7f1bc92bd40f53897
    }

    public function forceDeleted(TanahKasDesa $tanahKasDesa): void
    {
<<<<<<< HEAD
        $this->rekamLog(
            $tanahKasDesa,
            'HAPUS PERMANEN',
            "Menghapus permanen aset: {$tanahKasDesa->kode_barang}",
            ['old_attributes' => $tanahKasDesa->toArray()]
        );
=======
        $this->buatLog('HAPUS PERMANEN', "Menghapus permanen data aset: {$tanahKasDesa->kode_barang}");
        return; 
>>>>>>> 489b41eeaee4e3396c74feb7f1bc92bd40f53897
    }


    private function rekamLog($model, $aksi, $deskripsi, $properties = [])
    {
        $userId = Auth::check() ? Auth::id() : null;

        LogAktivitas::create([
<<<<<<< HEAD
            'user_id'      => Auth::id(),
            'aksi'         => $aksi,
            'deskripsi'    => $deskripsi,
            'subject_type' => get_class($model),
            'subject_id'   => $model->id,
            'properties'   => $properties,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
=======
            'user_id' => $userId,
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'timestamp' => now()
>>>>>>> 489b41eeaee4e3396c74feb7f1bc92bd40f53897
        ]);
    }
}