<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tanah_id
 * @property string $bentuk_pemanfaatan
 * @property string $pihak_ketiga
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $nilai_kontribusi
 * @property string $status_pembayaran
 * @property string|null $path_bukti
 * @property string|null $keterangan
 * @property int|null $diinput_oleh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\TanahKasDesa $tanah
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereBentukPemanfaatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereDiinputOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereNilaiKontribusi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah wherePathBukti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah wherePihakKetiga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereStatusPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereTanahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemanfaatanTanah whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PemanfaatanTanah extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'pemanfaatan_tanah';

    // Kolom yang boleh diisi (dari tambah_pemanfaatan.php)
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

    // Sesuai DB lama, kita hanya pakai created_at
    const UPDATED_AT = null;

    // Relasi: Riwayat ini milik 1 Aset
    public function tanah()
    {
        return $this->belongsTo(TanahKasDesa::class, 'tanah_id');
    }
}