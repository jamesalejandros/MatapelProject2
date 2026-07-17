<?php

namespace App\Filament\Resources\MstSoftwareLicenses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MstSoftwareLicenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('IDSoftware')
                    ->label('Software')
                    ->relationship('software', 'NamaSoftware')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('IDPerusahaan')
                    ->label('Perusahaan')
                    ->relationship('perusahaan', 'NamaPerusahaan')
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('ProductKey')
                    ->label('Product Key')
                    ->columnSpanFull(),

                Select::make('TipeLisensi')
                    ->options([
                        'OEM' => 'OEM',
                        'Retail' => 'Retail',
                        'OLP' => 'OLP',
                        'Volume' => 'Volume',
                        'Subscription' => 'Subscription',
                    ]),

                TextInput::make('JumlahLisensi')
                    ->numeric()
                    ->default(1)
                    ->required(),

                Toggle::make('HasDVD')
                    ->label('DVD / Media Installer'),

                TextInput::make('Barcode'),

                TextInput::make('LokasiSimpan'),

                TextInput::make('TempatSimpan'),

                Select::make('StatusLisensi')
                    ->options([
                        'Active' => 'Active',
                        'Expired' => 'Expired',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active')
                    ->required(),
            ]);
    }
}
