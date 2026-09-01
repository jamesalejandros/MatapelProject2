<?php

namespace App\Filament\Resources\TrxPabxAssignments;

use App\Filament\Resources\TrxPabxAssignments\Pages\CreateTrxPabxAssignment;
use App\Filament\Resources\TrxPabxAssignments\Pages\EditTrxPabxAssignment;
use App\Filament\Resources\TrxPabxAssignments\Pages\ListTrxPabxAssignments;

use App\Filament\Resources\TrxPabxAssignments\Schemas\TrxPabxAssignmentForm;
use App\Filament\Resources\TrxPabxAssignments\Tables\TrxPabxAssignmentsTable;

use App\Models\TrxPabxAssignment;

use BackedEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;


class TrxPabxAssignmentResource extends Resource
{
    protected static ?string $model = TrxPabxAssignment::class;


    protected static ?string $navigationLabel = 'PABX Assignment';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-phone';


    protected static ?string $modelLabel = 'PABX Assignment';


    protected static ?string $pluralModelLabel = 'PABX Assignment';


    protected static string|\UnitEnum|null $navigationGroup =
        'Asset Management';



    public static function form(Schema $schema): Schema
    {
        return TrxPabxAssignmentForm::configure($schema);
    }



    public static function table(Table $table): Table
    {
        return TrxPabxAssignmentsTable::configure($table);
    }



    public static function getPages(): array
    {
        return [

            'index' =>
                ListTrxPabxAssignments::route('/'),

            'create' =>
                CreateTrxPabxAssignment::route('/create'),

            'edit' =>
                EditTrxPabxAssignment::route('/{record}/edit'),

        ];
    }
}
