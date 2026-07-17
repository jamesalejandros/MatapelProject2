<?php

namespace App\Filament\Resources\MstSoftware\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstSoftwareTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('KodeSoftwareCustom')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('NamaSoftware')
                    ->label('Nama Software')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('SoftCategory')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),


                TextColumn::make('Jenis')
                    ->label('Jenis')
                    ->badge(),


                TextColumn::make('Version')
                    ->label('Version')
                    ->searchable(),


                IconColumn::make('Is32Bit')
                    ->label('32 Bit')
                    ->boolean(),


                IconColumn::make('Is64Bit')
                    ->label('64 Bit')
                    ->boolean(),


            ])


            ->filters([
                //
            ])


            ->recordActions([
                EditAction::make(),
            ])


            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}