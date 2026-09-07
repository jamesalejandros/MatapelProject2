<?php

namespace App\Filament\Resources\TrxSoftwareAssignments\Pages;

use App\Filament\Resources\TrxSoftwareAssignments\TrxSoftwareAssignmentResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxSoftwareAssignment extends EditRecord
{
    protected static string $resource =
        TrxSoftwareAssignmentResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya ditampilkan apabila user memiliki permission:
     *
     * trxsoftwareassignment.delete
     *
     * Permission edit/update TIDAK otomatis memberikan
     * permission delete.
     */

    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()

                ->visible(
                    fn ($record) =>
                        TrxSoftwareAssignmentResource::canDelete($record)
                ),

        ];
    }
}
