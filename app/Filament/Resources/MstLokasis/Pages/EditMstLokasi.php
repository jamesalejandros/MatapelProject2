<?php

namespace App\Filament\Resources\MstLokasis\Pages;

use App\Filament\Resources\MstLokasis\MstLokasiResource;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditMstLokasi extends EditRecord
{
    protected static string $resource =
        MstLokasiResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya boleh dilakukan apabila user memiliki:
     *
     * mstlokasi.delete
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
                        MstLokasiResource::canDelete($record)
                ),

        ];
    }
}
