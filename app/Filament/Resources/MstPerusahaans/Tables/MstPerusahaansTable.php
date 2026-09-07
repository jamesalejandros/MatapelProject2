<?php

namespace App\Filament\Resources\MstPerusahaans\Tables;

use App\Filament\Resources\MstPerusahaans\MstPerusahaanResource;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class MstPerusahaansTable
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

                TextColumn::make('NamaPerusahaan')
                    ->label('Nama Perusahaan')
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
                 * mstperusahaan.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstPerusahaanResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Tombol Delete hanya ditampilkan apabila user
                 * memiliki permission:
                 *
                 * mstperusahaan.delete
                 *
                 * Permission update TIDAK otomatis memberikan
                 * permission delete.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstPerusahaanResource::canDelete($record)
                    ),

            ]);

    }
}
