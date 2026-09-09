<?php

namespace App\Filament\Resources\MstJenisPermintaans\Pages;

use App\Filament\Resources\MstJenisPermintaans\MstJenisPermintaanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstJenisPermintaan extends CreateRecord
{
    protected static string $resource =
        MstJenisPermintaanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
