<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\LogAktivitas;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class LogAktivitasPage extends Component
{
    use WithPagination;

    public function mount()
    {
        // Keamanan: Hanya Admin (Role 1) yang boleh lihat log
        if (auth()->user()->role_id != 1) {
            return redirect('/');
        }
    }

    public function render()
    {
        // Ambil data log, urutkan waktu terbaru, load relasi user
        $logs = LogAktivitas::with('user')
                    ->orderBy('timestamp', 'desc')
                    ->paginate(15);

        return view('livewire.admin.log-aktivitas-page', [
            'logs' => $logs
        ]);
    }
}