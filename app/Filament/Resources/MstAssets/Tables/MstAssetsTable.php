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
                    ->date()
                    ->sortable(),
                TextColumn::make('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('vendor.NamaVendor')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('Garansi')
                    ->searchable(),
                TextColumn::make('DateWarranty')
                    ->date()
                    ->sortable(),
                TextColumn::make('perusahaan.NamaPerusahaan')
                    ->label('Perusahaan')
                    ->searchable()
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
