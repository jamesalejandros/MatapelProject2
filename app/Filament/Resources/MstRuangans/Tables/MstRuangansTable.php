<?php

namespace App\Filament\Resources\MstRuangans\Tables;

use App\Filament\Resources\MstRuangans\MstRuanganResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class MstRuangansTable
{
    public static function configure(Table $table): Table
    {
        return $table


            /**
             * ==================================================
             * RECORD URL
             * ==================================================
             *
             * Klik record akan membuka halaman Edit.
             *
             * Permission untuk benar-benar melakukan update
             * tetap dikontrol oleh EditAction dan BaseResource.
             */

            ->recordUrl(
                fn ($record) =>
                    MstRuanganResource::getUrl(
                        'edit',
                        [
                            'record' => $record,
                        ]
                    )
            )


            /**
             * ==================================================
             * DEFAULT SORT
             * ==================================================
             */

            ->defaultSort(
                'IDRuangan',
                'asc'
            )


            /**
             * ==================================================
             * PAGINATION
             * ==================================================
             */

            ->paginated([
                10,
                25,
                50,
                100,
                250,
                'all',
            ])


            ->paginationPageOptions([
                10,
                25,
                50,
                100,
                250,
                'all',
            ])


            ->defaultPaginationPageOption('all')


            /**
             * ==================================================
             * QUERY
             * ==================================================
             */

            ->modifyQueryUsing(
                function ($query) {

                    $query->with([
                        'lokasi',
                    ]);

                }
            )


            /**
             * ==================================================
             * COLUMNS
             * ==================================================
             */

            ->columns([


                TextColumn::make('No')
                    ->label('NO')
                    ->rowIndex()
                    ->weight('bold'),


                TextColumn::make('IDRuangan')
                    ->label('ID RUANGAN')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('NamaRuangan')
                    ->label('NAMA RUANGAN')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),


                TextColumn::make('Lantai')
                    ->label('LANTAI')
                    ->searchable()
                    ->sortable()
                    ->wrap(),


                TextColumn::make('lokasi.NamaLokasi')
                    ->label('LOKASI')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

            ])


            /**
             * ==================================================
             * FILTERS
             * ==================================================
             */

            ->filters([

                //

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
                 * Hanya muncul apabila user memiliki:
                 *
                 * mstruangan.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstRuanganResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Hanya muncul apabila user memiliki:
                 *
                 * mstruangan.delete
                 *
                 * Permission update tidak memberikan
                 * permission delete secara otomatis.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstRuanganResource::canDelete($record)
                    ),

            ])


            /**
             * ==================================================
             * TOOLBAR ACTIONS
             * ==================================================
             */

            ->toolbarActions([

                BulkActionGroup::make([

                    /**
                     * ==================================================
                     * DELETE BULK
                     * ==================================================
                     *
                     * Hanya muncul apabila user memiliki:
                     *
                     * mstruangan.delete
                     */

                    DeleteBulkAction::make()
                        ->visible(
                            fn () =>
                                auth()->check()
                                && auth()->user()->can(
                                    'mstruangan.delete'
                                )
                        ),

                ]),

            ]);
    }
}
