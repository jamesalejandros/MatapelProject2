<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MstSoftware;
use App\Models\MstPerusahaan;
use App\Models\TrxSoftwareAssignment;


class MstSoftwareLicense extends Model
{

    protected $table = 'mstsoftwarelicense';


    protected $primaryKey = 'IDLicense';


    /*
    |--------------------------------------------------------------------------
    | IDLicense sekarang VARCHAR PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    public $incrementing = false;

    protected $keyType = 'string';


    public $timestamps = false;



    protected $fillable = [

        'IDLicense',
        'IDSoftware',
        'IDPerusahaan',
        'ProductKey',
        'TipeLisensi',
        'JumlahLisensi',
        'HasDVD',
        'Barcode',
        'LokasiSimpan',
        'TempatSimpan',
        'Keterangan', // Tambahkan ini
        'StatusLisensi'

    ];



    protected $casts = [

        'HasDVD' => 'boolean'

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
