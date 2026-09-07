<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;


    /**
     * ==========================================================
     * MASS ASSIGNMENT
     * ==========================================================
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * ==========================================================
     * HIDDEN
     * ==========================================================
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * ==========================================================
     * CASTS
     * ==========================================================
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
