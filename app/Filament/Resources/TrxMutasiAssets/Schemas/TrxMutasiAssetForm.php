<?php

namespace App\Filament\Resources\TrxMutasiAssets\Schemas;


use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;



class TrxMutasiAssetForm
{


    public static function configure(Schema $schema): Schema
    {

        return $schema->components([



            Select::make('IDAsset')

                ->label('Asset')

                ->relationship(
                    'asset',
                    'NoAssetIT'
                )

                ->searchable()
                ->preload()
                ->required(),




            Select::make('NIK')

                ->label('Karyawan')

                ->relationship(
                    'karyawan',
                    'Nama'
                )

                ->searchable([
                    'Nama',
                    'NIK'
                ])

                ->preload()

                ->required(),




            Select::make('IDLokasi')

                ->label('Lokasi')

                ->relationship(
                    'lokasi',
                    'NamaLokasi'
                )

                ->searchable()
                ->preload(),




            TextInput::make('NoTransferSAP')
                ->label('No Transfer SAP'),




            DateTimePicker::make('TanggalMutasi')
                ->default(now())
                ->required(),




            TextInput::make('AksesWebsite'),


            TextInput::make('AksesEmail'),



            TextInput::make('Lapor'),



            TextInput::make('Keterangan'),



        ]);

    }


}