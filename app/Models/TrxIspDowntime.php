<?php

namespace App\Models;

use App\Models\Concerns\AuditLoggable;
use Illuminate\Database\Eloquent\Model;

class TrxIspDowntime extends Model
{
    use AuditLoggable;

    protected $table = 'trxispdowntime';

    protected $primaryKey = 'IDDowntime';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'IDISP',
        'NoTiket',
        'TanggalMulai',
        'TanggalSelesai',
        'TotalJam',
        'LokasiPutus',
        'Penyebab',
        'Dampak',
        'Keterangan',
    ];

    protected $casts = [
        'IDDowntime' => 'integer',
        'IDISP' => 'integer',
        'TanggalMulai' => 'datetime',
        'TanggalSelesai' => 'datetime',
        'TotalJam' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke ISP.
     */
    public function isp()
    {
        return $this->belongsTo(
            MstIsp::class,
            'IDISP',
            'IDISP'
        );
    }
}
