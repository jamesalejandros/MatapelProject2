<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MstSoftwareLicense;

class MstSoftware extends Model
{

    protected $table='mstsoftware';


    protected $primaryKey='IDSoftware';


    public $timestamps=false;



    protected $fillable=[
        'KodeSoftwareCustom',
        'NamaSoftware',
        'SoftCategory',
        'Jenis',
        'Version',
        'Is32Bit',
        'Is64Bit',
        'Keterangan'
    ];



    protected $casts=[
        'Is32Bit'=>'boolean',
        'Is64Bit'=>'boolean'
    ];



    public function license()
    {
        return $this->hasMany(
            MstSoftwareLicense::class,
            'IDSoftware'
        );
    }

}