<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use App\Models\ProfilDesa;

#[Layout('layouts.app')]
class LoginPage extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        // 1. Validasi input
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['status'] = 'aktif';

        if (Auth::attempt($credentials)) {
            if (request()->hasSession()) {
                request()->session()->regenerate();
            }

            return redirect()->intended('/');
        }

        session()->flash('error', 'Kombinasi Email atau Password salah, atau akun Anda tidak aktif.');
    }

    public function render()
    {
        $desa = ProfilDesa::getProfil();

        return view('livewire.auth.login-page', [
            'desa' => $desa,
        ]);
    }
}