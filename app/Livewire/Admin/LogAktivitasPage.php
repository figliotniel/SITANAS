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

    // Properti Filter
    public $search = '';
    public $filterAksi = '';
    public $dateStart = '';
    public $dateEnd = '';

    // Reset pagination ke halaman 1 setiap kali filter berubah
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterAksi() { $this->resetPage(); }
    public function updatedDateStart() { $this->resetPage(); }
    public function updatedDateEnd() { $this->resetPage(); }

    public function render()
    {
        $query = LogAktivitas::with(['user', 'subject']) // Load relasi agar performa cepat
            ->latest(); // Urutkan dari yang terbaru

        // 1. Logika Pencarian (Search)
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('deskripsi', 'like', '%' . $this->search . '%') // Cari di deskripsi
                  ->orWhereHas('user', function($u) { // Cari di nama user
                      $u->where('nama_lengkap', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // 2. Filter Berdasarkan Jenis Aksi
        if (!empty($this->filterAksi)) {
            $query->where('aksi', $this->filterAksi);
        }

        // 3. Filter Rentang Tanggal
        if (!empty($this->dateStart)) {
            $query->whereDate('created_at', '>=', $this->dateStart);
        }
        
        if (!empty($this->dateEnd)) {
            $query->whereDate('created_at', '<=', $this->dateEnd);
        }

        return view('livewire.admin.log-aktivitas-page', [
            'logs' => $query->paginate(15)
        ]);
    }
}