<?php

namespace App\Filament\Resources\TrxIspBandwidths\Pages;

use App\Filament\Resources\TrxIspBandwidths\TrxIspBandwidthResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditTrxIspBandwidth extends EditRecord
{
    protected static string $resource =
        TrxIspBandwidthResource::class;


    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make(),

        ];
    }
}
