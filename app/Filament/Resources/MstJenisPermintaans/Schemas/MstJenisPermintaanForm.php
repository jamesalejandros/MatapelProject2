<?php

namespace App\Filament\Resources\MstJenisPermintaans\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MstJenisPermintaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Nama Jenis Permintaan')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Contoh: Hardware'),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4)
                    ->maxLength(500)
                    ->placeholder('Keterangan jenis permintaan (opsional)')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText(
                        'Jenis permintaan yang tidak aktif tidak dapat digunakan untuk permintaan IT baru.'
                    ),

            ]);
    }
}
