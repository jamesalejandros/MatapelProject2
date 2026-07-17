<?php

namespace App\Filament\Resources\MstLokasis\Pages;

use App\Filament\Resources\MstLokasis\MstLokasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstLokasis extends ListRecords
{
    protected static string $resource = MstLokasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
