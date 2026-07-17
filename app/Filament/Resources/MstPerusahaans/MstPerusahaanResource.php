<?php

namespace App\Filament\Resources\MstPerusahaans;

use App\Filament\Resources\MstPerusahaans\Pages\CreateMstPerusahaan;
use App\Filament\Resources\MstPerusahaans\Pages\EditMstPerusahaan;
use App\Filament\Resources\MstPerusahaans\Pages\ListMstPerusahaans;
use App\Filament\Resources\MstPerusahaans\Schemas\MstPerusahaanForm;
use App\Filament\Resources\MstPerusahaans\Tables\MstPerusahaansTable;
use App\Models\MstPerusahaan;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;


class MstPerusahaanResource extends Resource
{
    protected static ?string $model = MstPerusahaan::class;


    protected static ?string $navigationLabel = 'Perusahaan';


    protected static ?string $modelLabel = 'Perusahaan';


    protected static ?string $pluralModelLabel = 'Perusahaan';


    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';



    public static function form(Schema $schema): Schema
    {
        return MstPerusahaanForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return MstPerusahaansTable::configure($table);
    }


    public static function getRelations(): array
    {
        return [];
    }


    public static function getPages(): array
    {
        return [
            'index' => ListMstPerusahaans::route('/'),
            'create' => CreateMstPerusahaan::route('/create'),
            'edit' => EditMstPerusahaan::route('/{record}/edit'),
        ];
    }
}