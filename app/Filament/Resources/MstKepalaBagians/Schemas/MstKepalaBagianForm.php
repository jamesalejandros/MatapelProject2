<?php

namespace App\Filament\Resources\MstKepalaBagians\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MstKepalaBagianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | NAMA
                |--------------------------------------------------------------------------
                */

                TextInput::make('name')
                    ->label('Nama Kepala Bagian')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                /*
                |--------------------------------------------------------------------------
                | EMAIL
                |--------------------------------------------------------------------------
                */

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(
                        ignoreRecord: true
                    )
                    ->maxLength(255),

                /*
                |--------------------------------------------------------------------------
                | PASSWORD
                |--------------------------------------------------------------------------
                */

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(
                        fn ($record) => $record === null
                    )
                    ->dehydrated(
                        fn ($state) => filled($state)
                    )
                    ->dehydrateStateUsing(
                        fn ($state) => filled($state)
                            ? bcrypt($state)
                            : null
                    )
                    ->minLength(8)
                    ->maxLength(255)
                    ->helperText(
                        fn ($record) =>
                            $record
                                ? 'Kosongkan jika password tidak ingin diubah.'
                                : 'Minimal 8 karakter.'
                    ),

            ]);
    }
}
