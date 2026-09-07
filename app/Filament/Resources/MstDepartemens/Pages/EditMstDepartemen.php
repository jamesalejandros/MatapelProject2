<?php

namespace App\Filament\Resources\MstDepartemens\Pages;

use App\Filament\Resources\MstDepartemens\MstDepartemenResource;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditMstDepartemen extends EditRecord
{
    protected static string $resource =
        MstDepartemenResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya boleh dilakukan apabila user memiliki:
     *
     * mstdepartemen.delete
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
                        MstDepartemenResource::canDelete($record)
                ),

        ];
    }
}
