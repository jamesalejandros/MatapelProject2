<?php

namespace App\Filament\Resources\TrxMutasiAssets\Pages;

use App\Filament\Resources\TrxMutasiAssets\TrxMutasiAssetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrxMutasiAsset extends EditRecord
{
    protected static string $resource = TrxMutasiAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
