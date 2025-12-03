<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ModalEditUser extends Component
{
    public $userId;
    public $user;
    public $roles;
    public $nama_lengkap;
    public $email;
    public $role_id;
    public $new_password;
    public $new_password_confirmation;
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::find($userId);
        $this->roles = Role::all();
        $this->nama_lengkap = $this->user->nama_lengkap;
        $this->email = $this->user->email;
        $this->role_id = $this->user->role_id;
    }

    /**
     * Fungsi untuk simpan perubahan data
     */
    public function updateData()
    {
        $validated = $this->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId, 
            'role_id' => 'required|exists:roles,id',
        ]);

        $this->user->update($validated);

        $this->dispatch('user-updated');
    }


    public function updatePassword()
    {
        $validated = $this->validate([
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $this->user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        $this->reset('new_password', 'new_password_confirmation');

        session()->flash('success_pass', 'Password user berhasil di-reset.');
    }

    public function render()
    {
        return view('livewire.admin.modal-edit-user');
    }
}