<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MstSoftwareLicense extends Model
{

    protected $table='mstsoftwarelicense';


    protected $primaryKey='IDLicense';


    public $timestamps=false;



    protected $fillable=[
        'IDSoftware',
        'IDPerusahaan',
        'ProductKey',
        'TipeLisensi',
        'JumlahLisensi',
        'HasDVD',
        'Barcode',
        'LokasiSimpan',
        'TempatSimpan',
        'StatusLisensi'
    ];



    protected $casts=[
        'HasDVD'=>'boolean'
    ];



    public function software()
    {
        return $this->belongsTo(
            MstSoftware::class,
            'IDSoftware'
        );
    }



    public function perusahaan()
    {
        return $this->belongsTo(
            MstPerusahaan::class,
            'IDPerusahaan'
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