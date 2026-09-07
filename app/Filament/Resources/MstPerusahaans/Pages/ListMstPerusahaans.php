<?php

namespace App\Filament\Resources\MstPerusahaans\Pages;

use App\Filament\Resources\MstPerusahaans\MstPerusahaanResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMstPerusahaans extends ListRecords
{
    protected static string $resource =
        MstPerusahaanResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * mstperusahaan.create
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->visible(
                    fn () =>
                        MstPerusahaanResource::canCreate()
                ),

        ];
    }
}
