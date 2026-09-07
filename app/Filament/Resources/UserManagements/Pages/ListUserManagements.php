<?php

namespace App\Filament\Resources\UserManagements\Pages;

use App\Filament\Resources\UserManagements\UserManagementResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListUserManagements extends ListRecords
{
    protected static string $resource =
        UserManagementResource::class;


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     */

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()

                ->label('Tambah User')

                ->visible(
                    fn (): bool =>
                        UserManagementResource::canCreate()
                ),

        ];
    }
}
