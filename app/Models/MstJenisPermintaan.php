<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class MstJenisPermintaan extends Model
{
    protected $table = 'mstjenispermintaan';
    protected $fillable = ['name', 'keterangan', 'is_active',];
    protected $casts = ['is_active' => 'boolean',]; /* |-------------------------------------------------------------------------- | IT REQUESTS |-------------------------------------------------------------------------- */
    public function itRequests(): BelongsToMany
    {
        return $this->belongsToMany(ItRequest::class, 'it_request_jenis_permintaan', 'jenis_permintaan_id', 'it_request_id', 'id', 'IDRequest')->withTimestamps();
    }
}