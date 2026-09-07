<?php

namespace App\Filament\Resources\TrxRetireAssets\Pages;

use App\Filament\Resources\TrxRetireAssets\TrxRetireAssetResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListTrxRetireAssets extends ListRecords
{
    protected static string $resource =
        TrxRetireAssetResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * trxretireasset.create
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->visible(
                    fn () =>
                        TrxRetireAssetResource::canCreate()
                ),

        ];
    }
}
