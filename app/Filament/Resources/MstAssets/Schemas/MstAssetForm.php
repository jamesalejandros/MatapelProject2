<?php

namespace App\Filament\Resources\MstAssets\Schemas;


use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;


use App\Models\MstPerusahaan;
use App\Models\MstVendor;



class MstAssetForm
{

    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([


                TextInput::make('NoAssetIT')
                    ->label('No Asset IT')
                    ->required()
                    ->unique(ignoreRecord: true),



                TextInput::make('NoAssetSAP')
                    ->label('No Asset SAP'),



                TextInput::make('Jenis')
                    ->label('Jenis Asset'),



                TextInput::make('Nama')
                    ->label('Nama Asset'),



                TextInput::make('PN')
                    ->label('Part Number'),



                TextInput::make('SN')
                    ->label('Serial Number'),



                Select::make('IDPerusahaan')

                    ->label('Perusahaan')

                    ->relationship(
                        'perusahaan',
                        'NamaPerusahaan'
                    )

                    ->searchable()
                    ->preload()
                    ->required(),



                Select::make('IDVendor')

                    ->label('Vendor')

                    ->relationship(
                        'vendor',
                        'NamaVendor'
                    )

                    ->searchable()
                    ->preload(),



                DatePicker::make('TanggalBeli')
                    ->label('Tanggal Beli'),



                TextInput::make('Harga')
                    ->numeric()
                    ->prefix('Rp'),



                Select::make('StatusAsset')

                    ->options([

                        'Available' => 'Available',

                        'Used' => 'Used',

                        'In Service' => 'In Service',

                        'Retired' => 'Retired',

                    ])

                    ->default('Available'),


            ]);

    }

}