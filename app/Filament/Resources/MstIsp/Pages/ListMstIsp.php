<?php

namespace App\Filament\Resources\MstIsp\Pages;

use App\Filament\Resources\MstIsp\MstIspResource;

use Filament\Actions\CreateAction;

use Filament\Resources\Pages\ListRecords;


class ListMstIsp extends ListRecords
{
    protected static string $resource =
        MstIspResource::class;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
