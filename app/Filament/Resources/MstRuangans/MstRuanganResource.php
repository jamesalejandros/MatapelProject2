<?php

namespace App\Filament\Resources\MstRuangans;

use App\Filament\Resources\MstRuangans\Pages\CreateMstRuangan;
use App\Filament\Resources\MstRuangans\Pages\EditMstRuangan;
use App\Filament\Resources\MstRuangans\Pages\ListMstRuangans;

use App\Filament\Resources\MstRuangans\Schemas\MstRuanganForm;
use App\Filament\Resources\MstRuangans\Tables\MstRuangansTable;

use App\Models\MstRuangan;

use BackedEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;


class MstRuanganResource extends Resource
{
    protected static ?string $model = MstRuangan::class;


    protected static ?string $navigationLabel = 'Ruangan';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-building-office-2';


    protected static ?string $modelLabel = 'Ruangan';


    protected static ?string $pluralModelLabel = 'Ruangan';


    protected static string|\UnitEnum|null $navigationGroup =
        'Master Data';



    public static function form(Schema $schema): Schema
    {
        return MstRuanganForm::configure($schema);
    }



    public static function table(Table $table): Table
    {
        return MstRuangansTable::configure($table);
    }



    public static function getRelations(): array
    {
        return [];
    }



    public static function getPages(): array
    {
        return [

            'index' =>
                ListMstRuangans::route('/'),

            'create' =>
                CreateMstRuangan::route('/create'),

            'edit' =>
                EditMstRuangan::route('/{record}/edit'),

        ];
    }
}
