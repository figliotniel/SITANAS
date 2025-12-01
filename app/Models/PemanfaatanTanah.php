<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemanfaatanTanah extends Model
{
    use HasFactory;

    protected $table = 'pemanfaatan_tanah';

    protected $fillable = [
        'tanah_id',
        'bentuk_pemanfaatan',
        'pihak_ketiga',
        'tanggal_mulai',
        'tanggal_selesai',
        'nilai_kontribusi',
        'status_pembayaran',
        'path_bukti',
        'keterangan',
        'diinput_oleh',
    ];

    const UPDATED_AT = null;


    public function tanah()
    {
        return $this->belongsTo(TanahKasDesa::class, 'tanah_id');
    }
}