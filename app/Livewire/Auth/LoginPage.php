<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

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
            
            // 4. Regenerate session (keamanan)
            request()->session()->regenerate();

            // 5. Redirect ke dashboard (nanti kita buat di Langkah 5)
            return redirect()->intended('/'); // Redirect ke halaman utama
        
        }

        session()->flash('error', 'Kombinasi Email atau Password salah, atau akun Anda tidak aktif.');
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}