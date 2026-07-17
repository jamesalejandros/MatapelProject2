<?php

namespace App\Filament\Resources\MstDepartemens\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class MstDepartemensTable
{

    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('NamaDept')
                    ->label('Nama Departemen')
                    ->searchable()
                    ->sortable(),

            ])

            ->actions([

                EditAction::make(),

                DeleteAction::make(),

            ]);
    }

}