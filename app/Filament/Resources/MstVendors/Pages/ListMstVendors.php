<?php

namespace App\Filament\Resources\MstVendors\Pages;

use App\Filament\Resources\MstVendors\MstVendorResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMstVendors extends ListRecords
{
    protected static string $resource =
        MstVendorResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * mstvendor.create
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->visible(
                    fn () =>
                        MstVendorResource::canCreate()
                ),

        ];
    }
}
