<?php

namespace App\Filament\Resources\TrxPabxAssignments\Pages;

use App\Filament\Resources\TrxPabxAssignments\TrxPabxAssignmentResource;

use Filament\Actions\CreateAction;

use Filament\Resources\Pages\ListRecords;


class ListTrxPabxAssignments extends ListRecords
{
    protected static string $resource =
        TrxPabxAssignmentResource::class;


    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make(),

        ];
    }
}
