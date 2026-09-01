<?php

namespace App\Filament\Resources\MstRuangans\Pages;

use App\Filament\Resources\MstRuangans\MstRuanganResource;

use Filament\Actions\DeleteAction;

use Filament\Resources\Pages\EditRecord;


class EditMstRuangan extends EditRecord
{
    protected static string $resource =
        MstRuanganResource::class;


    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make(),

        ];
    }
}
