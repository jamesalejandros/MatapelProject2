<?php

namespace App\Filament\Resources\TrxPabxAssignments\Pages;

use App\Filament\Resources\TrxPabxAssignments\TrxPabxAssignmentResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxPabxAssignment extends EditRecord
{
    protected static string $resource =
        TrxPabxAssignmentResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     */

    protected function getHeaderActions(): array
    {
        return [

            /**
             * ==================================================
             * DELETE
             * ==================================================
             *
             * Delete hanya boleh dilakukan apabila user
             * memiliki permission:
             *
             * trxpabxassignment.delete
             *
             * Permission update TIDAK otomatis memberikan
             * permission delete.
             */

            DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        TrxPabxAssignmentResource::canDelete($record)
                ),

        ];
    }
}
