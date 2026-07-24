<?php

namespace App\Filament\Resources\MstSoftware\Pages;

use App\Filament\Resources\MstSoftware\MstSoftwareResource;
use App\Filament\Widgets\SoftwareLicenseOverview;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMstSoftware extends ListRecords
{

    protected static string $resource = MstSoftwareResource::class;




    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make(),

        ];
    }





    /**
     * Statistik License tampil di atas tabel
     */
    // protected function getHeaderWidgets(): array
    // {
    //     return [

    //         SoftwareLicenseOverview::class,

    //     ];
    // }

}