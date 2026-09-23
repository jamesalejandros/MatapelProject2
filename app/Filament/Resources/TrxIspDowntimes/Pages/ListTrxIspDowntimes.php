<?php

namespace App\Filament\Resources\TrxIspDowntimes\Pages;

use App\Filament\Resources\TrxIspDowntimes\TrxIspDowntimeResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListTrxIspDowntimes extends ListRecords
{
    protected static string $resource =
        TrxIspDowntimeResource::class;


    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->label('Tambah Downtime')
                ->icon('heroicon-o-plus'),

        ];
    }
}
