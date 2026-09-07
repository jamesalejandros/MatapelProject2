<?php

namespace App\Filament\Resources\TrxSoftwareAssignments\Pages;

use App\Filament\Resources\TrxSoftwareAssignments\TrxSoftwareAssignmentResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListTrxSoftwareAssignments extends ListRecords
{
    protected static string $resource =
        TrxSoftwareAssignmentResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     *
     * Tombol Tambah hanya ditampilkan apabila user memiliki:
     *
     * trxsoftwareassignment.create
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()

                ->visible(
                    fn () =>
                        TrxSoftwareAssignmentResource::canCreate()
                ),

        ];
    }
}
