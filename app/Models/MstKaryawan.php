<?php

namespace App\Models;

use App\Models\Concerns\AuditLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MstKaryawan extends Model
{
    use AuditLoggable;

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

public function user(): HasOne
{
    return $this->hasOne(
        User::class,
        'NIK',
        'NIK'
    );
}

}