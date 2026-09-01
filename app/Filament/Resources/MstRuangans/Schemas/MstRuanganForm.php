<?php

namespace App\Filament\Resources\MstRuangans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;


class MstRuanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([


                /*
                |--------------------------------------------------------------------------
                | NAMA RUANGAN
                |--------------------------------------------------------------------------
                */

                TextInput::make('NamaRuangan')

                    ->label('Nama Ruangan')

                    ->required()

                    ->maxLength(100),



                /*
                |--------------------------------------------------------------------------
                | LANTAI
                |--------------------------------------------------------------------------
                */

                TextInput::make('Lantai')

                    ->label('Lantai')

                    ->maxLength(50)

                    ->nullable(),



                /*
                |--------------------------------------------------------------------------
                | LOKASI
                |--------------------------------------------------------------------------
                */

                Select::make('IDLokasi')

                    ->label('Lokasi')

                    ->relationship(
                        'lokasi',
                        'NamaLokasi'
                    )

                    ->searchable()

                    ->preload()

                    ->required(),


            ]);
    }
}
