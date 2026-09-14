<?php

namespace App\Models;

use App\Models\Concerns\AuditLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MstKaryawan extends Model
{
    use AuditLoggable;

    protected $table = 'mstkaryawan';

    protected $primaryKey = 'NIK';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'NIK',
        'Nama',
        'IDDept',
        'IDPerusahaan',
        'IDLokasi',
        'NIKKepalaBagian',
    ];

    /*
    |--------------------------------------------------------------------------
    | DEPARTEMEN
    |--------------------------------------------------------------------------
    */

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(
            MstDepartemen::class,
            'IDDept',
            'IDDept'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PERUSAHAAN
    |--------------------------------------------------------------------------
    */

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(
            MstPerusahaan::class,
            'IDPerusahaan',
            'IDPerusahaan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOKASI
    |--------------------------------------------------------------------------
    */

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(
            MstLokasi::class,
            'IDLokasi',
            'IDLokasi'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KEPALA BAGIAN
    |--------------------------------------------------------------------------
    |
    | Self-reference.
    |
    | Contoh:
    |
    | Budi.NIKKepalaBagian = 005
    |
    | maka:
    |
    | Budi->kepalaBagian
    |        ↓
    | MstKaryawan dengan NIK = 005
    |
    */

    public function kepalaBagian(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'NIKKepalaBagian',
            'NIK'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ANGGOTA / BAWAHAN
    |--------------------------------------------------------------------------
    |
    | Semua karyawan yang memiliki karyawan ini sebagai
    | Kepala Bagian.
    |
    */

    public function bawahan(): HasMany
    {
        return $this->hasMany(
            self::class,
            'NIKKepalaBagian',
            'NIK'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | USER / AKUN
    |--------------------------------------------------------------------------
    |
    | Satu karyawan dapat memiliki satu akun users.
    |
    */

    public function user(): HasOne
    {
        return $this->hasOne(
            User::class,
            'NIK',
            'NIK'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTASI ASSET
    |--------------------------------------------------------------------------
    */

    public function mutasi(): HasMany
    {
        return $this->hasMany(
            TrxMutasiAsset::class,
            'NIK',
            'NIK'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ASSET
    |--------------------------------------------------------------------------
    */

    public function assets(): HasMany
    {
        return $this->hasMany(
            MstAsset::class,
            'NIK',
            'NIK'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PABX ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    public function pabxAssignment(): HasMany
    {
        return $this->hasMany(
            TrxPabxAssignment::class,
            'NIK',
            'NIK'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: APAKAH KEPALA BAGIAN?
    |--------------------------------------------------------------------------
    */

    public function isKepalaBagian(): bool
    {
        return $this->user?->hasRole('kepala_bagian') ?? false;
    }
}
