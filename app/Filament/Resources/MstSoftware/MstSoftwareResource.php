<?php

namespace App\Filament\Resources\MstSoftware;

use App\Filament\Resources\MstSoftware\Pages\CreateMstSoftware;
use App\Filament\Resources\MstSoftware\Pages\EditMstSoftware;
use App\Filament\Resources\MstSoftware\Pages\ListMstSoftware;
use App\Filament\Resources\MstSoftware\Schemas\MstSoftwareForm;
use App\Filament\Resources\MstSoftware\Tables\MstSoftwareTable;
use App\Models\MstSoftware;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Resources\MstSoftware\RelationManagers\LicenseRelationManager;
class MstSoftwareResource extends Resource
{
    protected static ?string $model = MstSoftware::class;

   protected static ?string $navigationLabel = 'Software';

   protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-code-bracket';

protected static ?string $modelLabel = 'Software';

protected static ?string $pluralModelLabel = 'Software';

protected static string|\UnitEnum|null $navigationGroup = 'Software Management';

    public static function form(Schema $schema): Schema
    {
        return MstSoftwareForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstSoftwareTable::configure($table);
    }

    public static function getRelations(): array
{
    return [
        LicenseRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => ListMstSoftware::route('/'),
            'create' => CreateMstSoftware::route('/create'),
            'edit' => EditMstSoftware::route('/{record}/edit'),
        ];
    }
}
