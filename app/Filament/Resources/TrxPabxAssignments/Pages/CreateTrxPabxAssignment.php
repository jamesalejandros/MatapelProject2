<?php

namespace App\Filament\Resources\TrxPabxAssignments\Pages;

use App\Filament\Resources\TrxPabxAssignments\TrxPabxAssignmentResource;

use Filament\Resources\Pages\CreateRecord;


class CreateTrxPabxAssignment extends CreateRecord
{
    protected static string $resource =
        TrxPabxAssignmentResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
