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

#[Layout('layouts.app')]
class DetailPage extends Component
{
    use WithFileUploads;

    public TanahKasDesa $aset;
    public $dokumen_pendukung = [];
    
    // Properti Pemanfaatan
    public $p_bentuk_pemanfaatan = 'Sewa';
    public $p_pihak_ketiga;
    public $p_tanggal_mulai;
    public $p_tanggal_selesai;
    public $p_nilai_kontribusi = 0;
    public $p_status_pembayaran = 'Belum Lunas';
    public $p_path_bukti;
    public $p_keterangan;

    // Properti Dokumen
    public $fileUpload;
    public $nama_dokumen;
    public $kategori_dokumen = 'Lain-lain';
    public $tanggal_kadaluarsa;

    // Properti Validasi (Kades)
    public $showValidasiModal = false;
    public $validasiStatus;
    public $validasiCatatan;

    public function mount(TanahKasDesa $aset)
    {
        $this->aset = $aset->load(['diinput_oleh_user', 'divalidasi_oleh_user']);
        $this->loadDokumenPendukung();
    }

    public function downloadDetailPdf()
    {
        $pdf = Pdf::loadView('pdf.detail-aset', ['aset' => $this->aset]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'detail-aset-'.$this->aset->kode_barang.'.pdf');
    }

    public function loadDokumenPendukung()
    {
        $user = Auth::user();
        $allowedRoles = ['Admin Desa', 'Kepala Desa', 'BPD (Pengawas)'];

        if ($user && $user->role && in_array($user->role->nama_role, $allowedRoles)) {
            $this->dokumen_pendukung = $this->aset->dokumen()->get();
        }
    }

    public function simpanPemanfaatan()
    {
        if (Auth::user()->role_id != 1) return; 

        $validated = $this->validate([
            'p_bentuk_pemanfaatan' => 'required|string',
            'p_pihak_ketiga' => 'required|string|max:255',
            'p_tanggal_mulai' => 'required|date',
            'p_tanggal_selesai' => 'required|date|after_or_equal:p_tanggal_mulai',
            'p_nilai_kontribusi' => 'required|numeric|min:0',
            'p_status_pembayaran' => 'required|string',
            'p_path_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 
            'p_keterangan' => 'nullable|string',
        ]);

        $pathBukti = null;
        if ($this->p_path_bukti) {
            $pathBukti = $this->p_path_bukti->store('bukti_pemanfaatan/' . $this->aset->id, 'public');
        }

        $this->aset->pemanfaatan()->create([
            'bentuk_pemanfaatan' => $validated['p_bentuk_pemanfaatan'],
            'pihak_ketiga' => $validated['p_pihak_ketiga'],
            'tanggal_mulai' => $validated['p_tanggal_mulai'],
            'tanggal_selesai' => $validated['p_tanggal_selesai'],
            'nilai_kontribusi' => $validated['p_nilai_kontribusi'],
            'status_pembayaran' => $validated['p_status_pembayaran'],
            'path_bukti' => $pathBukti,
            'keterangan' => $validated['p_keterangan'],
            'diinput_oleh' => Auth::id(),
        ]);

        $this->reset(
            'p_bentuk_pemanfaatan', 'p_pihak_ketiga', 'p_tanggal_mulai', 
            'p_tanggal_selesai', 'p_nilai_kontribusi', 'p_status_pembayaran', 
            'p_path_bukti', 'p_keterangan'
        );
        $this->aset->refresh();
        session()->flash('success_pemanfaatan', 'Riwayat pemanfaatan berhasil ditambahkan.');
    }

    public function simpanDokumen()
    {
        if (Auth::user()->role_id != 1) return;

        $validated = $this->validate([
            'fileUpload' => 'required|file|mimes:pdf|max:10240', 
            'nama_dokumen' => 'required|string|max:255',
            'kategori_dokumen' => 'required|string',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        $path = $this->fileUpload->store('dokumen_pendukung/' . $this->aset->id, 'public');

        $this->aset->dokumen()->create([
            'nama_dokumen' => $validated['nama_dokumen'],
            'path_file' => $path,
            'kategori_dokumen' => $validated['kategori_dokumen'],
            'tanggal_kadaluarsa' => $validated['tanggal_kadaluarsa'],
        ]);

        $this->reset('fileUpload', 'nama_dokumen', 'kategori_dokumen', 'tanggal_kadaluarsa');
        $this->aset->refresh(); 
        session()->flash('success_dokumen', 'Dokumen PDF berhasil ditambahkan.');
    }


    public function openValidasiModal($status)
    {
        $this->validasiStatus = $status;
        $this->validasiCatatan = '';
        $this->showValidasiModal = true;
    }

    public function closeValidasiModal()
    {
        $this->showValidasiModal = false;
    }

    public function prosesValidasi()
    {
        if (Auth::user()->role_id != 2) return;

        $this->aset->update([
            'status_validasi' => $this->validasiStatus,
            'catatan_validasi' => $this->validasiCatatan,
            'divalidasi_oleh' => Auth::id(),
        ]);

        session()->flash('success_validasi', 'Status aset berhasil diubah menjadi: ' . $this->validasiStatus);
        $this->closeValidasiModal();
    }

    public function render()
    {
        return view('livewire.aset.detail-page');
    }
}