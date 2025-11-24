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

    // Filter properties
    public $searchTerm = '';
    public $filterStatus = '';
    public $filterKondisi = '';
    public $filterDate = ''; // <--- Ganti variable dateStart/End jadi satu

    // Reset pagination saat filter berubah
    public function updatingSearchTerm() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingFilterKondisi() { $this->resetPage(); }
    public function updatingFilterDate() { $this->resetPage(); } // Update method

    /**
     * Query Builder Pusat
     */
    private function buildQuery()
    {
        return TanahKasDesa::query()
            ->when($this->searchTerm, function($q) {
                $q->where(function($sub) {
                    $sub->where('kode_barang', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('nama_barang', 'like', '%'.$this->searchTerm.'%')
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
            // Filter Tanggal Tunggal (Cari data pada tanggal spesifik)
            ->when($this->filterDate, function($q) {
                $q->whereDate('created_at', $this->filterDate);
            })
            ->orderBy('created_at', 'desc');
    }

    public function exportPdf()
    {
        $dataAset = $this->buildQuery()->get();

        if ($dataAset->isEmpty()) {
            session()->flash('error', 'Tidak ada data yang sesuai filter untuk diunduh.');
            return;
        }

        $pdf = Pdf::loadView('pdf.laporan-aset', ['dataAset' => $dataAset]);
        $pdf->setPaper('a4', 'landscape');

        $fileName = 'Laporan-Aset-' . date('d-m-Y-His') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $fileName);
    }

    public function exportCsv()
    {
        $dataAset = $this->buildQuery()->get();

        if ($dataAset->isEmpty()) {
            session()->flash('error', 'Tidak ada data untuk di-export ke CSV.');
            return;
        }

        $fileName = 'Data-Aset-Sitanas-' . date('d-m-Y-His') . '.csv';

        $columns = [
            'Kode Barang', 'Nama Barang', 'NUP', 'Asal Perolehan', 
            'Luas (m2)', 'Harga Perolehan (Rp)', 'Lokasi', 'Kondisi', 
            'Status Sertifikat', 'Nomor Sertifikat', 'Penggunaan', 
            'Status Validasi', 'Tanggal Input'
        ];

        $callback = function() use($dataAset, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM untuk Excel
            fputcsv($file, $columns);

            foreach ($dataAset as $aset) {
                fputcsv($file, [
                    $aset->kode_barang,
                    $aset->nama_barang ?? '-',
                    $aset->nup,
                    $aset->asal_perolehan,
                    $aset->luas,
                    $aset->harga_perolehan,
                    $aset->lokasi,
                    $aset->kondisi,
                    $aset->status_sertifikat,
                    $aset->nomor_sertifikat,
                    $aset->penggunaan,
                    $aset->status_validasi,
                    $aset->created_at->format('Y-m-d'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ]);
    }

    public function render()
    {
        return view('livewire.laporan.laporan-page', [
            'aset_tanah' => $this->buildQuery()->paginate(10),
            'total_aset' => $this->buildQuery()->count()
        ]);
    }
}