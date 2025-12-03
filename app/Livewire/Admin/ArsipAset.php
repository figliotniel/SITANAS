<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\TanahKasDesa;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Arsip Aset')]
class ArsipAset extends Component
{
    use WithPagination;

    public function mount()
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman arsip.');
        }
    }

    public function pulihkan($id)
    {
        $aset = TanahKasDesa::onlyTrashed()->find($id);

        if ($aset) {
            $aset->restore();
            session()->flash('success', 'Data aset berhasil dipulihkan.'); 
        }
    }

    public function hapusPermanen($id)
    {
        $aset = TanahKasDesa::onlyTrashed()->find($id);

        if ($aset) {
            $aset->forceDelete();
            session()->flash('success', 'Data aset berhasil dihapus permanen.');
        }
    }

    public function render()
    {
        return view('livewire.admin.arsip-aset', [
            'asetArsip' => TanahKasDesa::onlyTrashed()->latest('deleted_at')->paginate(10)
        ]);
    }
}