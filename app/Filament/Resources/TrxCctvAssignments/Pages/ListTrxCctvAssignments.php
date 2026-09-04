<?php

namespace App\Filament\Resources\TrxCctvAssignments\Pages;

use App\Filament\Resources\TrxCctvAssignments\TrxCctvAssignmentResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListTrxCctvAssignments extends ListRecords
{
    protected static string $resource =
        TrxCctvAssignmentResource::class;


    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make(),

        ];
    }
}
