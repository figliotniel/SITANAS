<?php

namespace App\Livewire\Aset;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use App\Models\DokumenPendukung;
use App\Models\PemanfaatanTanah;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class FormAset extends Component
{
    public ?TanahKasDesa $aset = null;
    public $isEditMode = false;
    public $kode_barang = '';
    public $nup = '';
    public $asal_perolehan = '';
    public $tanggal_perolehan = '';
    public $harga_perolehan = '';
    public $bukti_perolehan = '';
    public $nomor_sertifikat = '';
    public $tanggal_sertifikat = '';
    public $status_sertifikat = '';
    public $luas = '';
    public $lokasi = '';
    public $penggunaan = '';
    public $koordinat = '';
    public $kondisi = 'Baik';
    public $batas_utara = '';
    public $batas_timur = '';
    public $batas_selatan = '';
    public $batas_barat = '';
    public $keterangan = '';

    protected $rules = [
        'kode_barang' => 'nullable|string|max:255',
        'nup' => 'nullable|string|max:255',
        'asal_perolehan' => 'required|string|max:255',
        'tanggal_perolehan' => 'nullable|date',
        'harga_perolehan' => 'nullable|numeric|min:0',
        'bukti_perolehan' => 'nullable|string|max:255',
        'nomor_sertifikat' => 'nullable|string|max:255',
        'tanggal_sertifikat' => 'nullable|date',
        'status_sertifikat' => 'nullable|string|max:255',
        'luas' => 'required|numeric|min:0',
        'lokasi' => 'nullable|string',
        'penggunaan' => 'nullable|string|max:255',
        'koordinat' => 'nullable|string|max:255',
        'kondisi' => 'required|string',
        'batas_utara' => 'nullable|string|max:255',
        'batas_timur' => 'nullable|string|max:255',
        'batas_selatan' => 'nullable|string|max:255',
        'batas_barat' => 'nullable|string|max:255',
        'keterangan' => 'nullable|string',
    ];

    public function mount(?TanahKasDesa $aset = null)
    {
        if ($aset) {
            $this->aset = $aset;
            $this->isEditMode = true;
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
       }


    public function save()
    {
        $this->validate();

        $data = [
            'kode_barang' => $this->kode_barang,
            'nup' => $this->nup,
            'asal_perolehan' => $this->asal_perolehan,
            'tanggal_perolehan' => $this->tanggal_perolehan,
            'harga_perolehan' => $this->harga_perolehan ?: 0,
            'bukti_perolehan' => $this->bukti_perolehan,
            'nomor_sertifikat' => $this->nomor_sertifikat,
            'tanggal_sertifikat' => $this->tanggal_sertifikat,
            'status_sertifikat' => $this->status_sertifikat,
            'luas' => $this->luas,
            'lokasi' => $this->lokasi,
            'penggunaan' => $this->penggunaan,
            'koordinat' => $this->koordinat,
            'kondisi' => $this->kondisi,
            'batas_utara' => $this->batas_utara,
            'batas_timur' => $this->batas_timur,
            'batas_selatan' => $this->batas_selatan,
            'batas_barat' => $this->batas_barat,
            'keterangan' => $this->keterangan,
        ];

        if ($this->isEditMode) {
            $data['status_validasi'] = 'Diproses';
            $this->aset->update($data);
            
            session()->flash('success', 'Data aset berhasil diperbarui.');

        } else {
            $data['diinput_oleh'] = Auth::id();
            $data['status_validasi'] = 'Diproses';
            TanahKasDesa::create($data);
            
            session()->flash('success', 'Data aset baru berhasil ditambahkan.');
        }

        return $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.aset.form-aset');
    }
}