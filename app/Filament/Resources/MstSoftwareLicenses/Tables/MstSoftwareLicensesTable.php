<?php

namespace App\Filament\Resources\MstSoftwareLicenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstSoftwareLicensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('IDSoftware')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('IDPerusahaan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('TipeLisensi')
                    ->searchable(),
                TextColumn::make('JumlahLisensi')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('HasDVD')
                    ->boolean(),
                TextColumn::make('Barcode')
                    ->searchable(),
                TextColumn::make('LokasiSimpan')
                    ->searchable(),
                TextColumn::make('TempatSimpan')
                    ->searchable(),
                TextColumn::make('StatusLisensi')
                    ->searchable(),
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
