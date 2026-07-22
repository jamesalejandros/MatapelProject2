<?php

namespace App\Filament\Resources\MstSoftware\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;


class MstSoftwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                TextInput::make('KodeSoftwareCustom')
                    ->label('Kode Software')
                    ->required()
                    ->unique(ignoreRecord: true),



                TextInput::make('NamaSoftware')
                    ->label('Nama Software')
                    ->required()
                    ->maxLength(255),



                TextInput::make('SoftCategory')
                    ->label('Kategori')
                    ->required()
                    ->datalist(
                        \App\Models\MstSoftware::query()
                            ->whereNotNull('SoftCategory')
                            ->where('SoftCategory', '!=', '')
                            ->distinct()
                            ->orderBy('SoftCategory')
                            ->pluck('SoftCategory')
                            ->toArray()
                    )
                    ->autocomplete('off'),



                Select::make('Jenis')
                    ->label('Jenis Lisensi')
                    ->options([
                        'Commercial' => 'Commercial',
                        'Open Source' => 'Open Source',
                        'Freeware' => 'Freeware',
                    ]),



                TextInput::make('Version')
                    ->label('Version'),



                Toggle::make('Is32Bit')
                    ->label('32 Bit')
                    ->default(false),



                Toggle::make('Is64Bit')
                    ->label('64 Bit')
                    ->default(false),



                Textarea::make('Keterangan')
                    ->label('Keterangan')
                    ->columnSpanFull(),




                Repeater::make('license')
                    ->label('PRODUCT KEY / LICENSE')

                    ->relationship()

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



                        Textarea::make('ProductKey')
                            ->label('Product Key')
                            ->rows(2)
                            ->required()
                            ->columnSpanFull(),



                        Select::make('TipeLisensi')
                            ->label('Tipe Lisensi')
                            ->options([
                                'OEM' => 'OEM',
                                'Retail' => 'Retail',
                                'OLP' => 'OLP',
                                'Volume' => 'Volume',
                                'Subscription' => 'Subscription',
                            ])
                            ->required(),



                        TextInput::make('JumlahLisensi')
                            ->label('Jumlah License')
                            ->numeric()
                            ->default(1)
                            ->required(),



                        Toggle::make('HasDVD')
                            ->label('DVD Installer')
                            ->default(false),



                        TextInput::make('Barcode')
                            ->label('Barcode'),



                        TextInput::make('LokasiSimpan')
                            ->label('Lokasi Simpan'),



                        TextInput::make('TempatSimpan')
                            ->label('Tempat Simpan'),



                        Select::make('StatusLisensi')
                            ->label('Status')
                            ->options([
                                'Active' => 'Active',
                                'Expired' => 'Expired',
                                'Inactive' => 'Inactive',
                            ])
                            ->default('Active')
                            ->required(),


                    ])

                    ->columns(2)

                    ->collapsed()

                    ->defaultItems(1)

                    ->addActionLabel('Tambah Product Key')

                    ->columnSpanFull(),


            ]);
    }
}
