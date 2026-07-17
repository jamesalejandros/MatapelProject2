<?php

namespace App\Filament\Resources\TrxSoftwareAssignments\Pages;

use App\Filament\Resources\TrxSoftwareAssignments\TrxSoftwareAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrxSoftwareAssignment extends EditRecord
{
    protected static string $resource = TrxSoftwareAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
