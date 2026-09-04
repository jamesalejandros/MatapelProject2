<?php

namespace App\Filament\Resources\TrxCctvAssignments\Pages;

use App\Filament\Resources\TrxCctvAssignments\TrxCctvAssignmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrxCctvAssignment extends CreateRecord
{
    protected static string $resource = TrxCctvAssignmentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
