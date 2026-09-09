<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles; /** * ========================================================== * MASS ASSIGNMENT * ========================================================== */
    protected $fillable = ['name', 'email', 'NIK', 'password', 'kepala_bagian_id',]; /** * ========================================================== * HIDDEN * ========================================================== */
    protected $hidden = ['password', 'remember_token',]; /** * ========================================================== * CASTS * ========================================================== */
    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed',];
    } /** * ========================================================== * KARYAWAN * ========================================================== */
    public function karyawan(): HasOne
    {
        return $this->hasOne(MstKaryawan::class, 'NIK', 'NIK');
    } /** * ========================================================== * KEPALA BAGIAN * ========================================================== */
    public function kepalaBagian(): BelongsTo
    {
        return $this->belongsTo(MstKepalaBagian::class, 'kepala_bagian_id', 'id');
    } /** * ========================================================== * REQUEST SEBAGAI PEMOHON * ========================================================== */
    public function itRequests(): HasMany
    {
        return $this->hasMany(ItRequest::class, 'UserPemohonID', 'id');
    } /** * ========================================================== * REQUEST SEBAGAI PENYELESAI * ========================================================== */
    public function itRequestsAsPenyelesai(): HasMany
    {
        return $this->hasMany(ItRequest::class, 'UserPenyelesaiID', 'id');
    } /** * ========================================================== * REQUEST TERKAIT * ========================================================== */
    public function relatedItRequests(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ItRequest::class, 'it_request_related_users', 'user_id', 'it_request_id', 'id', 'IDRequest')->withTimestamps();
    }
}