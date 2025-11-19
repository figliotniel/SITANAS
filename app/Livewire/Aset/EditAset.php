<?php

namespace App\Livewire\Aset;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app')]
class EditAset extends Component
{
    public TanahKasDesa $aset;
    public $kode_barang, $nup, $asal_perolehan;
    public $tanggal_perolehan, $harga_perolehan, $bukti_perolehan;
    public $nomor_sertifikat, $tanggal_sertifikat, $status_sertifikat;
    public $luas, $lokasi, $penggunaan, $koordinat;
    public $kondisi, $batas_utara, $batas_timur, $batas_selatan, $batas_barat;
    public $keterangan;

    protected $rules = [
        'kode_barang' => 'nullable|string|max:255',
        'asal_perolehan' => 'required|string|max:255',
        'luas' => 'required|numeric|min:0.01',
        'lokasi' => 'nullable|string',
        'kondisi' => 'required|string',
    ];

    public function mount(TanahKasDesa $aset)
    {
        $this->aset = $aset;
        $this->kode_barang = $aset->kode_barang;
        $this->nup = $aset->nup;
        $this->asal_perolehan = $aset->asal_perolehan;
        $this->tanggal_perolehan = $aset->tanggal_perolehan;
        $this->harga_perolehan = $aset->harga_perolehan;
        $this->bukti_perolehan = $aset->bukti_perolehan;
        $this->nomor_sertifikat = $aset->nomor_sertifikat;
        $this->tanggal_sertifikat = $aset->tanggal_sertifikat;
        $this->status_sertifikat = $aset->status_sertifikat;
        $this->luas = $aset->luas;
        $this->lokasi = $aset->lokasi;
        $this->penggunaan = $aset->penggunaan;
        $this->koordinat = $aset->koordinat;
        $this->kondisi = $aset->kondisi;
        $this->batas_utara = $aset->batas_utara;
        $this->batas_timur = $aset->batas_timur;
        $this->batas_selatan = $aset->batas_selatan;
        $this->batas_barat = $aset->batas_barat;
        $this->keterangan = $aset->keterangan;
    }

    public function save()
    {
        $this->validate();
        try {
            $this->aset->update([
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
                'status_validasi' => 'Diproses',
            ]);

            session()->flash('success', 'Data aset berhasil diperbarui.');
            return $this->redirectRoute('dashboard', navigate: true);

        } catch (\Exception $e) {
            Log::error('Gagal update aset: ' . $e->getMessage());
            session()->flash('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.aset.form-aset', [
            'pageTitle' => 'Edit Data Aset',
            'saveButtonText' => 'Simpan Perubahan'
        ]);
    }
}