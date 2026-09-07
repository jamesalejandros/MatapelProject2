<?php

namespace App\Filament\Resources\MstKaryawans\Tables;

use App\Filament\Resources\MstKaryawans\MstKaryawanResource;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class MstKaryawansTable
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

                TextColumn::make('NIK')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('Nama')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('perusahaan.NamaPerusahaan')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('departemen.NamaDept')
                    ->label('Departemen')
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
                 * mstkaryawan.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstKaryawanResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Tombol Delete hanya ditampilkan apabila user
                 * memiliki permission:
                 *
                 * mstkaryawan.delete
                 *
                 * Permission update TIDAK otomatis memberikan
                 * permission delete.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstKaryawanResource::canDelete($record)
                    ),

            ]);

    }
}
