<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    protected $guarded = ['id'];

    public static function getProfil()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'nama_desa' => 'Ngestiharjo',
                'kode_desa' => '34.02.15.2001',
                'kecamatan' => 'Kasihan',
                'kabupaten' => 'Bantul',
                'provinsi' => 'D.I. Yogyakarta',
                'kode_pos' => '55182',
                'alamat_kantor' => 'Jl. Soragan No. 1, Ngestiharjo, Kasihan, Bantul',
                'telepon' => '(0274) 378123',
                'email' => 'kalurahan.ngestiharjo@bantulkab.go.id',
                'nama_kepala_desa' => 'H. Fathoni Ahad, S.H.',
                'nip_kepala_desa' => '-',
            ]
        );
    }
}
