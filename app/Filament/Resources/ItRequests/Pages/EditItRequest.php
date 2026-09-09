<?php

namespace App\Filament\Resources\ItRequests\Pages;

use App\Filament\Resources\ItRequests\ItRequestResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;


class EditItRequest extends EditRecord
{
    protected static string $resource =
        ItRequestResource::class;


    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()

                ->visible(
                    fn ($record) =>
                        ItRequestResource::canDelete(
                            $record
                        )
                ),

        ];
    }
}
