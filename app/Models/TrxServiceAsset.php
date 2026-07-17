<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TrxServiceAsset extends Model
{

    protected $table='trxserviceasset';


    protected $primaryKey='IDService';


    public $timestamps=false;



    protected $fillable=[
        'IDAsset',
        'TanggalMasuk',
        'TanggalSelesai',
        'JenisService',
        'Kerusakan',
        'Tindakan',
        'Biaya',
        'IDVendor',
        'StatusService',
        'Oleh'
    ];



    protected $casts=[
        'TanggalMasuk'=>'datetime',
        'TanggalSelesai'=>'datetime',
        'Biaya'=>'decimal:2'
    ];



    public function asset()
    {
        return $this->belongsTo(
            MstAsset::class,
            'IDAsset'
        );
    }



    public function vendor()
    {
        return $this->belongsTo(
            MstVendor::class,
            'IDVendor'
        );
    }

}