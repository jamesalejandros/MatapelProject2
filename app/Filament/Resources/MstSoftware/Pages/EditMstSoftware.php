<?php

namespace App\Filament\Resources\MstSoftware\Pages;

use App\Filament\Resources\MstSoftware\MstSoftwareResource;
use App\Filament\Widgets\SoftwareLicenseSummary;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

use Livewire\Attributes\On;


class EditMstSoftware extends EditRecord
{
    protected static string $resource =
        MstSoftwareResource::class;


    /**
     * ==========================================================
     * HEADER WIDGETS
     * ==========================================================
     *
     * Widget statistik license dapat diaktifkan kembali
     * apabila diperlukan.
     */

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         SoftwareLicenseSummary::class,
    //     ];
    // }


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

            Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(function () {

                    $this->record->refresh();

                    $this->fillForm();

                    $this->dispatch(
                        'refreshSoftware'
                    );

                    Notification::make()
                        ->title(
                            'Data berhasil diperbarui'
                        )
                        ->body(
                            'Data software dan statistik license telah diperbarui.'
                        )
                        ->success()
                        ->send();

                }),


            /**
             * ==================================================
             * DELETE
             * ==================================================
             *
             * Delete hanya boleh dilakukan apabila user memiliki:
             *
             * mstsoftware.delete
             *
             * Permission update TIDAK otomatis memberikan
             * permission delete.
             */

            DeleteAction::make()
                ->visible(
                    fn ($record) =>
                        MstSoftwareResource::canDelete($record)
                ),

        ];
    }


    /**
     * ==========================================================
     * REFRESH SOFTWARE
     * ==========================================================
     *
     * Listener untuk refresh data/widget software.
     */

    #[On('refreshSoftware')]
    public function refreshSoftware(): void
    {
        $this->record->refresh();

        $this->fillForm();
    }
}
