<?php

namespace App\Filament\Resources\MstLokasis\Pages;

use App\Filament\Resources\MstLokasis\MstLokasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstLokasi extends CreateRecord
{
    protected static string $resource = MstLokasiResource::class;

    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
