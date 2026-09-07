<?php

namespace App\Filament\Resources\MstSoftware\Pages;

use App\Filament\Resources\MstSoftware\MstSoftwareResource;
use App\Filament\Widgets\SoftwareLicenseOverview;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMstSoftware extends ListRecords
{
    protected static string $resource =
        MstSoftwareResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * mstsoftware.create
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
                        MstSoftwareResource::canCreate()
                ),

        ];
    }


    /**
     * ==========================================================
     * HEADER WIDGETS
     * ==========================================================
     *
     * Statistik License dapat diaktifkan kembali apabila
     * diperlukan.
     */

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         SoftwareLicenseOverview::class,
    //     ];
    // }
}
