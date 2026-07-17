<?php

namespace App\Filament\Widgets;

use App\Models\MstAsset;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;


class WarrantyExpiringAssets extends BaseWidget
{

    protected static ?string $heading = 'Warranty Akan Habis';


    public function table(Table $table): Table
    {
        return $table

            ->query(
                MstAsset::query()
                    ->whereNotNull('DateWarranty')
                    ->whereDate(
                        'DateWarranty',
                        '<=',
                        now()->addMonths(3)
                    )
                    ->orderBy('DateWarranty')
            )


            ->columns([

                Tables\Columns\TextColumn::make('NoAssetIT')
                    ->label('No Asset')
                    ->searchable(),


                Tables\Columns\TextColumn::make('Nama')
                    ->label('Nama Asset')
                    ->searchable(),


                Tables\Columns\TextColumn::make('perusahaan.NamaPerusahaan')
                    ->label('Perusahaan')
                    ->searchable(),


                Tables\Columns\TextColumn::make('DateWarranty')
                    ->label('Warranty')
                    ->date()
                    ->sortable(),

            ]);
    }

}