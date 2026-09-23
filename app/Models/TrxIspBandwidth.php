<?php

namespace App\Models;

use App\Models\Concerns\AuditLoggable;
use Illuminate\Database\Eloquent\Model;

class TrxIspBandwidth extends Model
{
    use AuditLoggable;

    protected $table = 'trxispbandwidth';

    protected $primaryKey = 'IDBandwidth';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'IDISP',
        'TanggalUpgrade',
        'BandwidthInternasional',
        'BandwidthLokal',
        'Harga',
        'Keterangan',
        'Status',
    ];

    protected $casts = [
        'IDBandwidth' => 'integer',
        'IDISP' => 'integer',
        'TanggalUpgrade' => 'date',
        'BandwidthInternasional' => 'decimal:2',
        'BandwidthLokal' => 'decimal:2',
        'Harga' => 'decimal:2',
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
