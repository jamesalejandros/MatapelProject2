<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItRequest extends Model
{
    protected $table = 'it_requests';

    protected $primaryKey = 'IDRequest';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'NoRequest',
        'UserPemohonID',
        'Permintaan',
        'Keterangan',
        'UserPenyelesaiID',
        'Status',
        'RencanaSelesai',
        'TanggalSelesai',
        'CatatanPenyelesaian',

        /*
        |--------------------------------------------------------------------------
        | SERAH TERIMA
        |--------------------------------------------------------------------------
        */

        'SerahTerima',
        'TanggalSerahTerima',
    ];

    protected $casts = [
        'RencanaSelesai' => 'date',

        'TanggalSelesai' => 'datetime',

        /*
        |--------------------------------------------------------------------------
        | SERAH TERIMA
        |--------------------------------------------------------------------------
        */

        'SerahTerima' => 'boolean',

        'TanggalSerahTerima' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | PEMOHON
    |--------------------------------------------------------------------------
    */

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'UserPemohonID',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENYELESAI
    |--------------------------------------------------------------------------
    */

    public function penyelesai(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'UserPenyelesaiID',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | JENIS PERMINTAAN
    |--------------------------------------------------------------------------
    |
    | Satu request dapat memiliki banyak jenis permintaan.
    |
    */

    public function jenisPermintaan(): BelongsToMany
    {
        return $this->belongsToMany(
            MstJenisPermintaan::class,
            'it_request_jenis_permintaan',
            'it_request_id',
            'jenis_permintaan_id',
            'IDRequest',
            'id'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | ASSET
    |--------------------------------------------------------------------------
    |
    | Satu request dapat memiliki banyak asset.
    |
    */

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(
            MstAsset::class,
            'it_request_assets',
            'it_request_id',
            'NoAssetIT',
            'IDRequest',
            'NoAssetIT'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATED USERS
    |--------------------------------------------------------------------------
    */

    public function relatedUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'it_request_related_users',
            'it_request_id',
            'user_id',
            'IDRequest',
            'id'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVAL
    |--------------------------------------------------------------------------
    |
    | Saat ini satu request memiliki satu approval Kepala Bagian.
    |
    */

    public function approval(): HasOne
    {
        return $this->hasOne(
            ItRequestApproval::class,
            'it_request_id',
            'IDRequest'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: APPROVED
    |--------------------------------------------------------------------------
    */

    public function isApproved(): bool
    {
        return $this->approval?->status ===
            ItRequestApproval::STATUS_APPROVED;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: REJECTED
    |--------------------------------------------------------------------------
    */

    public function isRejected(): bool
    {
        return $this->approval?->status ===
            ItRequestApproval::STATUS_REJECTED;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: PENDING
    |--------------------------------------------------------------------------
    */

    public function isApprovalPending(): bool
    {
        return $this->approval?->status ===
            ItRequestApproval::STATUS_PENDING;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: SELESAI
    |--------------------------------------------------------------------------
    */

    public function isSelesai(): bool
    {
        return in_array(
            strtolower((string) $this->Status),
            [
                'selesai',
                'completed',
                'done',
            ],
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: SUDAH SERAH TERIMA
    |--------------------------------------------------------------------------
    */

    public function sudahSerahTerima(): bool
    {
        return $this->SerahTerima === true;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: MENUNGGU SERAH TERIMA
    |--------------------------------------------------------------------------
    */

    public function menungguSerahTerima(): bool
    {
        return $this->isSelesai()
            && $this->SerahTerima !== true;
    }
}
