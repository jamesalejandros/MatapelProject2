<?php

namespace App\Filament\Resources\MstJenisPermintaans\Pages;

use App\Filament\Resources\MstJenisPermintaans\MstJenisPermintaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstJenisPermintaan extends EditRecord
{
    protected static string $resource =
        MstJenisPermintaanResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        MstJenisPermintaanResource::canDelete(
                            $record
                        )
                ),

        ];
    }
}
