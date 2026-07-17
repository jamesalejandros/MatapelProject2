<?php

namespace App\Filament\Resources\MstSoftware\Pages;

use App\Filament\Resources\MstSoftware\MstSoftwareResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstSoftware extends EditRecord
{
    protected static string $resource = MstSoftwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
