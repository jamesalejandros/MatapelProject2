<?php

namespace App\Models;

use App\Models\Concerns\AuditLoggable;
use Illuminate\Database\Eloquent\Model;


class MstDepartemen extends Model
{
    use AuditLoggable;

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