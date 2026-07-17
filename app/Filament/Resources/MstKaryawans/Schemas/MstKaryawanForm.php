<?php

namespace App\Filament\Resources\MstKaryawans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

use App\Models\MstPerusahaan;
use App\Models\MstDepartemen;


class MstKaryawanForm
{

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                TextInput::make('NIK')
                    ->label('NIK')
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->maxLength(50),



                TextInput::make('Nama')
                    ->label('Nama Karyawan')
                    ->required()
                    ->maxLength(255),



                Select::make('IDPerusahaan')
                    ->label('Perusahaan')

                    ->relationship(
                        'perusahaan',
                        'NamaPerusahaan'
                    )

                    ->searchable()
                    ->preload()
                    ->required(),



                Select::make('IDDept')
                    ->label('Departemen')

                    ->relationship(
                        'departemen',
                        'NamaDept'
                    )

                    ->searchable()
                    ->preload()
                    ->required(),


            ]);
    }

}