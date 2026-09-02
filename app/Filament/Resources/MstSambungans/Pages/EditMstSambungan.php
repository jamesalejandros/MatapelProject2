<?php

namespace App\Filament\Resources\MstSambungans\Pages;

use App\Filament\Resources\MstSambungans\MstSambunganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstSambungan extends EditRecord
{
    protected static string $resource = MstSambunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
