<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ItRequestApproval extends Model
{
    protected $table = 'it_request_approvals';
    protected $fillable = ['it_request_id', 'kepala_bagian_id', 'status', 'catatan', 'approved_at',];
    protected $casts = ['approved_at' => 'datetime',]; /* |-------------------------------------------------------------------------- | STATUS |-------------------------------------------------------------------------- */
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected'; /* |-------------------------------------------------------------------------- | IT REQUEST |-------------------------------------------------------------------------- */
    public function itRequest(): BelongsTo
    {
        return $this->belongsTo(ItRequest::class, 'it_request_id', 'IDRequest');
    } /* |-------------------------------------------------------------------------- | KEPALA BAGIAN |-------------------------------------------------------------------------- */
    public function kepalaBagian(): BelongsTo
    {
        return $this->belongsTo(MstKepalaBagian::class, 'kepala_bagian_id', 'id');
    }
}