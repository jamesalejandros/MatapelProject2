<?php

namespace App\Filament\Resources\MstLokasis\Pages;

use App\Filament\Resources\MstLokasis\MstLokasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstLokasi extends EditRecord
{
    protected static string $resource = MstLokasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
