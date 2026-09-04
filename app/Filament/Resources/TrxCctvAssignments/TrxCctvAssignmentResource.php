<?php

namespace App\Filament\Resources\TrxCctvAssignments;

use App\Filament\Resources\TrxCctvAssignments\Pages\CreateTrxCctvAssignment;
use App\Filament\Resources\TrxCctvAssignments\Pages\EditTrxCctvAssignment;
use App\Filament\Resources\TrxCctvAssignments\Pages\ListTrxCctvAssignments;

use App\Filament\Resources\TrxCctvAssignments\Schemas\TrxCctvAssignmentForm;
use App\Filament\Resources\TrxCctvAssignments\Tables\TrxCctvAssignmentsTable;

use App\Models\TrxCctvAssignment;

use BackedEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;


class TrxCctvAssignmentResource extends Resource
{
    protected static ?string $model = TrxCctvAssignment::class;


    protected static ?string $navigationLabel = 'CCTV Assignment';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-video-camera';


    protected static ?string $modelLabel = 'CCTV Assignment';


    protected static ?string $pluralModelLabel = 'CCTV Assignment';


    protected static string|\UnitEnum|null $navigationGroup =
        'Asset Management';



    public static function form(Schema $schema): Schema
    {
        return TrxCctvAssignmentForm::configure($schema);
    }



    public static function table(Table $table): Table
    {
        return TrxCctvAssignmentsTable::configure($table);
    }



    public static function getPages(): array
    {
        return [

            'index' =>
                ListTrxCctvAssignments::route('/'),

            'create' =>
                CreateTrxCctvAssignment::route('/create'),

            'edit' =>
                EditTrxCctvAssignment::route('/{record}/edit'),

        ];
    }
}
