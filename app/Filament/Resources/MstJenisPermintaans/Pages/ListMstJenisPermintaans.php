<?php

namespace App\Filament\Resources\MstJenisPermintaans\Pages;

use App\Filament\Resources\MstJenisPermintaans\MstJenisPermintaanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstJenisPermintaans extends ListRecords
{
    protected static string $resource =
        MstJenisPermintaanResource::class;

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->visible(
                    fn () =>
                        MstJenisPermintaanResource::canCreate()
                ),

        ];
    }
}
