<?php

namespace App\Filament\Resources\MstSambungans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstSambungansTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('IDSambungan')

                    ->label('ID SAMBUNGAN')

                    ->sortable()

                    ->searchable(),


                TextColumn::make('Rule')

                    ->label('RULE')

                    ->searchable()

                    ->sortable()

                    ->wrap(),

            ])

            ->filters([])

            ->recordActions([

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
