<?php

namespace App\Filament\Resources\UserManagements\Tables;

use App\Filament\Resources\UserManagements\UserManagementResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;

class UserManagementsTable
{
    public static function configure(
        Table $table
    ): Table {

        return $table

            /*
            |--------------------------------------------------------------------------
            | QUERY
            |--------------------------------------------------------------------------
            |
            | kepalaBagian TIDAK dimasukkan ke eager loading karena pada model
            | User::kepalaBagian() bukan relationship Eloquent.
            |
            | Jalur sebenarnya:
            |
            | User
            |   ↓
            | karyawan
            |   ↓
            | kepalaBagian
            |   ↓
            | user
            |
            */

            ->modifyQueryUsing(
                function (Builder $query) {

                    $query->with([
                        'roles',
                        'permissions',
                        'karyawan.kepalaBagian.user',
                    ]);

                }
            )

            /*
            |--------------------------------------------------------------------------
            | COLUMNS
            |--------------------------------------------------------------------------
            */

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | NAMA USER
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'name'
                )
                    ->label(
                        'NAMA USER'
                    )
                    ->searchable()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | NIK
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'NIK'
                )
                    ->label(
                        'NIK'
                    )
                    ->searchable()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | EMAIL
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'email'
                )
                    ->label(
                        'EMAIL'
                    )
                    ->searchable()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | NAMA KARYAWAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'karyawan.Nama'
                )
                    ->label(
                        'NAMA KARYAWAN'
                    )
                    ->searchable(
                        query: function (
                            Builder $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'karyawan',
                                function (
                                    Builder $query
                                ) use (
                                    $search
                                ) {

                                    $query->where(
                                        'mstkaryawan.Nama',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                        }
                    )
                    ->sortable()
                    ->placeholder(
                        '-'
                    ),

                /*
                |--------------------------------------------------------------------------
                | KEPALA BAGIAN
                |--------------------------------------------------------------------------
                |
                | JANGAN menggunakan:
                |
                | TextColumn::make('kepalaBagian.name')
                |
                | karena User::kepalaBagian() bukan relationship.
                |
                | Gunakan state() untuk mengambil:
                |
                | user
                |   -> karyawan
                |      -> kepalaBagian
                |         -> user
                |
                */

                TextColumn::make(
                    'kepala_bagian_display'
                )
                    ->label(
                        'KEPALA BAGIAN'
                    )
                    ->state(
                        function (
                            $record
                        ): string {

                            return
                                $record
                                    ->karyawan
                                    ?->kepalaBagian
                                    ?->user
                                    ?->name
                                ??
                                '-';

                        }
                    )
                    ->searchable(
                        query: function (
                            Builder $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'karyawan.kepalaBagian.user',
                                function (
                                    Builder $query
                                ) use (
                                    $search
                                ) {

                                    $query->where(
                                        function (
                                            Builder $query
                                        ) use (
                                            $search
                                        ) {

                                            $query
                                                ->where(
                                                    'users.name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.email',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                        }
                    )
                    ->sortable(
                        query: function (
                            Builder $query,
                            string $direction
                        ): void {

                            /*
                            |--------------------------------------------------------------------------
                            | Sorting Kepala Bagian
                            |--------------------------------------------------------------------------
                            |
                            | Karena kepalaBagian bukan direct relationship User,
                            | sorting dilakukan melalui JOIN.
                            |
                            | Tidak perlu dipaksakan apabila database memiliki
                            | struktur berbeda.
                            |
                            */

                            $query
                                ->leftJoin(
                                    'mstkaryawan as mk_user',
                                    'users.NIK',
                                    '=',
                                    'mk_user.NIK'
                                )
                                ->leftJoin(
                                    'mstkaryawan as mk_kepala',
                                    'mk_user.NIKKepalaBagian',
                                    '=',
                                    'mk_kepala.NIK'
                                )
                                ->leftJoin(
                                    'users as user_kepala',
                                    'mk_kepala.NIK',
                                    '=',
                                    'user_kepala.NIK'
                                )
                                ->orderBy(
                                    'user_kepala.name',
                                    $direction
                                )
                                ->select(
                                    'users.*'
                                );

                        }
                    )
                    ->placeholder(
                        '-'
                    ),

                /*
                |--------------------------------------------------------------------------
                | EMAIL KEPALA BAGIAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'kepala_bagian_email_display'
                )
                    ->label(
                        'EMAIL KEPALA BAGIAN'
                    )
                    ->state(
                        function (
                            $record
                        ): string {

                            return
                                $record
                                    ->karyawan
                                    ?->kepalaBagian
                                    ?->user
                                    ?->email
                                ??
                                '-';

                        }
                    )
                    ->searchable(
                        query: function (
                            Builder $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'karyawan.kepalaBagian.user',
                                function (
                                    Builder $query
                                ) use (
                                    $search
                                ) {

                                    $query->where(
                                        'users.email',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                        }
                    )
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    )
                    ->placeholder(
                        '-'
                    ),

                /*
                |--------------------------------------------------------------------------
                | ROLE
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'roles.name'
                )
                    ->label(
                        'ROLE'
                    )
                    ->badge()
                    ->color(
                        fn (
                            string $state
                        ): string =>
                            $state === 'super_admin'
                                ? 'danger'
                                : 'primary'
                    )
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | PERMISSION
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'permissions_count'
                )
                    ->label(
                        'PERMISSION'
                    )
                    ->counts(
                        'permissions'
                    )
                    ->badge()
                    ->color(
                        'success'
                    ),

                /*
                |--------------------------------------------------------------------------
                | CREATED AT
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'created_at'
                )
                    ->label(
                        'DIBUAT'
                    )
                    ->dateTime(
                        'd M Y H:i'
                    )
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | UPDATED AT
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'updated_at'
                )
                    ->label(
                        'TERAKHIR DIUBAH'
                    )
                    ->dateTime(
                        'd M Y H:i'
                    )
                    ->sortable(),

            ])

            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                /*
                |--------------------------------------------------------------------------
                | EDIT
                |--------------------------------------------------------------------------
                */

                EditAction::make()
                    ->label(
                        'Edit'
                    )
                    ->visible(
                        fn (
                            $record
                        ): bool =>
                            UserManagementResource::canEdit(
                                $record
                            )
                    ),

                /*
                |--------------------------------------------------------------------------
                | DELETE
                |--------------------------------------------------------------------------
                */

                DeleteAction::make()
                    ->visible(
                        fn (
                            $record
                        ): bool =>
                            UserManagementResource::canDelete(
                                $record
                            )
                    ),

            ])

            /*
            |--------------------------------------------------------------------------
            | TOOLBAR
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make()
                        ->visible(
                            fn (): bool =>
                                auth()->check()
                                &&
                                auth()
                                    ->user()
                                    ->hasRole(
                                        'super_admin'
                                    )
                        ),

                ]),

            ])

            /*
            |--------------------------------------------------------------------------
            | EMPTY STATE
            |--------------------------------------------------------------------------
            */

            ->emptyStateHeading(
                'Belum ada user'
            )

            ->emptyStateDescription(
                'Belum ada akun user yang tersedia.'
            );

    }
}
