<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
class MstKepalaBagian extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = 'mstkepalabagian';
    protected $fillable = ['name', 'email', 'password',];
    protected $hidden = ['password', 'remember_token',];
    protected function casts(): array
    {
        return ['password' => 'hashed',];
    } /* |-------------------------------------------------------------------------- | USERS |-------------------------------------------------------------------------- | | Semua user yang berada di bawah Kepala Bagian ini. | */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'kepala_bagian_id', 'id');
    } /* |-------------------------------------------------------------------------- | APPROVALS |-------------------------------------------------------------------------- */
    public function approvals(): HasMany
    {
        return $this->hasMany(ItRequestApproval::class, 'kepala_bagian_id', 'id');
    }
}