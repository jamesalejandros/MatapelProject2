<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItRequestRelatedUserNote extends Model
{
    protected $table = 'it_request_related_user_notes';

    protected $fillable = [
        'it_request_id',
        'user_id',
        'catatan',
    ];

    /*
    |--------------------------------------------------------------------------
    | REQUEST
    |--------------------------------------------------------------------------
    */

    public function request(): BelongsTo
    {
        return $this->belongsTo(
            ItRequest::class,
            'it_request_id',
            'IDRequest'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }
}
