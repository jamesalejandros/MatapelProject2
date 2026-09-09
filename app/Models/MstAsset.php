<?php
namespace App\Models;
use App\Models\Concerns\AuditLoggable;
use App\Models\TrxCctvAssignment;
use App\Models\TrxMutasiAsset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class MstAsset extends Model
{
    use AuditLoggable;
    protected $table = 'mstasset';
    protected $primaryKey = 'NoAssetIT';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['NoAssetIT', 'NoAssetSAP', 'Jenis', 'Nama', 'PN', 'SN', 'PN_LCD', 'SN_LCD', 'RAM', 'JenisOS', 'ComputerName', 'IPAddress', 'Lapor', 'StatusBeli', 'TanggalBeli', 'Harga', 'IDVendor', 'Garansi', 'DateWarranty', 'IDPerusahaan', 'NIK', 'IDLokasi', 'StatusAsset', 'Keterangan',];
    protected $casts = ['TanggalBeli' => 'datetime', 'DateWarranty' => 'datetime', 'Harga' => 'decimal:2', 'Garansi' => 'integer',];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ($model->Garansi === null) {
                $model->Garansi = 0; } });
        static::updating(function ($model) {
            if ($model->Garansi === null) {
                $model->Garansi = 0; } });
    } /* |-------------------------------------------------------------------------- | LOKASI |-------------------------------------------------------------------------- */
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(MstLokasi::class, 'IDLokasi', 'IDLokasi');
    } /* |-------------------------------------------------------------------------- | PERUSAHAAN |-------------------------------------------------------------------------- */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(MstPerusahaan::class, 'IDPerusahaan');
    } /* |-------------------------------------------------------------------------- | VENDOR |-------------------------------------------------------------------------- */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(MstVendor::class, 'IDVendor');
    } /* |-------------------------------------------------------------------------- | MUTASI ASSET |-------------------------------------------------------------------------- */
    public function mutasiAsset(): HasMany
    {
        return $this->hasMany(TrxMutasiAsset::class, 'NoAssetIT', 'NoAssetIT');
    } /* |-------------------------------------------------------------------------- | KARYAWAN |-------------------------------------------------------------------------- */
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(MstKaryawan::class, 'NIK', 'NIK');
    } /* |-------------------------------------------------------------------------- | SERVICE |-------------------------------------------------------------------------- */
    public function service(): HasMany
    {
        return $this->hasMany(TrxServiceAsset::class, 'NoAssetIT', 'NoAssetIT');
    } /* |-------------------------------------------------------------------------- | RETIRE |-------------------------------------------------------------------------- */
    public function retire(): HasMany
    {
        return $this->hasMany(TrxRetireAsset::class, 'NoAssetIT', 'NoAssetIT');
    } /* |-------------------------------------------------------------------------- | SOFTWARE ASSIGNMENT |-------------------------------------------------------------------------- */
    public function softwareAssignment(): HasMany
    {
        return $this->hasMany(TrxSoftwareAssignment::class, 'NoAssetIT', 'NoAssetIT');
    } /* |-------------------------------------------------------------------------- | PABX ASSIGNMENT |-------------------------------------------------------------------------- */
    public function pabxAssignment(): HasMany
    {
        return $this->hasMany(TrxPabxAssignment::class, 'NoAssetIT', 'NoAssetIT');
    } /* |-------------------------------------------------------------------------- | CCTV ASSIGNMENT |-------------------------------------------------------------------------- */
    public function cctvAssignment(): HasMany
    {
        return $this->hasMany(TrxCctvAssignment::class, 'NoAssetIT', 'NoAssetIT');
    } /* |-------------------------------------------------------------------------- | IT REQUESTS |-------------------------------------------------------------------------- | | Sekarang satu asset dapat digunakan pada banyak request, | dan satu request dapat mempunyai banyak asset. | */
    public function itRequests(): BelongsToMany
    {
        return $this->belongsToMany(ItRequest::class, 'it_request_assets', 'NoAssetIT', 'it_request_id', 'NoAssetIT', 'IDRequest')->withTimestamps();
    }
}