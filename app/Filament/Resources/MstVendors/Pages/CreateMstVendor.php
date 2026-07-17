<?php

namespace App\Filament\Resources\MstVendors\Pages;

use App\Filament\Resources\MstVendors\MstVendorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstVendor extends CreateRecord
{
    protected static string $resource = MstVendorResource::class;

    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
