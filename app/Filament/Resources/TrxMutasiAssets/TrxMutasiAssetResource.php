<?php

namespace App\Filament\Resources\TrxMutasiAssets;

use App\Filament\Resources\TrxMutasiAssets\Pages\CreateTrxMutasiAsset;
use App\Filament\Resources\TrxMutasiAssets\Pages\EditTrxMutasiAsset;
use App\Filament\Resources\TrxMutasiAssets\Pages\ListTrxMutasiAssets;
use App\Filament\Resources\TrxMutasiAssets\Schemas\TrxMutasiAssetForm;
use App\Filament\Resources\TrxMutasiAssets\Tables\TrxMutasiAssetsTable;
use App\Models\TrxMutasiAsset;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\MstAssets\RelationManagers;

class TrxMutasiAssetResource extends Resource
{
    protected static ?string $model = TrxMutasiAsset::class;
    protected static bool $shouldRegisterNavigation = false;

protected static ?string $navigationLabel = 'Mutasi Asset';


protected static ?string $modelLabel = 'Mutasi Asset';


protected static ?string $pluralModelLabel = 'Mutasi Asset';


protected static string|\UnitEnum|null $navigationGroup 
= 'Asset Management';

    public static function form(Schema $schema): Schema
    {
        return TrxMutasiAssetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrxMutasiAssetsTable::configure($table);
    }

    public static function getRelations(): array
{
    return [
        RelationManagers\MutasiAssetRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => ListTrxMutasiAssets::route('/'),
            'create' => CreateTrxMutasiAsset::route('/create'),
            'edit' => EditTrxMutasiAsset::route('/{record}/edit'),
        ];
    }
}
