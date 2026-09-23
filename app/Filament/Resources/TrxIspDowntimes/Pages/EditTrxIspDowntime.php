<?php

namespace App\Filament\Resources\TrxIspDowntimes\Pages;

use App\Filament\Resources\TrxIspDowntimes\TrxIspDowntimeResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxIspDowntime extends EditRecord
{
    protected static string $resource =
        TrxIspDowntimeResource::class;


    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make(),

        ];
    }
}
