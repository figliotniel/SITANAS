<?php

namespace App\Livewire\Aset;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class EditAset extends Component
{
    public TanahKasDesa $aset;

    public $kode_barang;
    public $nama_barang;
    public $nup;
    public $asal_perolehan;
    public $tanggal_perolehan;
    public $harga_perolehan;
    public $bukti_perolehan = 'Sertifikat';
    
    public $nomor_sertifikat;
    public $tanggal_sertifikat;
    public $status_sertifikat;
    
    public $luas;
    public $lokasi;
    public $penggunaan;
    public $koordinat;
    public $kondisi;
    
    public $batas_utara;
    public $batas_timur;
    public $batas_selatan;
    public $batas_barat;
    public $keterangan;

    public function mount(TanahKasDesa $aset)
    {
        $this->aset = $aset;

        $this->kode_barang      = $aset->kode_barang;
        $this->nama_barang      = $aset->nama_barang;
        $this->nup              = $aset->nup;
        $this->asal_perolehan   = $aset->asal_perolehan;
        $this->tanggal_perolehan= $aset->tanggal_perolehan;
        $this->harga_perolehan  = $aset->harga_perolehan;
        $this->bukti_perolehan  = $aset->bukti_perolehan;
        
        $this->nomor_sertifikat = $aset->nomor_sertifikat;
        $this->tanggal_sertifikat = $aset->tanggal_sertifikat;
        $this->status_sertifikat = $aset->status_sertifikat;
        
        $this->luas             = $aset->luas;
        $this->lokasi           = $aset->lokasi;
        $this->penggunaan       = $aset->penggunaan;
        $this->koordinat        = $aset->koordinat;
        $this->kondisi          = $aset->kondisi;
        
        $this->batas_utara      = $aset->batas_utara;
        $this->batas_timur      = $aset->batas_timur;
        $this->batas_selatan    = $aset->batas_selatan;
        $this->batas_barat      = $aset->batas_barat;
        $this->keterangan       = $aset->keterangan;
    }

    public function simpan()
    {
        $this->validate([
            'kode_barang'       => 'required|string|unique:tanah_kas_desa,kode_barang,' . $this->aset->id,
            'nama_barang'       => 'required|string|max:255',
            'asal_perolehan'    => 'required|string',
            'tanggal_perolehan' => 'required|date',
            'harga_perolehan'   => 'required|numeric|min:0',
            'luas'              => 'required|numeric|min:1',
            'lokasi'            => 'required|string|max:500',
            'kondisi'           => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'penggunaan'        => 'required|string',
        ], [
            'kode_barang.unique' => 'Kode barang sudah digunakan aset lain.',
        ]);

        $this->aset->update([
            'kode_barang'        => $this->kode_barang,
            'nama_barang'        => $this->nama_barang,
            'nup'                => $this->nup,
            'asal_perolehan'     => $this->asal_perolehan,
            'tanggal_perolehan'  => $this->tanggal_perolehan,
            'harga_perolehan'    => $this->harga_perolehan,
            'bukti_perolehan'    => $this->bukti_perolehan,
            'nomor_sertifikat'   => $this->nomor_sertifikat,
            'tanggal_sertifikat' => $this->tanggal_sertifikat,
            'status_sertifikat'  => $this->status_sertifikat,
            'luas'               => $this->luas,
            'lokasi'             => $this->lokasi,
            'penggunaan'         => $this->penggunaan,
            'koordinat'          => $this->koordinat,
            'kondisi'            => $this->kondisi,
            'batas_utara'        => $this->batas_utara,
            'batas_timur'        => $this->batas_timur,
            'batas_selatan'      => $this->batas_selatan,
            'batas_barat'        => $this->batas_barat,
            'keterangan'         => $this->keterangan,
            
            'status_validasi'    => 'Diproses',
            'catatan_validasi'   => null,
            'divalidasi_oleh'    => null,
        ]);

        session()->flash('success', 'Perubahan data aset berhasil disimpan.');
        return $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.aset.form-aset');
    }
}