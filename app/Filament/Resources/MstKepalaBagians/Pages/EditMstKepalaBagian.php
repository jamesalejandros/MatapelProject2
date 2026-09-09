<?php

namespace App\Filament\Resources\MstKepalaBagians\Pages;

use App\Filament\Resources\MstKepalaBagians\MstKepalaBagianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstKepalaBagian extends EditRecord
{
    protected static string $resource =
        MstKepalaBagianResource::class;

    /*
    |--------------------------------------------------------------------------
    | HEADER ACTIONS
    |--------------------------------------------------------------------------
    */

    protected function getHeaderActions(): array
    {
        return [

            Actions\DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        MstKepalaBagianResource::canDelete(
                            $record
                        )
                        &&
                        $record->users()->doesntExist()
                        &&
                        $record->approvals()->doesntExist()
                )
                ->requiresConfirmation()
                ->modalHeading(
                    'Hapus Kepala Bagian'
                )
                ->modalDescription(
                    'Data Kepala Bagian yang dihapus tidak dapat dikembalikan.'
                ),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(
            'index'
        );
    }
}
