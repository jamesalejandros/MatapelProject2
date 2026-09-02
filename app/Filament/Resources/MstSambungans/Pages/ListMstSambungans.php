<?php

namespace App\Filament\Resources\MstSambungans\Pages;

use App\Filament\Resources\MstSambungans\MstSambunganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstSambungans extends ListRecords
{
    protected static string $resource = MstSambunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
