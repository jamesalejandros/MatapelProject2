<?php

namespace App\Filament\Resources\TrxIspBandwidths\Pages;

use App\Filament\Resources\TrxIspBandwidths\TrxIspBandwidthResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListTrxIspBandwidths extends ListRecords
{
    protected static string $resource =
        TrxIspBandwidthResource::class;


    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->label('Tambah Bandwidth')
                ->icon('heroicon-o-plus'),

        ];
    }
}
