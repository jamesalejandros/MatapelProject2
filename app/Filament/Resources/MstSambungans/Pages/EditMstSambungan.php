<?php

namespace App\Filament\Resources\MstSambungans\Pages;

use App\Filament\Resources\MstSambungans\MstSambunganResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditMstSambungan extends EditRecord
{
    protected static string $resource =
        MstSambunganResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Delete hanya ditampilkan apabila user memiliki:
     *
     * mstsambungan.delete
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

            DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        MstSambunganResource::canDelete($record)
                ),

        ];
    }
}
