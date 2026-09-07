<?php

namespace App\Filament\Resources\MstKaryawans\Pages;

use App\Filament\Resources\MstKaryawans\MstKaryawanResource;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditMstKaryawan extends EditRecord
{
    protected static string $resource =
        MstKaryawanResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya boleh dilakukan apabila user memiliki:
     *
     * mstkaryawan.delete
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
                        MstKaryawanResource::canDelete($record)
                ),

        ];
    }
}
