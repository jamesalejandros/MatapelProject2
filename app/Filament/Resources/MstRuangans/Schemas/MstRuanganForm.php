<?php

namespace App\Filament\Resources\MstRuangans\Schemas;

use App\Models\MstLokasi;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;


class MstRuanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([


                TextInput::make('NamaRuangan')

                    ->label('Nama Ruangan')

                    ->required()

                    ->maxLength(100),



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
