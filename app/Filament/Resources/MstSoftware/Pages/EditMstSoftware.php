<?php

namespace App\Filament\Resources\MstSoftware\Pages;

use App\Filament\Resources\MstSoftware\MstSoftwareResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditMstSoftware extends EditRecord
{
    protected static string $resource = MstSoftwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(function () {
                    // Refresh data record dari database
                    $this->record->refresh();

                    // Isi ulang seluruh form
                    $this->fillForm();

                    Notification::make()
                        ->title('Data berhasil diperbarui')
                        ->body('Data software dan license telah di-refresh.')
                        ->success()
                        ->send();
                }),

            DeleteAction::make(),
        ];
    }

    #[On('refreshSoftware')]
    public function refreshSoftware(): void
    {
        $this->record->refresh();
        $this->fillForm();
    }
}