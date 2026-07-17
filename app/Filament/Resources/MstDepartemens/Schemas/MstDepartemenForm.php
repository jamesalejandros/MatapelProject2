<?php

namespace App\Filament\Resources\MstDepartemens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class MstDepartemenForm
{

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('NamaDept')
                    ->label('Nama Departemen')
                    ->required()
                    ->maxLength(100),

            ]);
    }

}