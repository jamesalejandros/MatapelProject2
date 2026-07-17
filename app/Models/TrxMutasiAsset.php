<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TrxMutasiAsset extends Model
{

    protected $table='trxmutasiasset';


    protected $primaryKey='IDMutasi';


    public $timestamps=false;



    protected $fillable=[
        'IDAsset',
        'NoTransferSAP',
        'TanggalMutasi',
        'NIK',
        'IDLokasi',
        'AksesWebsite',
        'AksesEmail',
        'Lapor',
        'Keterangan',
        'IsActive'
    ];



    protected $casts=[
        'TanggalMutasi'=>'datetime',
        'IsActive'=>'boolean'
    ];



    public function asset()
    {
        return $this->belongsTo(
            MstAsset::class,
            'IDAsset'
        );
    }



    public function karyawan()
    {
        return $this->belongsTo(
            MstKaryawan::class,
            'NIK'
        );
    }



    public function lokasi()
    {
        return $this->belongsTo(
            MstLokasi::class,
            'IDLokasi'
        );
    }

}