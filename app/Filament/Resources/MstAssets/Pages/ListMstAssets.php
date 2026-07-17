<?php

namespace App\Filament\Resources\MstAssets\Pages;

use App\Filament\Resources\MstAssets\MstAssetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstAssets extends ListRecords
{
    protected static string $resource = MstAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
