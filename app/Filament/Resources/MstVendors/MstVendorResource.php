<?php

namespace App\Filament\Resources\MstVendors;

use App\Filament\Resources\MstVendors\Pages\CreateMstVendor;
use App\Filament\Resources\MstVendors\Pages\EditMstVendor;
use App\Filament\Resources\MstVendors\Pages\ListMstVendors;
use App\Filament\Resources\MstVendors\Schemas\MstVendorForm;
use App\Filament\Resources\MstVendors\Tables\MstVendorsTable;
use App\Models\MstVendor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstVendorResource extends Resource
{
    protected static ?string $model = MstVendor::class;

protected static ?string $navigationLabel = 'Vendor';

protected static ?string $modelLabel = 'Vendor';

protected static ?string $pluralModelLabel = 'Vendor';

protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return MstVendorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstVendorsTable::configure($table);
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
            'index' => ListMstVendors::route('/'),
            'create' => CreateMstVendor::route('/create'),
            'edit' => EditMstVendor::route('/{record}/edit'),
        ];
    }
}
