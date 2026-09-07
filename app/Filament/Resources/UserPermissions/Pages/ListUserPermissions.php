<?php

namespace App\Filament\Resources\UserPermissions\Pages;

use App\Filament\Resources\UserPermissions\UserPermissionResource;

use Filament\Resources\Pages\ListRecords;


class ListUserPermissions extends ListRecords
{
    protected static string $resource =
        UserPermissionResource::class;


    protected function getHeaderActions(): array
    {
        return [];
    }
}
