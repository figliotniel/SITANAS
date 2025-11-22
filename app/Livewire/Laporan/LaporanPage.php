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
    public $dateStart;
    public $dateEnd;

    // Reset pagination saat filter berubah
    public function updatingSearchTerm() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingFilterKondisi() { $this->resetPage(); }
    public function updatingDateStart() { $this->resetPage(); } // Tambahan agar reset saat tanggal berubah
    public function updatingDateEnd() { $this->resetPage(); }

    /**
     * Query Builder Pusat
     */
    private function buildQuery()
    {
        return TanahKasDesa::query()
            ->when($this->searchTerm, function($q) {
                $q->where(function($sub) {
                    $sub->where('kode_barang', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('nama_barang', 'like', '%'.$this->searchTerm.'%') // Tambah pencarian nama barang
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
            ->when($this->dateStart, function($q) {
                $q->whereDate('created_at', '>=', $this->dateStart);
            })
            ->when($this->dateEnd, function($q) {
                $q->whereDate('created_at', '<=', $this->dateEnd);
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

    // --- FUNGSI BARU: EXPORT CSV ---
    public function exportCsv()
    {
        $dataAset = $this->buildQuery()->get();

        if ($dataAset->isEmpty()) {
            session()->flash('error', 'Tidak ada data untuk di-export ke CSV.');
            return;
        }

        $fileName = 'Data-Aset-Sitanas-' . date('d-m-Y-His') . '.csv';

        // Header kolom untuk file CSV
        $columns = [
            'Kode Barang',
            'Nama Barang',
            'NUP',
            'Asal Perolehan',
            'Luas (m2)',
            'Harga Perolehan (Rp)',
            'Lokasi',
            'Kondisi',
            'Status Sertifikat',
            'Nomor Sertifikat',
            'Penggunaan',
            'Status Validasi',
            'Tanggal Input'
        ];

        // Callback stream agar tidak membebani memori server
        $callback = function() use($dataAset, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan BOM agar Excel bisa baca karakter UTF-8 dengan benar
            fputs($file, "\xEF\xBB\xBF"); 
            
            // Tulis Header
            fputcsv($file, $columns);

            // Tulis Data Baris per Baris
            foreach ($dataAset as $aset) {
                fputcsv($file, [
                    $aset->kode_barang,
                    $aset->nama_barang ?? '-', // Pastikan kolom ini ada di DB
                    $aset->nup,
                    $aset->asal_perolehan,
                    $aset->luas,            // Angka murni biar bisa dijumlah di Excel
                    $aset->harga_perolehan, // Angka murni
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

        // Return response stream CSV
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