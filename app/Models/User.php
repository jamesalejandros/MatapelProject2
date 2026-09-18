<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'NIK',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | KARYAWAN
    |--------------------------------------------------------------------------
    |
    | users.NIK -> mstkaryawan.NIK
    |
    */

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(
            MstKaryawan::class,
            'NIK',
            'NIK'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KEPALA BAGIAN
    |--------------------------------------------------------------------------
    |
    | Tidak lagi mengambil dari users.kepala_bagian_id.
    |
    | Relasi ini berasal dari:
    |
    | users
    |   ↓
    | karyawan
    |   ↓
    | NIKKepalaBagian
    |   ↓
    | kepalaBagian
    |   ↓
    | user
    |
    */

    public function kepalaBagian(): ?User
    {
        return $this->karyawan?->kepalaBagian?->user;
    }

    /*
    |--------------------------------------------------------------------------
    | BAWAHAN
    |--------------------------------------------------------------------------
    |
    | Jika user adalah Kepala Bagian, ambil seluruh user yang
    | NIKKepalaBagian-nya sama dengan NIK user ini.
    |
    */

    public function bawahan()
    {
        if (!$this->NIK) {
            return MstKaryawan::query()
                ->whereRaw('1 = 0');
        }

        return MstKaryawan::query()
            ->where('NIKKepalaBagian', $this->NIK);
    }

    /*
    |--------------------------------------------------------------------------
    | REQUEST SEBAGAI PEMOHON
    |--------------------------------------------------------------------------
    */

    public function itRequests(): HasMany
    {
        return $this->hasMany(
            ItRequest::class,
            'UserPemohonID',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REQUEST SEBAGAI PENYELESAI
    |--------------------------------------------------------------------------
    */

    public function assignedItRequests(): HasMany
    {
        return $this->hasMany(
            ItRequest::class,
            'UserPenyelesaiID',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REQUEST TERKAIT
    |--------------------------------------------------------------------------
    */

    public function relatedItRequests()
    {
        return $this->belongsToMany(
            ItRequest::class,
            'it_request_related_users',
            'user_id',
            'it_request_id',
            'id',
            'IDRequest'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVAL
    |--------------------------------------------------------------------------
    |
    | Semua approval yang dilakukan user ini.
    |
    */

    public function approvals(): HasMany
    {
        return $this->hasMany(
            ItRequestApproval::class,
            'approver_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: KEPALA BAGIAN
    |--------------------------------------------------------------------------
    */

    public function isKepalaBagian(): bool
    {
        return $this->hasRole('kepala_bagian');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: PUNYA KEPALA BAGIAN
    |--------------------------------------------------------------------------
    */

    public function hasKepalaBagian(): bool
    {
        return $this->karyawan?->NIKKepalaBagian !== null;
    }

    /*
|--------------------------------------------------------------------------
| IT REQUEST RELATED USER NOTES
|--------------------------------------------------------------------------
*/

public function itRequestRelatedUserNotes(): HasMany
{
    return $this->hasMany(
        ItRequestRelatedUserNote::class,
        'user_id',
        'id'
    );
}

}
