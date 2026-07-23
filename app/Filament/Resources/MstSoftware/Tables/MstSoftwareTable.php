<?php

namespace App\Filament\Resources\MstSoftware\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
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

            ->recordUrl(null)

            ->columns([

                TextColumn::make('No')
                    ->label('NO')
                    ->rowIndex()
                    ->weight('bold'),

                TextColumn::make('NamaSoftware')
                    ->label('NAMA SOFTWARE')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('license_count')
                    ->counts('license')
                    ->label('PRODUCT KEY')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => $state . ' Key'),

                TextColumn::make('SoftCategory')
                    ->label('KATEGORI')
                    ->badge(),

                TextColumn::make('Jenis')
                    ->label('JENIS')
                    ->badge(),

                TextColumn::make('Version')
                    ->label('VERSION'),

                IconColumn::make('Is32Bit')
                    ->label('32')
                    ->boolean(),

                IconColumn::make('Is64Bit')
                    ->label('64')
                    ->boolean(),

            ])

            ->recordActions([

                Action::make('licenses')
                    ->label('Product Keys')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->slideOver()
                    ->modalWidth('4xl')
                    ->modalHeading(fn ($record) => 'Product Keys - ' . $record->NamaSoftware)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(fn ($record) => view(
                        'filament.tables.columns.software-product-keys',
                        [
                            'licenses' => $record->license,
                        ]
                    )),

                EditAction::make(),

                DeleteAction::make(),

            ])

            ->toolbarActions([

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),

            ]);
    }
}