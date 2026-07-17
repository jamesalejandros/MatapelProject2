<?php

namespace App\Filament\Resources\MstKaryawans\Tables;


use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;



class MstKaryawansTable
{

    public static function configure(Table $table): Table
    {

        return $table

            ->columns([


                TextColumn::make('NIK')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),



                TextColumn::make('Nama')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),



                TextColumn::make('perusahaan.NamaPerusahaan')
                    ->label('Perusahaan'),



                TextColumn::make('departemen.NamaDept')
                    ->label('Departemen'),


            ])


            ->actions([

                EditAction::make(),

                DeleteAction::make(),

            ]);

    }

}