<?php

namespace App\Filament\Resources\MstVendors\Tables;

use App\Filament\Resources\MstVendors\MstVendorResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;


class MstVendorsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([


                TextColumn::make('NamaVendor')
                    ->label('Nama Vendor')
                    ->searchable()
                    ->sortable(),



                TextColumn::make('Kontak')
                    ->label('Kontak')
                    ->searchable(),

            ])


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
                 * mstvendor.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstVendorResource::canEdit($record)
                    ),



                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Hanya visible jika user memiliki:
                 *
                 * mstvendor.delete
                 *
                 * Permission update TIDAK otomatis memberikan
                 * permission delete.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstVendorResource::canDelete($record)
                    ),

            ])


            /**
             * ======================================================
             * TOOLBAR ACTIONS
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
                     * mstvendor.delete
                     */

                    DeleteBulkAction::make()
                        ->visible(
                            fn () =>
                                auth()->check()
                                && auth()->user()->can(
                                    'mstvendor.delete'
                                )
                        ),

                ]),

            ]);

    }
}
