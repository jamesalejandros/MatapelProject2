<?php

namespace App\Filament\Resources\TrxRetireAssets\Pages;

use App\Filament\Resources\TrxRetireAssets\TrxRetireAssetResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxRetireAsset extends EditRecord
{
    protected static string $resource =
        TrxRetireAssetResource::class;


    /**
     * ==========================================================
     * AFTER SAVE
     * ==========================================================
     *
     * Setelah data retire disimpan, status asset dipaksa menjadi:
     *
     * Retired
     */

    protected function afterSave(): void
    {
        $this->record->asset?->update([
            'StatusAsset' => 'Retired',
        ]);
    }


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya ditampilkan apabila user memiliki permission:
     *
     * trxretireasset.delete
     *
     * Permission update/edit TIDAK otomatis memberikan
     * permission delete.
     */

    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        TrxRetireAssetResource::canDelete($record)
                ),

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
}
