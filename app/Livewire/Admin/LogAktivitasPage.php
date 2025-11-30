<?php

namespace App\Livewire\Admin;

use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class LogAktivitasPage extends Component
{
    use WithPagination;
    public $search = '';
    public $filterAksi = '';
    public $filterDate = '';
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterAksi() { $this->resetPage(); }
    public function updatedFilterDate() { $this->resetPage(); }

    public function render()
    {
        $query = LogAktivitas::with(['user.role', 'subject'])
            ->latest();

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($u) {
                      $u->where('nama_lengkap', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if (!empty($this->filterAksi)) {
            $query->where('aksi', $this->filterAksi);
        }

        if (!empty($this->filterDate)) {
            $query->whereDate('created_at', $this->filterDate);
        }

        return view('livewire.admin.log-aktivitas-page', [
            'logs' => $query->paginate(15)
        ]);
    }
}