<?php

namespace App\Filament\Resources\MstSoftwareLicenses\Pages;

use App\Filament\Resources\MstSoftwareLicenses\MstSoftwareLicenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstSoftwareLicenses extends ListRecords
{
    protected static string $resource = MstSoftwareLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
