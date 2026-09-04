<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrxCctvAssignment extends Model
{
    protected $table = 'trxcctvassignment';

    protected $primaryKey = 'IDAssignment';

    public $timestamps = false;


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'NoAssetIT',

        'Channel',

        'Jenis',

        'TanggalPasang',

        'Tipe',

        'Kondisi',

        'Keterangan',

    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'TanggalPasang' => 'date',

    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : ASSET
    |--------------------------------------------------------------------------
    |
    | trxcctvassignment.NoAssetIT
    |          ↓
    | mstasset.NoAssetIT
    |
    */

    public function asset()
    {
        return $this->belongsTo(
            MstAsset::class,
            'NoAssetIT',
            'NoAssetIT'
        );
    }
}