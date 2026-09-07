<?php

namespace App\Filament\Resources\UserPermissions;

use App\Filament\Resources\UserPermissions\Pages\CreateUserPermission;
use App\Filament\Resources\UserPermissions\Pages\EditUserPermission;
use App\Filament\Resources\UserPermissions\Pages\ListUserPermissions;
use App\Filament\Resources\UserPermissions\Schemas\UserPermissionForm;
use App\Filament\Resources\UserPermissions\Tables\UserPermissionsTable;
use App\Models\User;

use BackedEnum;

use App\Filament\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;


class UserPermissionResource extends BaseResource
{
    protected static ?string $model = User::class;


    /**
     * ==========================================================
     * NAVIGATION
     * ==========================================================
     */

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel =
        'User Permissions';

    protected static ?string $modelLabel =
        'User Permission';

    protected static ?string $pluralModelLabel =
        'User Permissions';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup =
        'Administration';

    protected static ?int $navigationSort = 1;


    /**
     * ==========================================================
     * AUTHORIZATION
     * ==========================================================
     *
     * Halaman ini khusus untuk super_admin.
     *
     * Jangan menggunakan BaseResource di sini karena
     * UserPermission bukan resource CRUD biasa.
     */

    public static function canViewAny(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole('super_admin');
    }


    public static function canView(
        Model $record
    ): bool {
        return auth()->check()
            && auth()->user()->hasRole('super_admin');
    }


    public static function canEdit(
        Model $record
    ): bool {
        return auth()->check()
            && auth()->user()->hasRole('super_admin')
            && ! $record->hasRole('super_admin');
    }


    /**
     * Tidak digunakan untuk membuat user.
     *
     * User dibuat melalui UserSeeder / User Management.
     */
    public static function canCreate(): bool
    {
        return false;
    }


    public static function canDelete(
        Model $record
    ): bool {
        return false;
    }


    public static function canDeleteAny(): bool
    {
        return false;
    }


    /**
     * ==========================================================
     * FORM
     * ==========================================================
     */

    public static function form(
        Schema $schema
    ): Schema {
        return UserPermissionForm::configure(
            $schema
        );
    }


    /**
     * ==========================================================
     * TABLE
     * ==========================================================
     */

    public static function table(
        Table $table
    ): Table {
        return UserPermissionsTable::configure(
            $table
        );
    }


    /**
     * ==========================================================
     * RELATIONS
     * ==========================================================
     */

    public static function getRelations(): array
    {
        return [];
    }


    /**
     * ==========================================================
     * PAGES
     * ==========================================================
     */

    public static function getPages(): array
    {
        return [

            'index' =>
                ListUserPermissions::route('/'),

            'create' =>
                CreateUserPermission::route('/create'),

            'edit' =>
                EditUserPermission::route('/{record}/edit'),

        ];
    }
}
