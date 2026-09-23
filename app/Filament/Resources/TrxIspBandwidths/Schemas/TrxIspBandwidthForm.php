<?php

namespace App\Filament\Resources\TrxIspBandwidths\Schemas;

use App\Filament\Forms\Components\CurrencyInput;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Schemas\Schema;


class TrxIspBandwidthForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('IDISP')
    ->label('ISP')
    ->relationship(
        name: 'isp',
        titleAttribute: 'NamaISP'
    )
    ->getOptionLabelFromRecordUsing(
        fn ($record): string =>
            ($record->vendor?->NamaVendor ?? '-') . ' - ' . $record->NamaISP
    )
    ->searchable()
    ->preload()
    ->required()
    ->native(false),


                DatePicker::make('TanggalUpgrade')
                    ->label('Tanggal Upgrade')
                    ->required()
                    ->displayFormat('d M Y')
                    ->format('Y-m-d'),

                TextInput::make('BandwidthInternasional')
                    ->label('Bandwidth Internasional')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->suffix('Mbps'),

                TextInput::make('BandwidthLokal')
                    ->label('Bandwidth Lokal')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->suffix('Mbps'),

                CurrencyInput::make('Harga')
                    ->required()
                    ->label('Harga'),

                Select::make('Status')
                    ->label('Status')
                    ->options([
                        'ACTIVE' => 'Active',
                        'INACTIVE' => 'Inactive',
                    ])
                    ->default('ACTIVE')
                    ->required()
                    ->native(false),

                Textarea::make('Keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->columnSpanFull(),

            ]);
    }
}
