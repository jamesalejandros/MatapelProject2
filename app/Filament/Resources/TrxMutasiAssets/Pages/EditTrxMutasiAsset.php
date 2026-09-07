<?php

namespace App\Filament\Resources\TrxMutasiAssets\Pages;

use App\Filament\Resources\TrxMutasiAssets\TrxMutasiAssetResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxMutasiAsset extends EditRecord
{
    protected static string $resource =
        TrxMutasiAssetResource::class;


    /**
     * ==========================================================
     * AFTER SAVE
     * ==========================================================
     */

    protected function afterSave(): void
    {
        $this->updateLatestMutation();
    }


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     */

    protected function getHeaderActions(): array
    {
        return [

            /**
             * ==================================================
             * DELETE
             * ==================================================
             *
             * Delete hanya boleh dilakukan apabila user
             * memiliki permission:
             *
             * trxmutasiasset.delete
             *
             * Permission update TIDAK otomatis memberikan
             * permission delete.
             */

            DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        TrxMutasiAssetResource::canDelete($record)
                )
                ->after(function () {
                    $this->updateLatestMutation();
                }),

        ];
    }


    /**
     * ==========================================================
     * REDIRECT
     * ==========================================================
     */

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    /**
     * ==========================================================
     * UPDATE LATEST MUTATION
     * ==========================================================
     */

    private function updateLatestMutation(): void
    {
        $record = $this->record;


        $asset = $record->asset;


        if (!$asset) {
            return;
        }


        $lastMutation = $asset
            ->mutasiAsset()
            ->orderByDesc('TanggalMutasi')
            ->first();


        if ($lastMutation) {

            $asset->update([
                'NIK' => $lastMutation->NIK,
                'IDLokasi' => $lastMutation->IDLokasi,
            ]);

        } else {

            $asset->update([
                'NIK' => null,
                'IDLokasi' => null,
            ]);

        }
    }
}
