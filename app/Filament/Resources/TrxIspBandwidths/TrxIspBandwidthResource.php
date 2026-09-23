<?php

namespace App\Filament\Resources\TrxIspBandwidths;

use App\Filament\Resources\BaseResource;

use App\Filament\Resources\TrxIspBandwidths\Pages\CreateTrxIspBandwidth;
use App\Filament\Resources\TrxIspBandwidths\Pages\EditTrxIspBandwidth;
use App\Filament\Resources\TrxIspBandwidths\Pages\ListTrxIspBandwidths;

use App\Filament\Resources\TrxIspBandwidths\Schemas\TrxIspBandwidthForm;
use App\Filament\Resources\TrxIspBandwidths\Tables\TrxIspBandwidthsTable;

use App\Models\TrxIspBandwidth;

use BackedEnum;

use Filament\Schemas\Schema;
use Filament\Tables\Table;


class TrxIspBandwidthResource extends BaseResource
{
    protected static ?string $model =
        TrxIspBandwidth::class;


    protected static string $permissionPrefix =
        'trxispbandwidth';


    protected static ?string $navigationLabel =
        'Bandwidth ISP';


    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-signal';


    protected static ?string $modelLabel =
        'Bandwidth ISP';


    protected static ?string $pluralModelLabel =
        'Bandwidth ISP';


    protected static string|\UnitEnum|null $navigationGroup =
        'Network Management';


    public static function form(Schema $schema): Schema
    {
        return TrxIspBandwidthForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return TrxIspBandwidthsTable::configure($table);
    }


    public static function getPages(): array
    {
        return [
            'index' =>
                ListTrxIspBandwidths::route('/'),

            'create' =>
                CreateTrxIspBandwidth::route('/create'),

            'edit' =>
                EditTrxIspBandwidth::route('/{record}/edit'),
        ];
    }
}
