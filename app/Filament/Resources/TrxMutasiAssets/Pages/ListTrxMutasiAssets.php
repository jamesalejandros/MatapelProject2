<?php

namespace App\Filament\Resources\TrxMutasiAssets\Pages;

use App\Filament\Resources\TrxMutasiAssets\TrxMutasiAssetResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListTrxMutasiAssets extends ListRecords
{
    protected static string $resource =
        TrxMutasiAssetResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * trxmutasiasset.create
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->visible(
                    fn () =>
                        TrxMutasiAssetResource::canCreate()
                ),

        ];
    }
}
