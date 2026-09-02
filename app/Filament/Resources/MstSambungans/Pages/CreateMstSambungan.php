<?php

namespace App\Filament\Resources\MstSambungans\Pages;

use App\Filament\Resources\MstSambungans\MstSambunganResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstSambungan extends CreateRecord
{
    protected static string $resource = MstSambunganResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
