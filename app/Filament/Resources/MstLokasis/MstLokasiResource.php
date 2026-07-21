<?php

namespace App\Filament\Resources\MstLokasis;

use App\Filament\Resources\MstLokasis\Pages\CreateMstLokasi;
use App\Filament\Resources\MstLokasis\Pages\EditMstLokasi;
use App\Filament\Resources\MstLokasis\Pages\ListMstLokasis;
use App\Filament\Resources\MstLokasis\Schemas\MstLokasiForm;
use App\Filament\Resources\MstLokasis\Tables\MstLokasisTable;
use App\Models\MstLokasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstLokasiResource extends Resource
{
    protected static ?string $model = MstLokasi::class;

protected static ?string $navigationLabel = 'Lokasi';

protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

protected static ?string $modelLabel = 'Lokasi';

protected static ?string $pluralModelLabel = 'Lokasi';

protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return MstLokasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstLokasisTable::configure($table);
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
            'index' => ListMstLokasis::route('/'),
            'create' => CreateMstLokasi::route('/create'),
            'edit' => EditMstLokasi::route('/{record}/edit'),
        ];
    }
}
