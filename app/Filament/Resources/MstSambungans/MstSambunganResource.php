<?php

namespace App\Filament\Resources\MstSambungans;

use App\Filament\Resources\MstSambungans\Pages\CreateMstSambungan;
use App\Filament\Resources\MstSambungans\Pages\EditMstSambungan;
use App\Filament\Resources\MstSambungans\Pages\ListMstSambungans;
use App\Filament\Resources\MstSambungans\Schemas\MstSambunganForm;
use App\Filament\Resources\MstSambungans\Tables\MstSambungansTable;
use App\Models\MstSambungan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstSambunganResource extends Resource
{
    protected static ?string $model = MstSambungan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Sambungan';

    protected static ?string $modelLabel = 'Sambungan';

    protected static ?string $pluralModelLabel = 'Sambungan';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';


    public static function form(Schema $schema): Schema
    {
        return MstSambunganForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return MstSambungansTable::configure($table);
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
            'index' => ListMstSambungans::route('/'),
            'create' => CreateMstSambungan::route('/create'),
            'edit' => EditMstSambungan::route('/{record}/edit'),
        ];
    }
}
