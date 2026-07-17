<?php

namespace App\Filament\Resources\MstSoftware\Pages;

use App\Filament\Resources\MstSoftware\MstSoftwareResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstSoftware extends CreateRecord
{
    protected static string $resource = MstSoftwareResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
