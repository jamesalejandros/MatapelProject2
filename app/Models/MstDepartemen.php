<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MstDepartemen extends Model
{

    protected $table='mstdepartemen';


    protected $primaryKey='IDDept';


    public $timestamps=false;



    protected $fillable=[
        'NamaDept'
    ];



    public function karyawan()
    {
        return $this->hasMany(
            MstKaryawan::class,
            'IDDept'
        );
    }

}