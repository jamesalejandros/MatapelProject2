<?php

namespace App\Filament\Resources\MstVendors\Pages;

use App\Filament\Resources\MstVendors\MstVendorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstVendor extends EditRecord
{
    protected static string $resource = MstVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
