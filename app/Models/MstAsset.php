<?php

namespace App\Models;
use App\Models\TrxMutasiAsset;

use Illuminate\Database\Eloquent\Model;


class MstAsset extends Model
{

    protected $table='mstasset';


    protected $primaryKey='IDAsset';


    public $timestamps=false;



    protected $fillable=[
        'NoAssetIT',
        'NoAssetSAP',
        'Jenis',
        'Nama',
        'PN',
        'SN',
        'PN_LCD',
        'SN_LCD',
        'RAM',
        'JenisOS',
        'ComputerName',
        'IPAddress',
        'StatusBeli',
        'TanggalBeli',
        'Harga',
        'IDVendor',
        'Garansi',
        'DateWarranty',
        'IDPerusahaan',
        'StatusAsset'
    ];



    protected $casts=[
        'TanggalBeli'=>'datetime',
        'DateWarranty'=>'datetime',
        'Harga'=>'decimal:2'
    ];



    public function perusahaan()
    {
        return $this->belongsTo(
            MstPerusahaan::class,
            'IDPerusahaan'
        );
    }



    public function vendor()
    {
        return $this->belongsTo(
            MstVendor::class,
            'IDVendor'
        );
    }



    public function mutasiAsset()
    {
        return $this->hasMany(
            TrxMutasiAsset::class,
            'IDAsset'
        );
    }



    public function service()
    {
        return $this->hasMany(
            TrxServiceAsset::class,
            'IDAsset'
        );
    }



    public function retire()
    {
        return $this->hasMany(
            TrxRetireAsset::class,
            'IDAsset'
        );
    }




    public function softwareAssignment()
    {
        return $this->hasMany(
            TrxSoftwareAssignment::class,
            'IDAsset'
        );
    }

        public function assignment()
    {
        return $this->hasMany(
            TrxSoftwareAssignment::class,
            'IDLicense'
        );
    }

}