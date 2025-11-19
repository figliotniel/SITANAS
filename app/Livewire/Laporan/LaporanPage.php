<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class LaporanPage extends Component
{
    use WithPagination;

    // Filter
    public $searchTerm = '';
    public $filterStatus = '';  // Bisa: 'Diproses', 'Disetujui', 'Ditolak', atau '' (Semua)
    public $filterKondisi = ''; // Bisa: 'Baik', 'Rusak Berat', dll

    // Reset halaman ke 1 jika filter berubah (UX Standard)
    public function updatingSearchTerm() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingFilterKondisi() { $this->resetPage(); }

    /**
     * [OPTIMASI] Fungsi Pusat Query
     * Dipakai oleh render() dan downloadPdf() agar hasil konsisten
     */
    private function buildQuery()
    {
        return TanahKasDesa::query()
            ->when($this->searchTerm, function($q) {
                $q->where(function($sub) {
                    $sub->where('kode_barang', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('lokasi', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('asal_perolehan', 'like', '%'.$this->searchTerm.'%');
                });
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status_validasi', $this->filterStatus);
            })
            ->when($this->filterKondisi, function($q) {
                $q->where('kondisi', $this->filterKondisi);
            })
            ->orderBy('created_at', 'desc'); // Urutkan dari yang terbaru
    }

    public function downloadPdf()
    {
        // 1. Ambil data menggunakan Query yang sama dengan tabel (Tanpa Paginasi)
        $dataAset = $this->buildQuery()->get();

        // 2. Cek jika data kosong
        if ($dataAset->isEmpty()) {
            session()->flash('error', 'Tidak ada data yang sesuai filter untuk diunduh.');
            return;
        }

        // 3. Load View PDF
        $pdf = Pdf::loadView('pdf.laporan-aset', ['dataAset' => $dataAset]);
        $pdf->setPaper('a4', 'landscape');

        // 4. Buat nama file dinamis sesuai filter
        $statusLabel = $this->filterStatus ? $this->filterStatus : 'Semua-Status';
        $fileName = 'Laporan-Aset-' . $statusLabel . '-' . date('d-m-Y') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $fileName);
    }

    public function render()
    {
        // Gunakan Query yang sama, tapi pakai Paginasi untuk tampilan web
        $aset = $this->buildQuery()->paginate(10);

        return view('livewire.laporan.laporan-page', [
            'aset_tanah' => $aset,
            'total_aset' => $this->buildQuery()->count() // Hitung total sesuai filter
        ]);
    }
}