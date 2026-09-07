<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\Resources\ActivityLogs\Tables\ActivityLogsTable;

use BackedEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Models\Activity;


class ActivityLogResource extends Resource
{
    protected static ?string $model =
        Activity::class;


    /**
     * ==========================================================
     * NAVIGATION
     * ==========================================================
     */

    protected static bool $shouldRegisterNavigation =
        true;


    protected static ?string $navigationLabel =
        'Activity History';


    protected static ?string $modelLabel =
        'Activity History';


    protected static ?string $pluralModelLabel =
        'Activity History';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-clock';


    protected static string|\UnitEnum|null $navigationGroup =
        'Administration';


    protected static ?int $navigationSort =
        2;


    /**
     * ==========================================================
     * AUTHORIZATION
     * ==========================================================
     */

    public static function canViewAny(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole(
                'super_admin'
            );
    }


    public static function canView(
        Model $record
    ): bool {

        return auth()->check()
            && auth()->user()->hasRole(
                'super_admin'
            );
    }


    public static function canCreate(): bool
    {
        return false;
    }


    public static function canEdit(
        Model $record
    ): bool {
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

        return $schema->components([]);
    }


    /**
     * ==========================================================
     * TABLE
     * ==========================================================
     */

    public static function table(
        Table $table
    ): Table {

        return ActivityLogsTable::configure(
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
                ListActivityLogs::route('/'),

        ];
    }
}
