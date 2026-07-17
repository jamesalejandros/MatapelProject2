<?php

namespace App\Filament\Resources\MstPerusahaans\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class MstPerusahaansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('NamaPerusahaan')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable(),

            ])
            ->actions([

                EditAction::make(),

                DeleteAction::make(),

            ]);
    }
}