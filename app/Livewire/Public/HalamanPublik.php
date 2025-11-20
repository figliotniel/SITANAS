<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Livewire\WithPagination;

// UBAH DARI 'layouts.app' MENJADI 'layouts.public'
#[Layout('layouts.public')] 
class HalamanPublik extends Component
{
    use WithPagination;

    public $search = ''; 

    public function render()
    {
        $query = TanahKasDesa::where('status_validasi', 'Disetujui');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('lokasi', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('penggunaan', 'like', '%' . $this->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            });
        }

        $dataAset = $query->orderBy('updated_at', 'desc')->paginate(12);

        return view('livewire.public.halaman-publik', [
            'aset' => $dataAset
        ]);
    }
}