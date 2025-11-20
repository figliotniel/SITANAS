<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tanah_id
 * @property string $nama_dokumen
 * @property string|null $kategori_dokumen
 * @property string|null $tanggal_kadaluarsa
 * @property string $path_file
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\TanahKasDesa $tanah
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung whereKategoriDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung whereNamaDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung wherePathFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung whereTanahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung whereTanggalKadaluarsa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenPendukung whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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