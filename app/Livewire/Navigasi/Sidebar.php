<?php

namespace App\Livewire\Navigasi;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilDesa;

class Sidebar extends Component
{
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        $desa = ProfilDesa::getProfil();

        return view('livewire.navigasi.sidebar', [
            'desa' => $desa,
        ]);
    }
}
