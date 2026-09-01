<?php

namespace App\Filament\Resources\MstRuangans\Pages;

use App\Filament\Resources\MstRuangans\MstRuanganResource;

use Filament\Actions\CreateAction;

use Filament\Resources\Pages\ListRecords;


class ListMstRuangans extends ListRecords
{
    protected static string $resource =
        MstRuanganResource::class;


    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make(),

        ];
    }
}
