<?php

namespace App\Livewire\Aset;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app')]
class TambahAset extends Component
{
    // Properti Form (Sama seperti sebelumnya)
    public $kode_barang, $nup, $asal_perolehan;
    public $tanggal_perolehan, $harga_perolehan, $bukti_perolehan;
    public $nomor_sertifikat, $tanggal_sertifikat, $status_sertifikat;
    public $luas, $lokasi, $penggunaan, $koordinat;
    public $kondisi = 'Baik', $batas_utara, $batas_timur, $batas_selatan, $batas_barat;
    public $keterangan;

    // Rules Validasi
    protected $rules = [
        'kode_barang' => 'nullable|string|max:255',
        'asal_perolehan' => 'required|string|max:255',
        'luas' => 'required|numeric|min:0.01',
        'lokasi' => 'nullable|string',
        'kondisi' => 'required|string',
        // ... tambahkan rules lain jika perlu ...
    ];

    public function save()
    {
        $this->validate();

        try {
            // Logika Simpan Data Baru
            TanahKasDesa::create([
                'kode_barang' => $this->kode_barang ?: null,
                'nup' => $this->nup ?: null,
                'asal_perolehan' => $this->asal_perolehan,
                'tanggal_perolehan' => $this->tanggal_perolehan ?: null,
                'harga_perolehan' => $this->harga_perolehan === '' ? null : $this->harga_perolehan,
                'bukti_perolehan' => $this->bukti_perolehan ?: null,
                'nomor_sertifikat' => $this->nomor_sertifikat ?: null,
                'tanggal_sertifikat' => $this->tanggal_sertifikat ?: null,
                'status_sertifikat' => $this->status_sertifikat ?: null,
                'luas' => $this->luas,
                'lokasi' => $this->lokasi ?: null,
                'penggunaan' => $this->penggunaan ?: null,
                'koordinat' => $this->koordinat ?: null,
                'kondisi' => $this->kondisi,
                'batas_utara' => $this->batas_utara ?: null,
                'batas_timur' => $this->batas_timur ?: null,
                'batas_selatan' => $this->batas_selatan ?: null,
                'batas_barat' => $this->batas_barat ?: null,
                'keterangan' => $this->keterangan ?: null,
                'diinput_oleh' => Auth::id(),
                'status_validasi' => 'Diproses',
            ]);

            session()->flash('success', 'Data aset baru berhasil ditambahkan.');
            return $this->redirectRoute('dashboard', navigate: true);

        } catch (\Exception $e) {
            Log::error('Gagal tambah aset: ' . $e->getMessage());
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // Kita kirim variabel judul ke View agar HTML-nya dinamis
    public function render()
    {
        return view('livewire.aset.form-aset', [
            'pageTitle' => 'Tambah Aset Baru',
            'saveButtonText' => 'Simpan Data'
        ]);
    }
}