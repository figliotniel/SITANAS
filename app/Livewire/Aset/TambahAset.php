<?php

namespace App\Livewire\Aset;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class TambahAset extends Component
{
    public $pageTitle = 'Tambah Aset Tanah';
    public $saveButtonText = 'Simpan Aset Baru';

    // Properti Form
    public $kode_barang;
    public $nama_barang; // <--- Properti Baru
    public $nup;
    public $asal_perolehan;
    public $tanggal_perolehan;
    public $harga_perolehan;
    public $bukti_perolehan = 'Sertifikat'; 
    
    public $nomor_sertifikat;
    public $tanggal_sertifikat;
    public $status_sertifikat = 'Sertifikat Hak Pakai'; 
    
    public $luas;
    public $lokasi;
    public $penggunaan = 'Jalan'; 
    public $koordinat;
    public $kondisi = 'Baik'; 
    
    public $batas_utara;
    public $batas_timur;
    public $batas_selatan;
    public $batas_barat;
    public $keterangan;

    protected $rules = [
        'kode_barang'       => 'required|string|unique:tanah_kas_desa,kode_barang',
        'nama_barang'       => 'required|string|max:255', // <--- Validasi Baru
        'asal_perolehan'    => 'required|string',
        'tanggal_perolehan' => 'required|date',
        'harga_perolehan'   => 'required|numeric|min:0',
        'luas'              => 'required|numeric|min:1',
        'lokasi'            => 'required|string|max:500',
        'kondisi'           => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        'penggunaan'        => 'required|string',
        'bukti_perolehan'   => 'required|string',
    ];

    protected $messages = [
        'kode_barang.required' => 'Kode barang wajib diisi sesuai KIB A.',
        'nama_barang.required' => 'Nama jenis barang wajib diisi.',
        'harga_perolehan.required' => 'Harga aset wajib diisi (nominal rupiah).',
    ];

    public function simpan()
    {
        $this->validate();

        TanahKasDesa::create([
            'kode_barang'        => $this->kode_barang,
            'nama_barang'        => $this->nama_barang, // <--- Simpan Baru
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
            'diinput_oleh'       => Auth::id(),
            'status_validasi'    => 'Diproses',
        ]);

        session()->flash('success', 'Data aset berhasil disimpan ke buku inventaris.');
        return $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.aset.form-aset');
    }
}