<?php

namespace App\Models;
use App\Models\TrxMutasiAsset;

use Illuminate\Database\Eloquent\Model;


class MstAsset extends Model
{
    protected $table = 'mstasset';

    protected $primaryKey = 'NoAssetIT';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
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
        'Lapor',
        'StatusBeli',
        'TanggalBeli',
        'Harga',
        'IDVendor',
        'Garansi',
        'DateWarranty',
        'IDPerusahaan',
        'StatusAsset'
    ];

    protected $casts = [
        'TanggalBeli' => 'datetime',
        'DateWarranty' => 'datetime',
        'Harga' => 'decimal:2'
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
            'NoAssetIT',
            'NoAssetIT'
        );
    }

    public function service()
    {
        return $this->hasMany(
            TrxServiceAsset::class,
            'NoAssetIT',
            'NoAssetIT'
        );
    }

    public function retire()
    {
        return $this->hasMany(
            TrxRetireAsset::class,
            'NoAssetIT',
            'NoAssetIT'
        );
    }

    public function softwareAssignment()
    {
        return $this->hasMany(
            TrxSoftwareAssignment::class,
            'NoAssetIT',
            'NoAssetIT'
        );
    }

    // public function assignment()
    // {
    //     return $this->hasMany(
    //         TrxSoftwareAssignment::class,
    //         'IDLicense'
    //     );
    // }
}