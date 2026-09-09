<?php

namespace App\Filament\Resources\ItRequests\Pages;

use App\Filament\Resources\ItRequests\ItRequestResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListItRequests extends ListRecords
{
    protected static string $resource =
        ItRequestResource::class;


    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()

                ->visible(
                    fn () =>
                        ItRequestResource::canCreate()
                ),

        ];
    }
}
