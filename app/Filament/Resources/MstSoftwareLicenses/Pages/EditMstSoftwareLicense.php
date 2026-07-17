<?php

namespace App\Filament\Resources\MstSoftwareLicenses\Pages;

use App\Filament\Resources\MstSoftwareLicenses\MstSoftwareLicenseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstSoftwareLicense extends EditRecord
{
    protected static string $resource = MstSoftwareLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
