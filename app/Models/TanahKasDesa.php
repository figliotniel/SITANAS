<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string|null $kode_barang
 * @property string|null $nup
 * @property string $asal_perolehan
 * @property string|null $tanggal_perolehan
 * @property string|null $harga_perolehan
 * @property string|null $bukti_perolehan
 * @property string|null $nomor_sertifikat
 * @property string|null $tanggal_sertifikat
 * @property string|null $status_sertifikat
 * @property string $luas
 * @property string|null $lokasi
 * @property string|null $penggunaan
 * @property string|null $koordinat
 * @property string $kondisi
 * @property string|null $batas_utara
 * @property string|null $batas_timur
 * @property string|null $batas_selatan
 * @property string|null $batas_barat
 * @property string|null $keterangan
 * @property string $status_validasi
 * @property string|null $catatan_validasi
 * @property int|null $diinput_oleh
 * @property int|null $divalidasi_oleh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $diinput_oleh_user
 * @property-read \App\Models\User|null $divalidasi_oleh_user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DokumenPendukung> $dokumen
 * @property-read int|null $dokumen_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PemanfaatanTanah> $pemanfaatan
 * @property-read int|null $pemanfaatan_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereAsalPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereBatasBarat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereBatasSelatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereBatasTimur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereBatasUtara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereBuktiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereCatatanValidasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereDiinputOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereDivalidasiOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereHargaPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereKoordinat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereLuas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereNomorSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa wherePenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereStatusSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereStatusValidasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereTanggalPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereTanggalSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TanahKasDesa withoutTrashed()
 * @mixin \Eloquent
 */
class TanahKasDesa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tanah_kas_desa'; 
    protected $fillable = [
        'kode_barang', 'nup', 'asal_perolehan', 'tanggal_perolehan', 
        'harga_perolehan', 'bukti_perolehan', 'nomor_sertifikat', 
        'tanggal_sertifikat', 'status_sertifikat', 'luas', 'lokasi', 
        'penggunaan', 'koordinat', 'kondisi', 'batas_utara', 'batas_timur', 
        'batas_selatan', 'batas_barat', 'keterangan', 'diinput_oleh', 'status_validasi',
        'catatan_validasi', 'divalidasi_oleh',
    ];

        public function pemanfaatan()
    {
        // Urutkan berdasarkan yang paling baru
        return $this->hasMany(PemanfaatanTanah::class, 'tanah_id')
                    ->orderBy('tanggal_mulai', 'desc');
    }
        public function dokumen()
    {
        return $this->hasMany(DokumenPendukung::class, 'tanah_id');
    }

        public function diinput_oleh_user()
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }
    public function divalidasi_oleh_user()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }
}