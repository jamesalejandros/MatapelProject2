<?php

namespace App\Models;

use App\Models\Concerns\AuditLoggable;
use Illuminate\Database\Eloquent\Model;

class MstLokasi extends Model
{
    use AuditLoggable;
    protected $table='mstlokasi';

    protected $primaryKey='IDLokasi';

    public $timestamps=false;

    protected $fillable=[
        'NamaLokasi',
        'Keterangan'
    ];


    public function mutasi()
    {
        return $this->hasMany(
            TrxMutasiAsset::class,
            'IDLokasi'
        );
    }
}