<?php

namespace App\Filament\Resources\MstPerusahaans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MstPerusahaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('NamaPerusahaan')
                    ->label('Nama Perusahaan')
                    ->required()
                    ->maxLength(100),

            ]);
    }
}