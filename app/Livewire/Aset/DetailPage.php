<?php

namespace App\Livewire\Aset;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.app')]
class DetailPage extends Component
{
    use WithFileUploads;
    public TanahKasDesa $aset;
    public $p_pihak_ketiga;
    public $p_bentuk_pemanfaatan = 'Sewa';
    public $p_tanggal_mulai;
    public $p_tanggal_selesai;
    public $p_nilai_kontribusi;
    public $p_status_pembayaran = 'Belum Lunas';
    public $p_path_bukti;
    public $p_keterangan;

    public function mount(TanahKasDesa $aset)
    {
        $this->aset = $aset->load(['pemanfaatan', 'diinput_oleh_user', 'divalidasi_oleh_user']);
    }

    public function simpanPemanfaatan()
    {
        // 1. Cek apakah user adalah Admin (Role ID 1)
        if (Auth::user()->role_id != 1) {
            session()->flash('error', 'Akses Ditolak: Hanya Admin yang boleh menambah data.');
            return;
        }

        // 2. Validasi Input
        $validated = $this->validate([
            'p_pihak_ketiga'       => 'required|string|max:255',
            'p_bentuk_pemanfaatan' => 'required|string',
            'p_tanggal_mulai'      => 'required|date',
            'p_tanggal_selesai'    => 'required|date|after_or_equal:p_tanggal_mulai',
            'p_nilai_kontribusi'   => 'required|numeric|min:0',
            'p_status_pembayaran'  => 'required|string',
            'p_path_bukti'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // Maks 5MB
            'p_keterangan'         => 'nullable|string',
        ], [
            'p_tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'p_nilai_kontribusi.required' => 'Nilai kontribusi wajib diisi (isi 0 jika gratis).',
        ]);

        // 3. Proses Upload Bukti (Jika ada)
        $pathBukti = null;
        if ($this->p_path_bukti) {
            $pathBukti = $this->p_path_bukti->store('bukti_pemanfaatan/' . $this->aset->id, 'public');
        }

        // 4. Simpan ke Database
        $this->aset->pemanfaatan()->create([
            'pihak_ketiga'       => $validated['p_pihak_ketiga'],
            'bentuk_pemanfaatan' => $validated['p_bentuk_pemanfaatan'],
            'tanggal_mulai'      => $validated['p_tanggal_mulai'],
            'tanggal_selesai'    => $validated['p_tanggal_selesai'],
            'nilai_kontribusi'   => $validated['p_nilai_kontribusi'],
            'status_pembayaran'  => $validated['p_status_pembayaran'],
            'path_bukti'         => $pathBukti,
            'keterangan'         => $validated['p_keterangan'],
            'diinput_oleh'       => Auth::id(),
        ]);

        // 5. Reset Form agar kosong kembali
        $this->reset([
            'p_pihak_ketiga', 'p_bentuk_pemanfaatan', 'p_tanggal_mulai', 
            'p_tanggal_selesai', 'p_nilai_kontribusi', 'p_status_pembayaran', 
            'p_path_bukti', 'p_keterangan'
        ]);

        // 6. Refresh data aset agar tabel terupdate otomatis
        $this->aset->refresh();
        session()->flash('success', 'Data pemanfaatan berhasil disimpan.');
    }

    public function exportPdf()
    {
        if (!$this->aset) return;
        
        $pdf = Pdf::loadView('pdf.detail-aset', ['aset' => $this->aset]);
        $pdf->setPaper('a4', 'portrait');

        $namaFile = 'Detail-Aset-' . ($this->aset->kode_barang ?? 'X') . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $namaFile);
    }

    public function render()
    {
        return view('livewire.aset.detail-page');
    }
}