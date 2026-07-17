<?php

namespace App\Filament\Resources\TrxSoftwareAssignments\Pages;

use App\Filament\Resources\TrxSoftwareAssignments\TrxSoftwareAssignmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrxSoftwareAssignment extends CreateRecord
{
    protected static string $resource = TrxSoftwareAssignmentResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
