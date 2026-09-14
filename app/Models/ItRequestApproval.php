<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItRequestApproval extends Model
{
    protected $table = 'it_request_approvals';

    protected $fillable = [
        'it_request_id',
        'approver_id',
        'status',
        'catatan',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    /*
    |--------------------------------------------------------------------------
    | IT REQUEST
    |--------------------------------------------------------------------------
    */

    public function itRequest(): BelongsTo
    {
        return $this->belongsTo(
            ItRequest::class,
            'it_request_id',
            'IDRequest'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVER
    |--------------------------------------------------------------------------
    |
    | User yang melakukan approval.
    |
    | Dalam kasus saat ini user tersebut biasanya memiliki role:
    |
    | kepala_bagian
    |
    */

    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approver_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: KEPALA BAGIAN
    |--------------------------------------------------------------------------
    |
    | Tidak menggunakan relasi mstkepalabagian lagi.
    |
    | Jika perlu memastikan approver adalah Kepala Bagian:
    |
    | $approval->isKepalaBagian()
    |
    */

    public function isKepalaBagian(): bool
    {
        return $this->approver?->hasRole('kepala_bagian') ?? false;
    }
}
