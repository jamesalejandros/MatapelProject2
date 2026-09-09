<?php

namespace App\Filament\Resources\MstKepalaBagians\Pages;

use App\Filament\Resources\MstKepalaBagians\MstKepalaBagianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstKepalaBagians extends ListRecords
{
    protected static string $resource =
        MstKepalaBagianResource::class;

    /*
    |--------------------------------------------------------------------------
    | HEADER ACTIONS
    |--------------------------------------------------------------------------
    */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->label('Tambah Kepala Bagian')
                ->visible(
                    fn () =>
                        MstKepalaBagianResource::canCreate()
                ),

        ];
    }
}
