<?php

namespace App\Filament\Resources\MstSambungans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MstSambunganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('Rule')

                    ->label('Rule')

                    ->required()

                    ->maxLength(255),

            ]);
    }
}
