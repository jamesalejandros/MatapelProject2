<?php

namespace App\Filament\Resources\MstKaryawans\Pages;

use App\Filament\Resources\MstKaryawans\MstKaryawanResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMstKaryawans extends ListRecords
{
    protected static string $resource =
        MstKaryawanResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * mstkaryawan.create
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->visible(
                    fn () =>
                        MstKaryawanResource::canCreate()
                ),

        ];
    }
}
