<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class DashboardPage extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $filterStatus = '';
    public $showValidasiModal = false;
    public $validasiAsetId;
    public $validasiStatus;
    public $validasiCatatan = '';

    public function updatingSearchTerm() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    // Fungsi Arsipkan (dari langkah 8, jangan diubah)
    public function arsipkan($id)
    {
        $aset = TanahKasDesa::find($id);
        if ($aset) {
            $aset->delete();
            session()->flash('success', 'Data aset berhasil diarsipkan.');
        }
    }
    public function openValidasiModal($id, $status)
    {
        $this->validasiAsetId = $id;
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
        if (auth()->user()->role_id != 2) {
            return;
        }

        $aset = TanahKasDesa::find($this->validasiAsetId);
        if ($aset) {
            $aset->update([
                'status_validasi' => $this->validasiStatus,
                'catatan_validasi' => $this->validasiCatatan,
                'divalidasi_oleh' => auth()->user(),
            ]);

            session()->flash('success', 'Aset berhasil divalidasi.');
            $this->closeValidasiModal();
        }
    }

    public function render()
    {
        $query = TanahKasDesa::query()
            ->when($this->searchTerm, function($q) {
                $q->where('kode_barang', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('asal_perolehan', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('lokasi', 'like', '%'.$this->searchTerm.'%');
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status_validasi', $this->filterStatus);
            });

        $aset = $query->paginate(10);

        return view('livewire.dashboard.dashboard-page', [
            'aset_tanah' => $aset
        ]);
    }
}