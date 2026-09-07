<?php

namespace App\Filament\Resources\UserManagements\Tables;

use App\Filament\Resources\UserManagements\UserManagementResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class UserManagementsTable
{
    public static function configure(
        Table $table
    ): Table {

        return $table

            /**
             * ==================================================
             * QUERY
             * ==================================================
             */

            ->modifyQueryUsing(
                fn ($query) =>
                    $query->with([
                        'roles',
                        'permissions',
                    ])
            )


            /**
             * ==================================================
             * COLUMNS
             * ==================================================
             */

            ->columns([


                TextColumn::make('name')

                    ->label('NAMA USER')

                    ->searchable()

                    ->sortable(),


                TextColumn::make('email')

                    ->label('EMAIL')

                    ->searchable()

                    ->sortable(),


                TextColumn::make('roles.name')

                    ->label('ROLE')

                    ->badge()

                    ->color(
                        fn (string $state): string =>
                            $state === 'super_admin'
                                ? 'danger'
                                : 'primary'
                    )

                    ->sortable(),


                TextColumn::make(
                    'permissions_count'
                )

                    ->label('PERMISSION')

                    ->counts('permissions')

                    ->badge()

                    ->color('success'),


                TextColumn::make('created_at')

                    ->label('DIBUAT')

                    ->dateTime(
                        'd M Y H:i'
                    )

                    ->sortable(),


                TextColumn::make('updated_at')

                    ->label('TERAKHIR DIUBAH')

                    ->dateTime(
                        'd M Y H:i'
                    )

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
                 */

                EditAction::make()

                    ->label('Edit')

                    ->visible(
                        fn ($record): bool =>
                            UserManagementResource::canEdit(
                                $record
                            )
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 */

                DeleteAction::make()

                    ->visible(
                        fn ($record): bool =>
                            UserManagementResource::canDelete(
                                $record
                            )
                    ),

            ])


            /**
             * ==================================================
             * TOOLBAR
             * ==================================================
             */

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make()

                        ->visible(
                            fn (): bool =>
                                auth()->check()
                                && auth()->user()->hasRole(
                                    'super_admin'
                                )
                        ),

                ]),

            ])


            /**
             * ==================================================
             * EMPTY STATE
             * ==================================================
             */

            ->emptyStateHeading(
                'Belum ada user'
            )

            ->emptyStateDescription(
                'Belum ada akun user yang tersedia.');

    }
}
