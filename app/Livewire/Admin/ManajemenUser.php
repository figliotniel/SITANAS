<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManajemenUser extends Component
{
    public $users;
    public $roles;
    public $nama_lengkap;
    public $email;
    public $role_id;
    public $password;
    public $password_confirmation;
    public $showEditModal = false;
    public $editingUserId;

    public function mount()
    {
        if (auth()->user()->role_id != 1) {
            return redirect('/');
        }
        $this->loadData();
    }

    public function loadData()
    {
        $this->users = User::with('role')->get();
        $this->roles = Role::all();
    }

    public function simpanUserBaru()
    {
        $validated = $this->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'password' => Hash::make($validated['password']),
            'status' => 'aktif',
        ]);

        $this->reset('nama_lengkap', 'email', 'role_id', 'password', 'password_confirmation');
        $this->loadData();
        session()->flash('success_user', 'Akun baru berhasil dibuat.');
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);
        if ($user && $user->id != auth()->id()) {
            $user->status = ($user->status == 'aktif') ? 'nonaktif' : 'aktif';
            $user->save();
            $this->loadData();
        }
    }

    public function openEditModal($userId)
    {
        $this->editingUserId = $userId;
        $this->showEditModal = true;
    }

    #[On('user-updated')]
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingUserId = null;
        $this->loadData();
        session()->flash('success_user', 'Data user berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.manajemen-user');
    }
}