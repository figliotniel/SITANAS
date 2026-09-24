<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use App\Models\ProfilDesa;
use Livewire\WithPagination;

#[Layout('layouts.public')] 
class HalamanPublik extends Component
{
    use WithPagination;

    public $search = ''; 
    public $selectedAset = null;
    public $showModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function bukaDetail($id)
    {
        $this->selectedAset = TanahKasDesa::with('pemanfaatan')
            ->where('status_validasi', 'Disetujui')
            ->find($id);

        if ($this->selectedAset) {
            $this->showModal = true;
            $this->dispatch('open-public-map', [
                'koordinat' => $this->selectedAset->koordinat,
                'lokasi'    => $this->selectedAset->lokasi,
                'luas'      => number_format($this->selectedAset->luas, 0, ',', '.') . ' m²',
            ]);
        }
    }

    public function tutupDetail()
    {
        $this->showModal = false;
        $this->selectedAset = null;
    }

    public function render()
    {
        $query = TanahKasDesa::where('status_validasi', 'Disetujui');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('lokasi', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('penggunaan', 'like', '%' . $this->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            });
        }

        $dataAset = $query->orderBy('updated_at', 'desc')->paginate(12);

        // Ringkasan untuk transparansi publik
        $baseQuery = TanahKasDesa::where('status_validasi', 'Disetujui');
        $stats = [
            'totalAset'          => (clone $baseQuery)->count(),
            'totalLuas'          => (clone $baseQuery)->sum('luas'),
            'totalBersertifikat' => (clone $baseQuery)->where('status_sertifikat', 'like', 'Sertifikat%')->count(),
        ];

        $desa = ProfilDesa::getProfil();

        return view('livewire.public.halaman-publik', [
            'aset'  => $dataAset,
            'stats' => $stats,
            'desa'  => $desa,
        ]);
    }
}