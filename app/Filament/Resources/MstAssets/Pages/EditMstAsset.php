<?php

namespace App\Filament\Resources\MstAssets\Pages;

use App\Filament\Resources\MstAssets\MstAssetResource;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Livewire\Attributes\On;


class EditMstAsset extends EditRecord
{
    protected static string $resource =
        MstAssetResource::class;


    /**
     * ==========================================================
     * REFRESH FORM
     * ==========================================================
     */

    #[On('refreshAssetForm')]
    public function refreshAssetForm(): void
    {
        $this->record->refresh();

        $this->fillForm();
    }


    /**
     * ==========================================================
     * MUTATE FORM DATA BEFORE SAVE
     * ==========================================================
     *
     * Paksa nilai Garansi menjadi 0 apabila kosong.
     */

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {

        if (
            ! isset($data['Garansi'])
            || $data['Garansi'] === null
            || $data['Garansi'] === ''
        ) {

            $data['Garansi'] = 0;
        }


        return $data;
    }


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     */

    protected function getHeaderActions(): array
    {
        return [

            /**
             * ==================================================
             * REFRESH
             * ==================================================
             */

            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(
                    fn () =>
                        redirect(
                            request()->header('Referer')
                        )
                ),


            /**
             * ==================================================
             * DELETE
             * ==================================================
             *
             * Delete hanya boleh dilakukan apabila user
             * memiliki permission:
             *
             * mstasset.delete
             *
             * Permission update TIDAK otomatis memberikan
             * permission delete.
             */

            Actions\DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        MstAssetResource::canDelete($record)
                ),

        ];
    }
}
