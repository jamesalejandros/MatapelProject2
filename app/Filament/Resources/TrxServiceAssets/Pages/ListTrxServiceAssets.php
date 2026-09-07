<?php

namespace App\Filament\Resources\TrxServiceAssets\Pages;

use App\Filament\Resources\TrxServiceAssets\TrxServiceAssetResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListTrxServiceAssets extends ListRecords
{
    protected static string $resource =
        TrxServiceAssetResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * trxserviceasset.create
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->visible(
                    fn () =>
                        TrxServiceAssetResource::canCreate()
                ),

        ];
    }
}
