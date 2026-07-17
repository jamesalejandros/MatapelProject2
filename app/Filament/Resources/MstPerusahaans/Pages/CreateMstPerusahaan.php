<?php

namespace App\Filament\Resources\MstPerusahaans\Pages;

use App\Filament\Resources\MstPerusahaans\MstPerusahaanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstPerusahaan extends CreateRecord
{
    protected static string $resource = MstPerusahaanResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
