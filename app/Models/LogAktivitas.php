<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $aksi
 * @property string|null $deskripsi
 * @property string $timestamp
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas whereAksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogAktivitas whereUserId($value)
 * @mixin \Eloquent
 */
class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';
    protected $fillable = ['user_id', 'aksi', 'deskripsi', 'timestamp'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}