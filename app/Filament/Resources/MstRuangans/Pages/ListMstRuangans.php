<?php

namespace App\Filament\Resources\MstRuangans\Pages;

use App\Filament\Resources\MstRuangans\MstRuanganResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMstRuangans extends ListRecords
{
    protected static string $resource =
        MstRuanganResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * mstruangan.create
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
                        MstRuanganResource::canCreate()
                ),

        ];
    }
}
