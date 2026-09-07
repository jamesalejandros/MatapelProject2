<?php

namespace App\Filament\Resources\MstSambungans\Tables;

use App\Filament\Resources\MstSambungans\MstSambunganResource;

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

            /**
             * ==================================================
             * COLUMNS
             * ==================================================
             */

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


            /**
             * ==================================================
             * FILTERS
             * ==================================================
             */

            ->filters([])


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
                 * mstsambungan.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstSambunganResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Hanya muncul apabila user memiliki:
                 *
                 * mstsambungan.delete
                 *
                 * Permission update tidak memberikan
                 * permission delete secara otomatis.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstSambunganResource::canDelete($record)
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
                     * mstsambungan.delete
                     */

                    DeleteBulkAction::make()
                        ->visible(
                            fn () =>
                                auth()->check()
                                && auth()->user()->can(
                                    'mstsambungan.delete'
                                )
                        ),

                ]),

            ]);
    }
}
