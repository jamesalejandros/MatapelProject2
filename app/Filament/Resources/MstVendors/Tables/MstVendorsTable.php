<?php

namespace App\Filament\Resources\MstVendors\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class MstVendorsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('NamaVendor')
                    ->label('Nama Vendor')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('Kontak')
                    ->label('Kontak')
                    ->searchable(),

            ])

            ->actions([

                EditAction::make(),

                DeleteAction::make(),

            ]);
    }
}