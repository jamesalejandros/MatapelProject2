<?php

namespace App\Filament\Resources\MstSoftware\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MstSoftwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                TextInput::make('KodeSoftwareCustom')
                    ->label('Kode Software')
                    ->required()
                    ->unique(ignoreRecord: true),


                TextInput::make('NamaSoftware')
                    ->label('Nama Software')
                    ->required()
                    ->maxLength(255),



                Select::make('SoftCategory')
                    ->label('Kategori')
                    ->options([
                        'Operating System' => 'Operating System',
                        'Productivity' => 'Productivity',
                        'ERP' => 'ERP',
                        'Database' => 'Database',
                        'Utility' => 'Utility',
                        'Security' => 'Security',
                    ])
                    ->searchable(),



                Select::make('Jenis')
                    ->label('Jenis Lisensi')
                    ->options([
                        'Commercial' => 'Commercial',
                        'Open Source' => 'Open Source',
                        'Freeware' => 'Freeware',
                    ]),



                TextInput::make('Version')
                    ->label('Version'),



                Toggle::make('Is32Bit')
                    ->label('32 Bit')
                    ->default(false),



                Toggle::make('Is64Bit')
                    ->label('64 Bit')
                    ->default(false),



                Textarea::make('Keterangan')
                    ->columnSpanFull(),

            ]);
    }
}