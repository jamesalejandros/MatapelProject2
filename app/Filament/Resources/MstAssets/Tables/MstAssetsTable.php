<?php

namespace App\Filament\Resources\MstAssets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstAssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('NoAssetIT')
                    ->searchable(),
                TextColumn::make('NoAssetSAP')
                    ->searchable(),
                TextColumn::make('Jenis')
                    ->searchable(),
                TextColumn::make('Nama')
                    ->searchable(),
                TextColumn::make('PN')
                    ->searchable(),
                TextColumn::make('SN')
                    ->searchable(),
                TextColumn::make('PN_LCD')
                    ->searchable(),
                TextColumn::make('SN_LCD')
                    ->searchable(),
                TextColumn::make('RAM')
                    ->searchable(),
                TextColumn::make('ComputerName')
                    ->searchable(),
                TextColumn::make('IPAddress')
                    ->searchable(),
                TextColumn::make('StatusBeli')
                    ->searchable(),
                TextColumn::make('TanggalBeli')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('Harga')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('IDVendor')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('Garansi')
                    ->searchable(),
                TextColumn::make('DateWarranty')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('IDPerusahaan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('StatusAsset')
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
