<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MstKaryawan extends Model
{

    protected $table='mstkaryawan';


    protected $primaryKey='NIK';


    public $incrementing=false;


    protected $keyType='string';


    public $timestamps=false;



    protected $fillable=[
        'NIK',
        'Nama',
        'IDDept',
        'IDPerusahaan'
    ];



    public function departemen()
    {
        return $this->belongsTo(
            MstDepartemen::class,
            'IDDept'
        );
    }



    public function perusahaan()
    {
        return $this->belongsTo(
            MstPerusahaan::class,
            'IDPerusahaan'
        );
    }



    public function mutasi()
    {
        return $this->hasMany(
            TrxMutasiAsset::class,
            'NIK'
        );
    }

    public function assets()
{
    return $this->hasMany(
        MstAsset::class,
        'NIK',
        'NIK'
    );
}

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
        'NIK',
        'NIK'
    );
}


}