<?php

namespace App\Filament\Resources\MstLokasis\Tables;

use App\Filament\Resources\MstLokasis\MstLokasiResource;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class MstLokasisTable
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

                TextColumn::make('NamaLokasi')
                    ->label('Nama Lokasi')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('Keterangan')
                    ->label('Keterangan')
                    ->placeholder('-')
                    ->searchable()
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),

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
                 * mstlokasi.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstLokasiResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Tombol Delete hanya ditampilkan apabila user
                 * memiliki permission:
                 *
                 * mstlokasi.delete
                 *
                 * Permission update TIDAK otomatis memberikan
                 * permission delete.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstLokasiResource::canDelete($record)
                    ),

            ]);

    }
}
