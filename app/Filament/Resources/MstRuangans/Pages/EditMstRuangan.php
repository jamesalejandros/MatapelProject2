<?php

namespace App\Filament\Resources\MstRuangans\Pages;

use App\Filament\Resources\MstRuangans\MstRuanganResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditMstRuangan extends EditRecord
{
    protected static string $resource =
        MstRuanganResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Delete hanya ditampilkan apabila user memiliki:
     *
     * mstruangan.delete
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
                        MstRuanganResource::canDelete($record)
                ),

        ];
    }
}
