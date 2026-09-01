<?php

namespace App\Filament\Resources\TrxPabxAssignments\Pages;

use App\Filament\Resources\TrxPabxAssignments\TrxPabxAssignmentResource;

use Filament\Actions\DeleteAction;

use Filament\Resources\Pages\EditRecord;


class EditTrxPabxAssignment extends EditRecord
{
    protected static string $resource =
        TrxPabxAssignmentResource::class;


    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make(),

        ];
    }
}
