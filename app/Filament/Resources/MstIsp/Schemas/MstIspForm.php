<?php

namespace App\Filament\Resources\MstIsp\Schemas;

use App\Models\MstLokasi;
use App\Models\MstVendor;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class MstIspForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi ISP')
                    ->description(
                        'Informasi utama mengenai penyedia layanan internet.'
                    )
                    ->schema([

                        TextInput::make('ISPCode')
                            ->label('Kode ISP')
                            ->required()
                            ->maxLength(50)
                            ->unique(
                                table: 'mstisp',
                                column: 'ISPCode',
                                ignoreRecord: true
                            )
                            ->placeholder('Contoh: ISP-001')
                            ->columnSpan(1),

                        Select::make('ConnectionType')
                            ->label('Tipe Koneksi')
                            ->options([
                                'PRIMARY' => 'Primary',
                                'BACKUP' => 'Backup',
                            ])
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->placeholder('Pilih tipe koneksi')
                            ->columnSpan(1),

                        TextInput::make('NamaISP')
                            ->label('Nama Paket')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Contoh: Paket Internet')
                            ->columnSpan(1),

                        Select::make('IDVendor')
                            ->label('Vendor')
                            ->relationship(
                                name: 'vendor',
                                titleAttribute: 'NamaVendor'
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih vendor')
                            ->columnSpan(1),

                        Select::make('IDLokasi')
                            ->label('Lokasi')
                            ->relationship(
                                name: 'lokasi',
                                titleAttribute: 'NamaLokasi'
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih lokasi')
                            ->columnSpan(1),

                        Select::make('MediaType')
                            ->label('Media')
                            ->options([
                                'Fiber Optic' => 'Fiber Optic',
                                'Wireless' => 'Wireless',
                            ])
                            ->searchable()
                            ->native(false)
                            ->placeholder('Pilih jenis media')
                            ->columnSpan(1),

                    ])
                    ->columns(3),


                Section::make('Kontrak')
                    ->description(
                        'Informasi periode dan SLA kontrak ISP.'
                    )
                    ->schema([

                        DatePicker::make('ContractStart')
                            ->label('Mulai Kontrak')
                            ->displayFormat('d M Y')
                            ->format('Y-m-d'),

                        DatePicker::make('ContractEnd')
                            ->label('Berakhir Kontrak')
                            ->displayFormat('d M Y')
                            ->format('Y-m-d')
                            ->afterOrEqual('ContractStart'),

                        TextInput::make('ContractPeriodMonth')
                            ->label('Periode Kontrak')
                            ->numeric()
                            ->minValue(1)
                            ->suffix('bulan')
                            ->placeholder('Contoh: 12'),

                        TextInput::make('SLA')
                            ->label('SLA')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.01)
                            ->suffix('%')
                            ->placeholder('Contoh: 99.90'),

                    ])
                    ->columns(4),


                Section::make('Status ISP')
                    ->schema([

                        Toggle::make('IsActive')
                            ->label('ISP Aktif')
                            ->default(true)
                            ->inline(false),

                    ])
                    ->columns(1),


                Section::make('Keterangan')
                    ->schema([

                        Textarea::make('Keterangan')
                            ->label('Keterangan')
                            ->rows(4)
                            ->placeholder(
                                'Masukkan keterangan tambahan...'
                            )
                            ->columnSpanFull(),

                    ]),

            ]);
    }
}
