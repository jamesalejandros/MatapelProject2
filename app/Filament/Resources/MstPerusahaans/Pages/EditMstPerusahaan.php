<?php

namespace App\Filament\Resources\MstPerusahaans\Pages;

use App\Filament\Resources\MstPerusahaans\MstPerusahaanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstPerusahaan extends EditRecord
{
    protected static string $resource = MstPerusahaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
