<?php

namespace App\Filament\Resources\MstKaryawans;

use App\Filament\Resources\MstKaryawans\Pages\CreateMstKaryawan;
use App\Filament\Resources\MstKaryawans\Pages\EditMstKaryawan;
use App\Filament\Resources\MstKaryawans\Pages\ListMstKaryawans;
use App\Filament\Resources\MstKaryawans\Schemas\MstKaryawanForm;
use App\Filament\Resources\MstKaryawans\Tables\MstKaryawansTable;
use App\Models\MstKaryawan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstKaryawanResource extends Resource
{
    protected static ?string $model = MstKaryawan::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

protected static ?string $navigationLabel = 'Karyawan';

protected static ?string $modelLabel = 'Karyawan';

protected static ?string $pluralModelLabel = 'Karyawan';

protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return MstKaryawanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstKaryawansTable::configure($table);
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
            'index' => ListMstKaryawans::route('/'),
            'create' => CreateMstKaryawan::route('/create'),
            'edit' => EditMstKaryawan::route('/{record}/edit'),
        ];
    }
}
