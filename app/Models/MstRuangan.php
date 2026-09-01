<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstRuangan extends Model
{
    protected $table = 'mstruangan';

    protected $primaryKey = 'IDRuangan';

    public $timestamps = false;

    protected $fillable = [
        'NamaRuangan',
        'IDLokasi',
    ];

    public function lokasi()
    {
        return $this->belongsTo(
            MstLokasi::class,
            'IDLokasi',
            'IDLokasi'
        );
    }

    public function pabxAssignment()
    {
        return $this->hasMany(
            TrxPabxAssignment::class,
            'IDRuangan',
            'IDRuangan'
        );
    }
}
