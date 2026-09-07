<?php

namespace App\Filament\Resources\TrxCctvAssignments\Tables;

use App\Filament\Resources\TrxCctvAssignments\TrxCctvAssignmentResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class TrxCctvAssignmentsTable
{
    public static function configure(
        Table $table
    ): Table {

        return $table


            /**
             * ======================================================
             * DEFAULT SORT
             * ======================================================
             */

            ->defaultSort(
                'IDAssignment',
                'desc'
            )


            /**
             * ======================================================
             * EAGER LOAD
             * ======================================================
             */

            ->modifyQueryUsing(
                function ($query) {

                    $query->with([
                        'asset',
                    ]);

                }
            )


            /**
             * ======================================================
             * COLUMNS
             * ======================================================
             */

            ->columns([


                /*
                |--------------------------------------------------------------------------
                | CHANNEL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Channel')

                    ->label('CHANNEL')

                    ->searchable()

                    ->sortable()

                    ->weight('bold'),



                /*
                |--------------------------------------------------------------------------
                | ASSET
                |--------------------------------------------------------------------------
                */

                TextColumn::make('asset.NoAssetIT')

                    ->label('ASSET')

                    ->formatStateUsing(
                        function ($state, $record) {

                            return

                                ($record->asset?->NoAssetIT
                                    ?? '-')

                                . ' | '

                                . ($record->asset?->Nama
                                    ?? '-');

                        }
                    )

                    ->searchable()

                    ->sortable()

                    ->wrap(),



                /*
                |--------------------------------------------------------------------------
                | IP ADDRESS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('asset.IPAddress')

                    ->label('IP ADDRESS')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->copyable()

                    ->toggleable(),



                /*
                |--------------------------------------------------------------------------
                | JENIS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Jenis')

                    ->label('JENIS CCTV')

                    ->badge()

                    ->color(
                        fn (?string $state): string =>
                            match ($state) {

                                'IP' =>
                                    'success',

                                'Analog' =>
                                    'warning',

                                default =>
                                    'gray',

                            }
                    )

                    ->sortable(),



                /*
                |--------------------------------------------------------------------------
                | TANGGAL PASANG
                |--------------------------------------------------------------------------
                */

                TextColumn::make('TanggalPasang')

                    ->label('TANGGAL PASANG')

                    ->date('d/m/Y')

                    ->placeholder('-')

                    ->sortable(),



                /*
                |--------------------------------------------------------------------------
                | TIPE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Tipe')

                    ->label('TIPE')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap(),



                /*
                |--------------------------------------------------------------------------
                | KONDISI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Kondisi')

                    ->label('KONDISI')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap(),



                /*
                |--------------------------------------------------------------------------
                | KETERANGAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Keterangan')

                    ->label('KETERANGAN')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap()

                    ->toggleable(),

            ])


            /**
             * ======================================================
             * FILTER
             * ======================================================
             */

            ->filters([])


            /**
             * ======================================================
             * RECORD ACTIONS
             * ======================================================
             */

            ->recordActions([


                /**
                 * ==================================================
                 * EDIT
                 * ==================================================
                 *
                 * Hanya visible jika user memiliki:
                 *
                 * trxcctvassignment.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            TrxCctvAssignmentResource::canEdit($record)
                    ),



                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Hanya visible jika user memiliki:
                 *
                 * trxcctvassignment.delete
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            TrxCctvAssignmentResource::canDelete($record)
                    ),

            ])


            /**
             * ======================================================
             * BULK ACTIONS
             * ======================================================
             */

            ->toolbarActions([


                BulkActionGroup::make([


                    /**
                     * ==================================================
                     * DELETE BULK
                     * ==================================================
                     *
                     * Hanya visible jika user memiliki:
                     *
                     * trxcctvassignment.delete
                     */

                    DeleteBulkAction::make()
                        ->visible(
                            fn () =>
                                auth()->check()
                                && auth()->user()->can(
                                    'trxcctvassignment.delete'
                                )
                        ),

                ]),

            ]);

    }
}
