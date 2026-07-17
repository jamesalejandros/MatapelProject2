<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TrxSoftwareAssignment extends Model
{

    protected $table='trxsoftwareassignment';


    protected $primaryKey='IDAssignment';


    public $timestamps=false;



    protected $fillable=[
        'IDLicense',
        'IDAsset',
        'TanggalAssign',
        'TanggalRevoke',
        'StatusAssignment'
    ];



    protected $casts=[
        'TanggalAssign'=>'datetime',
        'TanggalRevoke'=>'datetime'
    ];



    public function license()
    {
        return $this->belongsTo(
            MstSoftwareLicense::class,
            'IDLicense'
        );
    }



    public function asset()
    {
        return $this->belongsTo(
            MstAsset::class,
            'IDAsset'
        );
    }

}