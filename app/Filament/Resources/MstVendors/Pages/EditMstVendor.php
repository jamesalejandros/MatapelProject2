<?php

namespace App\Filament\Resources\MstVendors\Pages;

use App\Filament\Resources\MstVendors\MstVendorResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditMstVendor extends EditRecord
{
    protected static string $resource =
        MstVendorResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya ditampilkan apabila user memiliki permission:
     *
     * mstvendor.delete
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
                        MstVendorResource::canDelete($record)
                ),

        ];
    }
}
