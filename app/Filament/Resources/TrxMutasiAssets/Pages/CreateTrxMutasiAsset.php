<?php

namespace App\Filament\Resources\TrxMutasiAssets\Pages;

use App\Filament\Resources\TrxMutasiAssets\TrxMutasiAssetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrxMutasiAsset extends CreateRecord
{
    protected static string $resource = TrxMutasiAssetResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
