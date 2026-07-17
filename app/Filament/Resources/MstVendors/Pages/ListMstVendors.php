<?php

namespace App\Filament\Resources\MstVendors\Pages;

use App\Filament\Resources\MstVendors\MstVendorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstVendors extends ListRecords
{
    protected static string $resource = MstVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
