<?php

namespace App\Filament\Resources\MstIsp;

use App\Filament\Resources\BaseResource;

use App\Filament\Resources\MstIsp\Pages\CreateMstIsp;
use App\Filament\Resources\MstIsp\Pages\EditMstIsp;
use App\Filament\Resources\MstIsp\Pages\ListMstIsp;

use App\Filament\Resources\MstIsp\RelationManagers\BandwidthRelationManager;
use App\Filament\Resources\MstIsp\RelationManagers\DowntimeRelationManager;

use App\Filament\Resources\MstIsp\Schemas\MstIspForm;
use App\Filament\Resources\MstIsp\Tables\MstIspTable;

use App\Models\MstIsp;

use BackedEnum;

use Filament\Schemas\Schema;
use Filament\Tables\Table;


class MstIspResource extends BaseResource
{
    protected static ?string $model = MstIsp::class;

    protected static string $permissionPrefix =
        'mstisp';

    protected static ?string $navigationLabel =
        'ISP';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-globe-alt';

    protected static ?string $modelLabel =
        'ISP';

    protected static ?string $pluralModelLabel =
        'ISP';

    protected static string|\UnitEnum|null $navigationGroup =
        'Network Management';


    public static function form(Schema $schema): Schema
    {
        return MstIspForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return MstIspTable::configure($table);
    }


    public static function getRelations(): array
    {
        return [
            BandwidthRelationManager::class,
            DowntimeRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' =>
                ListMstIsp::route('/'),

            'create' =>
                CreateMstIsp::route('/create'),

            'edit' =>
                EditMstIsp::route('/{record}/edit'),
        ];
    }
}
