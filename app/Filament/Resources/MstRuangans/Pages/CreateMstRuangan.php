<?php

namespace App\Filament\Resources\MstRuangans\Pages;

use App\Filament\Resources\MstRuangans\MstRuanganResource;

use Filament\Resources\Pages\CreateRecord;


class CreateMstRuangan extends CreateRecord
{
    protected static string $resource =
        MstRuanganResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
