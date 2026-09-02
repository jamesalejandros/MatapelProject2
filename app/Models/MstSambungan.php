<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstSambungan extends Model
{
    protected $table = 'mstsambungan';

    protected $primaryKey = 'IDSambungan';

    public $timestamps = false;

    protected $fillable = [
        'Rule',
    ];


    public function assignments()
    {
        return $this->hasMany(
            TrxPabxAssignment::class,
            'IDSambungan',
            'IDSambungan'
        );
    }
}
