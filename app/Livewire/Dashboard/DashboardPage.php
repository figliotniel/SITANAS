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
    
    // Properti Modal Validasi
    public $showValidasiModal = false;
    public $validasiAsetId;
    public $validasiStatus;
    public $validasiCatatan = '';

    public function updatingSearchTerm() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

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
        $this->validasiCatatan = ''; // Reset catatan
        $this->showValidasiModal = true;
    }

    public function closeValidasiModal()
    {
        $this->showValidasiModal = false;
        $this->reset(['validasiAsetId', 'validasiStatus', 'validasiCatatan']);
    }

    public function prosesValidasi()
    {
        if (auth()->user()->role_id != 2) {
            session()->flash('error', 'Anda tidak memiliki hak akses untuk memvalidasi.');
            return;
        }

        $aset = TanahKasDesa::find($this->validasiAsetId);
        
        if ($aset) {
            $aset->update([
                'status_validasi' => $this->validasiStatus,
                'catatan_validasi' => $this->validasiCatatan,
                'divalidasi_oleh' => auth()->id(),
            ]);

            $pesan = $this->validasiStatus == 'Disetujui' ? 'Aset berhasil DISETUJUI.' : 'Aset berhasil DITOLAK.';
            session()->flash('success', $pesan);
            
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

        // Urutkan dari yang terbaru
        $aset = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.dashboard.dashboard-page', [
            'aset_tanah' => $aset
        ]);
    }
}