<?php

namespace App\Filament\Resources\MstDepartemens;

use App\Filament\Resources\MstDepartemens\Pages\CreateMstDepartemen;
use App\Filament\Resources\MstDepartemens\Pages\EditMstDepartemen;
use App\Filament\Resources\MstDepartemens\Pages\ListMstDepartemens;
use App\Filament\Resources\MstDepartemens\Schemas\MstDepartemenForm;
use App\Filament\Resources\MstDepartemens\Tables\MstDepartemensTable;
use App\Models\MstDepartemen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstDepartemenResource extends Resource
{
    protected static ?string $model = MstDepartemen::class;

protected static ?string $navigationLabel = 'Departemen';


protected static ?string $modelLabel = 'Departemen';


protected static ?string $pluralModelLabel = 'Departemen';


protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return MstDepartemenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstDepartemensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMstDepartemens::route('/'),
            'create' => CreateMstDepartemen::route('/create'),
            'edit' => EditMstDepartemen::route('/{record}/edit'),
        ];
    }
}
