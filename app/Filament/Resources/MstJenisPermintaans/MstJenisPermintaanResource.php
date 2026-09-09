<?php

namespace App\Filament\Resources\MstJenisPermintaans;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\MstJenisPermintaans\Pages\CreateMstJenisPermintaan;
use App\Filament\Resources\MstJenisPermintaans\Pages\EditMstJenisPermintaan;
use App\Filament\Resources\MstJenisPermintaans\Pages\ListMstJenisPermintaans;
use App\Filament\Resources\MstJenisPermintaans\Schemas\MstJenisPermintaanForm;
use App\Filament\Resources\MstJenisPermintaans\Tables\MstJenisPermintaansTable;
use App\Models\MstJenisPermintaan;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MstJenisPermintaanResource extends BaseResource
{
    protected static ?string $model = MstJenisPermintaan::class;

    protected static string $permissionPrefix = 'mstjenispermintaan';

    protected static ?string $navigationLabel = 'Jenis Permintaan';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Jenis Permintaan';

    protected static ?string $pluralModelLabel = 'Jenis Permintaan';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return MstJenisPermintaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstJenisPermintaansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMstJenisPermintaans::route('/'),
            'create' => CreateMstJenisPermintaan::route('/create'),
            'edit' => EditMstJenisPermintaan::route('/{record}/edit'),
        ];
    }
}
