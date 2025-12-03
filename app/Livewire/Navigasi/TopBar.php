<?php

namespace App\Livewire\Navigasi;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TopBar extends Component
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
        return view('livewire.navigasi.top-bar');
    }
}