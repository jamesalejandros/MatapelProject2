<?php

namespace App\Filament\Resources\MstLokasis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class MstLokasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('NamaLokasi')
                    ->label('Nama Lokasi')
                    ->required()
                    ->maxLength(100),

            ]);
    }
}