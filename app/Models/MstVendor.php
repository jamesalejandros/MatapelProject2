<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MstVendor extends Model
{

    protected $table='mstvendor';


    protected $primaryKey='IDVendor';


    public $timestamps=false;



    protected $fillable=[
        'NamaVendor',
        'Kontak'
    ];



    public function assets()
    {
        return $this->hasMany(
            MstAsset::class,
            'IDVendor'
        );
    }



    public function services()
    {
        return $this->hasMany(
            TrxServiceAsset::class,
            'IDVendor'
        );
    }

}