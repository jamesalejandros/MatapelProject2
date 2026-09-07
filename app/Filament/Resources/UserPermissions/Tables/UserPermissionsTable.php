<?php

namespace App\Filament\Resources\UserPermissions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Filament\Actions\EditAction;


class UserPermissionsTable
{
    public static function configure(
        Table $table
    ): Table {

        return $table

            /**
             * ==================================================
             * COLUMNS
             * ==================================================
             */

            ->columns([

                TextColumn::make('name')
                    ->label('Nama User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color(
                        fn (string $state): string =>
                            $state === 'super_admin'
                                ? 'danger'
                                : 'primary'
                    ),

                TextColumn::make('permissions_count')
                    ->label('Jumlah Permission')
                    ->counts('permissions')
                    ->badge()
                    ->color('success'),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

            ])

            /**
             * ==================================================
             * ACTIONS
             * ==================================================
             */

            ->recordActions([

                EditAction::make()
                    ->label('Atur Hak Akses')

                    /**
                     * Jangan tampilkan tombol edit untuk
                     * super_admin.
                     */

                    ->visible(
                        fn ($record): bool =>
                            ! $record->hasRole('super_admin')
                    ),

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
                'Belum ada user yang dapat dikelola hak aksesnya.'
            );
    }
}
