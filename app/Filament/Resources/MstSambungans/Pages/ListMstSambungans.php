<?php

namespace App\Filament\Resources\MstSambungans\Pages;

use App\Filament\Resources\MstSambungans\MstSambunganResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMstSambungans extends ListRecords
{
    protected static string $resource =
        MstSambunganResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * mstsambungan.create
     */

    protected function getHeaderActions(): array
    {
        return [

            /**
             * ==================================================
             * CREATE
             * ==================================================
             */

            CreateAction::make()
                ->visible(
                    fn () =>
                        MstSambunganResource::canCreate()
                ),

        ];
    }
}
