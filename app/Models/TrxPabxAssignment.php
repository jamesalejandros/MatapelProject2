<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrxPabxAssignment extends Model
{
    protected $table = 'trxpabxassignment';

    protected $primaryKey = 'IDAssignment';

    public $timestamps = false;


    protected $fillable = [
        'NoAssetIT',
        'NoExt',
        'NIK',
        'IDRuangan',
        'Jenis',
        'Pin',
        'Sambungan',
    ];


    public function asset()
    {
        return $this->belongsTo(
            MstAsset::class,
            'NoAssetIT',
            'NoAssetIT'
        );
    }


    public function karyawan()
    {
        return $this->belongsTo(
            MstKaryawan::class,
            'NIK',
            'NIK'
        );
    }


    public function ruangan()
    {
        return $this->belongsTo(
            MstRuangan::class,
            'IDRuangan',
            'IDRuangan'
        );
    }
}
