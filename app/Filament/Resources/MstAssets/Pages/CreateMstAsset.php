<?php

namespace App\Filament\Resources\MstAssets\Pages;

use App\Filament\Resources\MstAssets\MstAssetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstAsset extends CreateRecord
{
    protected static string $resource = MstAssetResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
