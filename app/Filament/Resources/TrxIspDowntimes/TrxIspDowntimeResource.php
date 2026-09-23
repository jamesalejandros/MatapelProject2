<?php

namespace App\Filament\Resources\TrxIspDowntimes;

use App\Filament\Resources\BaseResource;

use App\Filament\Resources\TrxIspDowntimes\Pages\CreateTrxIspDowntime;
use App\Filament\Resources\TrxIspDowntimes\Pages\EditTrxIspDowntime;
use App\Filament\Resources\TrxIspDowntimes\Pages\ListTrxIspDowntimes;

use App\Filament\Resources\TrxIspDowntimes\Schemas\TrxIspDowntimeForm;
use App\Filament\Resources\TrxIspDowntimes\Tables\TrxIspDowntimesTable;

use App\Models\TrxIspDowntime;

use BackedEnum;

use Filament\Schemas\Schema;
use Filament\Tables\Table;


class TrxIspDowntimeResource extends BaseResource
{
    protected static ?string $model =
        TrxIspDowntime::class;


    protected static string $permissionPrefix =
        'trxispdowntime';


    protected static ?string $navigationLabel =
        'Downtime ISP';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-exclamation-triangle';


    protected static ?string $modelLabel =
        'Downtime ISP';


    protected static ?string $pluralModelLabel =
        'Downtime ISP';


    protected static string|\UnitEnum|null $navigationGroup =
        'Network Management';


    public static function form(Schema $schema): Schema
    {
        return TrxIspDowntimeForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return TrxIspDowntimesTable::configure($table);
    }


    public static function getPages(): array
    {
        return [
            'index' =>
                ListTrxIspDowntimes::route('/'),

            'create' =>
                CreateTrxIspDowntime::route('/create'),

            'edit' =>
                EditTrxIspDowntime::route('/{record}/edit'),
        ];
    }
}
