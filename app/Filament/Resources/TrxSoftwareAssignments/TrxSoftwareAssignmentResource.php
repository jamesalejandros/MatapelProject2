<?php

namespace App\Filament\Resources\TrxSoftwareAssignments;

use App\Filament\Resources\BaseResource;

use App\Filament\Resources\TrxSoftwareAssignments\Pages\CreateTrxSoftwareAssignment;
use App\Filament\Resources\TrxSoftwareAssignments\Pages\EditTrxSoftwareAssignment;
use App\Filament\Resources\TrxSoftwareAssignments\Pages\ListTrxSoftwareAssignments;

use App\Filament\Resources\TrxSoftwareAssignments\Schemas\TrxSoftwareAssignmentForm;
use App\Filament\Resources\TrxSoftwareAssignments\Tables\TrxSoftwareAssignmentsTable;

use App\Models\TrxSoftwareAssignment;

use BackedEnum;

use Filament\Schemas\Schema;
use Filament\Tables\Table;


class TrxSoftwareAssignmentResource extends BaseResource
{
    protected static ?string $model =
        TrxSoftwareAssignment::class;


    /**
     * ==========================================================
     * PERMISSION
     * ==========================================================
     *
     * Permission:
     *
     * trxsoftwareassignment.view
     * trxsoftwareassignment.create
     * trxsoftwareassignment.update
     * trxsoftwareassignment.delete
     */
    protected static string $permissionPrefix =
        'trxsoftwareassignment';


    /**
     * ==========================================================
     * NAVIGATION
     * ==========================================================
     */

    protected static bool $shouldRegisterNavigation =
        true;


    protected static ?string $navigationLabel =
        'Software Assignment';


    protected static ?string $modelLabel =
        'Software Assignment';


    protected static ?string $pluralModelLabel =
        'Software Assignment';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-link';


    protected static string|\UnitEnum|null $navigationGroup =
        'Asset Management';


    protected static ?int $navigationSort =
        3;


    /**
     * ==========================================================
     * FORM
     * ==========================================================
     */

    public static function form(
        Schema $schema
    ): Schema {

        return TrxSoftwareAssignmentForm::configure(
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

        return TrxSoftwareAssignmentsTable::configure(
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
                ListTrxSoftwareAssignments::route('/'),

            'create' =>
                CreateTrxSoftwareAssignment::route('/create'),

            'edit' =>
                EditTrxSoftwareAssignment::route('/{record}/edit'),

        ];
    }
}
