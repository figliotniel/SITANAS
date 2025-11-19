<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TanahKasDesa;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ArsipAset extends Component
{
    use WithPagination;

    public function mount()
    {
        if (auth()->user()->role_id != 1) {
            return redirect('/');
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
        $asetArsip = TanahKasDesa::onlyTrashed()->paginate(10);

        return view('livewire.admin.arsip-aset', [
            'asetArsip' => $asetArsip
        ]);
    }
}