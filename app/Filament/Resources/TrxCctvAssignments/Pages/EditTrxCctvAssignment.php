<?php

namespace App\Filament\Resources\TrxCctvAssignments\Pages;

use App\Filament\Resources\TrxCctvAssignments\TrxCctvAssignmentResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxCctvAssignment extends EditRecord
{
    protected static string $resource =
        TrxCctvAssignmentResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Delete hanya ditampilkan apabila user memiliki permission:
     *
     * trxcctvassignment.delete
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
                        TrxCctvAssignmentResource::canDelete($record)
                ),

        ];
    }
}
