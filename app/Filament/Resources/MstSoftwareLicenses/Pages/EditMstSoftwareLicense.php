<?php

namespace App\Filament\Resources\MstSoftwareLicenses\Pages;

use App\Filament\Resources\MstSoftwareLicenses\MstSoftwareLicenseResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditMstSoftwareLicense extends EditRecord
{
    protected static string $resource =
        MstSoftwareLicenseResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya ditampilkan apabila user memiliki permission:
     *
     * mstsoftwarelicense.delete
     *
     * Permission update TIDAK otomatis memberikan
     * permission delete.
     */

    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        MstSoftwareLicenseResource::canDelete($record)
                ),

        ];
    }
}
