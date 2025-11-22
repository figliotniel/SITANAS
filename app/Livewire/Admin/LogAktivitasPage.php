<?php

namespace App\Livewire\Admin;

use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithPagination;

class LogAktivitasPage extends Component
{
    use WithPagination;

    public $search = '';
    public $filterAksi = '';
    public $dateStart;
    public $dateEnd;

    public function render()
    {
        $query = LogAktivitas::with(['user', 'subject']) // Eager load relasi biar cepat
            ->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($u) {
                      $u->where('nama_lengkap', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->filterAksi) {
            $query->where('aksi', $this->filterAksi);
        }

        if ($this->dateStart) {
            $query->whereDate('created_at', '>=', $this->dateStart);
        }
        if ($this->dateEnd) {
            $query->whereDate('created_at', '<=', $this->dateEnd);
        }

        return view('livewire.admin.log-aktivitas-page', [
            'logs' => $query->paginate(15)
        ])->layout('layouts.app');
    }

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterAksi() { $this->resetPage(); }
}