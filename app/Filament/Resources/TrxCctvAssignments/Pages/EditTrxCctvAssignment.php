<?php

namespace App\Filament\Resources\TrxCctvAssignments\Pages;

use App\Filament\Resources\TrxCctvAssignments\TrxCctvAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrxCctvAssignment extends EditRecord
{
    protected static string $resource = TrxCctvAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
