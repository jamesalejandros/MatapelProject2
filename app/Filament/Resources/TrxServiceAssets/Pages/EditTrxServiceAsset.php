<?php

namespace App\Filament\Resources\TrxServiceAssets\Pages;

use App\Filament\Resources\TrxServiceAssets\TrxServiceAssetResource;
use App\Models\MstAsset;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxServiceAsset extends EditRecord
{
    protected static string $resource =
        TrxServiceAssetResource::class;


    /**
     * ==========================================================
     * AFTER SAVE
     * ==========================================================
     *
     * Setelah data service disimpan, status asset
     * akan diperbarui berdasarkan seluruh data service.
     */

    protected function afterSave(): void
    {
        $this->updateAssetStatus();
    }


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya ditampilkan apabila user memiliki permission:
     *
     * trxserviceasset.delete
     *
     * Permission edit/update TIDAK otomatis memberikan
     * permission delete.
     */

    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        TrxServiceAssetResource::canDelete($record)
                )
                ->after(function () {

                    $this->updateAssetStatus();

                }),

        ];
    }


    /**
     * ==========================================================
     * UPDATE ASSET STATUS
     * ==========================================================
     *
     * Status asset ditentukan berdasarkan service terakhir:
     *
     * - Apabila ada service Proses       -> In Service
     * - Apabila ada service Unrepairable -> Retired
     * - Selain itu                       -> Available
     */

    protected function updateAssetStatus(): void
    {
        $service = $this->record;


        $asset = MstAsset::where(
            'NoAssetIT',
            $service->NoAssetIT
        )->first();


        if (!$asset) {
            return;
        }


        $services = $asset
            ->service()
            ->get();


        if (
            $services
                ->where(
                    'StatusService',
                    'Proses'
                )
                ->isNotEmpty()
        ) {

            $status = 'In Service';

        } elseif (
            $services
                ->where(
                    'StatusService',
                    'Unrepairable'
                )
                ->isNotEmpty()
        ) {

            $status = 'Retired';

        } else {

            $status = 'Available';

        }


        $asset->update([
            'StatusAsset' => $status,
        ]);
    }
}
