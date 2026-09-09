<?php

namespace App\Filament\Resources\MstKepalaBagians;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\MstKepalaBagians\Pages\CreateMstKepalaBagian;
use App\Filament\Resources\MstKepalaBagians\Pages\EditMstKepalaBagian;
use App\Filament\Resources\MstKepalaBagians\Pages\ListMstKepalaBagians;
use App\Filament\Resources\MstKepalaBagians\Schemas\MstKepalaBagianForm;
use App\Filament\Resources\MstKepalaBagians\Tables\MstKepalaBagiansTable;
use App\Models\MstKepalaBagian;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstKepalaBagianResource extends BaseResource
{
    protected static ?string $model = MstKepalaBagian::class;

    protected static string $permissionPrefix =
        'mstkepalabagian';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-user-group';

    protected static ?string $navigationLabel =
        'Kepala Bagian';

    protected static ?string $modelLabel =
        'Kepala Bagian';

    protected static ?string $pluralModelLabel =
        'Kepala Bagian';

    protected static string|\UnitEnum|null $navigationGroup =
        'Master Data';

    public static function form(Schema $schema): Schema
    {
        return MstKepalaBagianForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstKepalaBagiansTable::configure($table);
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
            'index' => ListMstKepalaBagians::route('/'),
            'create' => CreateMstKepalaBagian::route('/create'),
            'edit' => EditMstKepalaBagian::route('/{record}/edit'),
        ];
    }
}
