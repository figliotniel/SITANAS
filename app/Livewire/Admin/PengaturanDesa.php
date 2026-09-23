<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ProfilDesa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Pengaturan Desa')]
class PengaturanDesa extends Component
{
    public $nama_desa, $kode_desa, $kecamatan, $kabupaten, $provinsi, $kode_pos;
    public $alamat_kantor, $telepon, $email;
    public $nama_kepala_desa, $nip_kepala_desa;

    public function mount()
    {
        $profil = ProfilDesa::getProfil();
        if ($profil) {
            $this->nama_desa = $profil->nama_desa;
            $this->kode_desa = $profil->kode_desa;
            $this->kecamatan = $profil->kecamatan;
            $this->kabupaten = $profil->kabupaten;
            $this->provinsi = $profil->provinsi;
            $this->kode_pos = $profil->kode_pos;
            $this->alamat_kantor = $profil->alamat_kantor;
            $this->telepon = $profil->telepon;
            $this->email = $profil->email;
            $this->nama_kepala_desa = $profil->nama_kepala_desa;
            $this->nip_kepala_desa = $profil->nip_kepala_desa;
        }
    }

    public function simpan()
    {
        $this->validate([
            'nama_desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'nama_kepala_desa' => 'required|string|max:255',
        ]);

        $profil = ProfilDesa::first() ?? new ProfilDesa();
        
        $profil->fill([
            'nama_desa' => $this->nama_desa,
            'kode_desa' => $this->kode_desa,
            'kecamatan' => $this->kecamatan,
            'kabupaten' => $this->kabupaten,
            'provinsi' => $this->provinsi,
            'kode_pos' => $this->kode_pos,
            'alamat_kantor' => $this->alamat_kantor,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'nama_kepala_desa' => $this->nama_kepala_desa,
            'nip_kepala_desa' => $this->nip_kepala_desa,
        ]);
        
        $profil->save();
        
        session()->flash('success', 'Profil desa berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.pengaturan-desa');
    }
}
