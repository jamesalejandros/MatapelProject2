<?php

namespace App\Filament\Resources\MstPerusahaans\Pages;

use App\Filament\Resources\MstPerusahaans\MstPerusahaanResource;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditMstPerusahaan extends EditRecord
{
    protected static string $resource =
        MstPerusahaanResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya boleh dilakukan apabila user memiliki:
     *
     * mstperusahaan.delete
     *
     * Permission update TIDAK otomatis memberikan
     * permission delete.
     */

    protected function getHeaderActions(): array
    {
        return [

            /**
             * ==================================================
             * DELETE
             * ==================================================
             */

            Actions\DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        MstPerusahaanResource::canDelete($record)
                ),

        ];
    }
}
