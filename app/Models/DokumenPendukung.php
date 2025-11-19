<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPendukung extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pendukung';

    protected $fillable = [
        'tanah_id',
        'nama_dokumen',
        'kategori_dokumen', 
        'path_file',        
        'tanggal_kadaluarsa',
        'tipe_file', 
        'diinput_oleh' 
    ];

    
    public function tanah()
    {
        return $this->belongsTo(TanahKasDesa::class, 'tanah_id');
    }
}