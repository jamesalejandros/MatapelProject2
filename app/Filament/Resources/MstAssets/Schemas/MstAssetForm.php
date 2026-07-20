<?php

namespace App\Filament\Resources\MstAssets\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class MstAssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Asset')
                    ->columns(2)
                    ->schema([

                        TextInput::make('NoAssetIT')
                            ->label('No Asset IT')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('NoAssetSAP')
                            ->label('No Asset SAP'),

                        TextInput::make('Jenis')
                            ->label('Jenis Asset')
                            ->required(),

                        TextInput::make('Nama')
                            ->label('Nama Asset')
                            ->required(),

                        TextInput::make('PN')
                            ->label('Part Number'),

                        TextInput::make('SN')
                            ->label('Serial Number'),

                        TextInput::make('PN_LCD')
                            ->label('Part Number LCD'),

                        TextInput::make('SN_LCD')
                            ->label('Serial Number LCD'),

                        TextInput::make('RAM')
                            ->label('RAM'),

                        Select::make('JenisOS')
                            ->label('Operating System')
                            ->options([
                                'Windows 11' => 'Windows 11',
                                'Windows 10' => 'Windows 10',
                                'Windows Server' => 'Windows Server',
                                'Linux' => 'Linux',
                                'Ubuntu' => 'Ubuntu',
                                'MacOS' => 'MacOS',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable(),

                        TextInput::make('ComputerName')
                            ->label('Computer Name'),

                        TextInput::make('IPAddress')
                            ->label('IP Address')
                            ->ip(),

                    ]),

                Section::make('Pembelian')
                    ->columns(2)
                    ->schema([

                        Select::make('StatusBeli')
                            ->label('Status Pembelian')
                            ->options([
                                'Baru' => 'Baru',
                                'Second' => 'Second',
                            ]),

                        DatePicker::make('TanggalBeli')
                            ->label('Tanggal Beli'),

                        TextInput::make('Harga')
                            ->label('Harga')
                            ->numeric()
                            ->prefix('Rp'),

                        Select::make('IDVendor')
                            ->label('Vendor')
                            ->relationship(
                                'vendor',
                                'NamaVendor'
                            )
                            ->searchable()
                            ->preload(),

                        Select::make('Garansi')
                            ->label('Garansi')
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ]),

                        DatePicker::make('DateWarranty')
                            ->label('Tanggal Berakhir Garansi'),

                    ]),

                Section::make('Perusahaan')
                    ->columns(2)
                    ->schema([

                        Select::make('IDPerusahaan')
                            ->label('Perusahaan')
                            ->relationship(
                                'perusahaan',
                                'NamaPerusahaan'
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('StatusAsset')
                            ->label('Status Asset')
                            ->options([
                                'Available' => 'Available',
                                'In Service' => 'In Service',
                                'Retired' => 'Retired',
                            ])
                            ->default('Available')
                            ->required(),

                    ]),
            ]);
    }
}