<?php

namespace App\Filament\Resources\MstVendors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class MstVendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('NamaVendor')
                    ->label('Nama Vendor')
                    ->required()
                    ->maxLength(255),


                TextInput::make('Kontak')
                    ->label('Kontak')
                    ->maxLength(100),

            ]);
    }
}