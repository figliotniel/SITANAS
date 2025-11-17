<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination; // Penting untuk paginasi di render()

#[Layout('layouts.app')]
class LaporanPage extends Component
{
    use WithPagination;

    // Properti untuk Filter dan Paginasi
    public $searchTerm = '';
    public $filterStatus = 'Disetujui'; // Default: Hanya tampilkan yang Disetujui
    public $perPage = 10;
    
    // Properti untuk menangani error notifikasi
    public $errorOccurred = false;


    /**
     * Helper untuk membuat query data aset berdasarkan filter
     */
    private function queryData()
    {
        $query = TanahKasDesa::query()
                    ->where('status_validasi', $this->filterStatus)
                    ->orderBy('tanggal_perolehan', 'desc');

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('kode_barang', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('asal_perolehan', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('lokasi', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        return $query;
    }


    /**
     * Method Ekspor PDF (Gabungan fungsionalitas, menghapus duplikasi)
     */
    public function exportPdf()
    {
        try {
            // Ambil semua data yang sudah difilter (tanpa paginasi)
            $aset_tanah = $this->queryData()->get();

            // Siapkan data untuk dikirim ke file Blade PDF
            $data = ['aset_tanah' => $aset_tanah];

            // Load view dan set orientasi kertas
            $pdf = Pdf::loadView('pdf.laporan_aset', $data)
                      ->setPaper('a4', 'landscape'); // Set kertas A4 landscape

            // Download PDF
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'laporan-inventaris-tanah-'.date('Y-m-d').'.pdf');

        } catch (\Exception $e) {
            Log::error('Gagal membuat PDF Laporan: ' . $e->getMessage());
            $this->errorOccurred = true;
            session()->flash('error', 'Gagal membuat PDF. Silakan coba lagi atau hubungi administrator.');
        }
    }

    /**
     * Method Render (Hanya ada satu, menangani tampilan web)
     */
    public function render()
    {
        // Ambil data dengan paginasi untuk tampilan web
        $aset_tanah_paginated = $this->queryData()->paginate($this->perPage);

        // Reset paginasi saat filter berubah
        $this->resetPage();

        return view('livewire.laporan.laporan-page', [
            'aset_tanah' => $aset_tanah_paginated, // Ubah nama variabel untuk paginasi
            'total_aset' => $this->queryData()->count(),
        ]);
    }
}