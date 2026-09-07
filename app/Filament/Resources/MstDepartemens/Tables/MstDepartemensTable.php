<?php

namespace App\Filament\Resources\MstDepartemens\Tables;

use App\Filament\Resources\MstDepartemens\MstDepartemenResource;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class MstDepartemensTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /**
             * ==================================================
             * COLUMNS
             * ==================================================
             */

            ->columns([

                TextColumn::make('NamaDept')
                    ->label('Nama Departemen')
                    ->searchable()
                    ->sortable(),

            ])


            /**
             * ==================================================
             * RECORD ACTIONS
             * ==================================================
             */

            ->recordActions([

                /**
                 * ==================================================
                 * EDIT
                 * ==================================================
                 *
                 * Tombol Edit hanya ditampilkan apabila user
                 * memiliki permission:
                 *
                 * mstdepartemen.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstDepartemenResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Tombol Delete hanya ditampilkan apabila user
                 * memiliki permission:
                 *
                 * mstdepartemen.delete
                 *
                 * Permission update TIDAK otomatis memberikan
                 * permission delete.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstDepartemenResource::canDelete($record)
                    ),

            ]);

    }
}
