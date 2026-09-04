<?php

namespace App\Filament\Resources\TrxCctvAssignments\Schemas;

use App\Models\MstAsset;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Schemas\Schema;


class TrxCctvAssignmentForm
{
    public static function configure(
        Schema $schema
    ): Schema {

        return $schema

            ->components([


                /*
                |--------------------------------------------------------------------------
                | ASSET
                |--------------------------------------------------------------------------
                */

                Select::make('NoAssetIT')

                    ->label('Asset')

                    ->options(

                        MstAsset::query()

                            ->where('Jenis', 'CCTV')

                            ->orderBy('NoAssetIT')

                            ->get()

                            ->mapWithKeys(
                                function ($asset) {

                                    return [

                                        $asset->NoAssetIT =>

                                            $asset->NoAssetIT
                                            . ' | '
                                            . ($asset->Nama ?? '-'),

                                    ];

                                }
                            )

                    )

                    ->searchable()

                    ->preload()

                    ->required(),


                /*
                |--------------------------------------------------------------------------
                | CHANNEL
                |--------------------------------------------------------------------------
                */

                TextInput::make('Channel')

                    ->label('Channel')

                    ->required()

                    ->maxLength(50),


                /*
                |--------------------------------------------------------------------------
                | JENIS CCTV
                |--------------------------------------------------------------------------
                */

                Select::make('Jenis')

                    ->label('Jenis CCTV')

                    ->options([

                        'IP' =>
                            'IP',

                        'Analog' =>
                            'Analog',

                    ])

                    ->required(),


                /*
                |--------------------------------------------------------------------------
                | TANGGAL PASANG
                |--------------------------------------------------------------------------
                */

                DatePicker::make('TanggalPasang')

                    ->label('Tanggal Pasang')

                    ->native(false)

                    ->displayFormat('d/m/Y')

                    ->format('Y-m-d')
                    ->suffixIcon('heroicon-m-calendar-days')

                    ->nullable(),


                /*
                |--------------------------------------------------------------------------
                | TIPE
                |--------------------------------------------------------------------------
                */

                TextInput::make('Tipe')

                    ->label('Tipe')

                    ->maxLength(100)

                    ->nullable(),


                /*
                |--------------------------------------------------------------------------
                | KONDISI
                |--------------------------------------------------------------------------
                */

                TextInput::make('Kondisi')

                    ->label('Kondisi')

                    ->maxLength(100)

                    ->nullable(),


                /*
                |--------------------------------------------------------------------------
                | KETERANGAN
                |--------------------------------------------------------------------------
                */

                Textarea::make('Keterangan')

                    ->label('Keterangan')

                    ->rows(5)

                    ->columnSpanFull()

                    ->nullable(),


            ]);

    }
}
