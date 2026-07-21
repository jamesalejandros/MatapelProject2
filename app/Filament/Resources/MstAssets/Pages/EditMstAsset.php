<?php

namespace App\Filament\Resources\MstAssets\Pages;

use App\Filament\Resources\MstAssets\MstAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditMstAsset extends EditRecord
{
    protected static string $resource = MstAssetResource::class;

    #[On('refreshAssetForm')]
public function refreshAssetForm(): void
{
    $this->record->refresh();

    $this->fillForm();
}

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(fn () => redirect(request()->header('Referer'))),

            Actions\DeleteAction::make(),
        ];
    }
}