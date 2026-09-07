<?php

namespace App\Filament\Resources\UserManagements\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Illuminate\Validation\Rules\Password;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserManagementForm
{
    public static function configure(
        Schema $schema
    ): Schema {

        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | INFORMASI AKUN
            |--------------------------------------------------------------------------
            */

            Section::make('Informasi Akun')
                ->description(
                    'Informasi dasar akun pengguna.'
                )
                ->schema([

                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255)
                        ->autofocus(),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(
                            table: 'users',
                            column: 'email',
                            ignoreRecord: true
                        )
                        ->maxLength(255),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->required(
                            fn (string $operation): bool =>
                                $operation === 'create'
                        )
                        ->rule(
                            Password::defaults()
                        )
                        ->dehydrateStateUsing(
                            fn (?string $state): ?string =>
                                filled($state)
                                    ? bcrypt($state)
                                    : null
                        )
                        ->dehydrated(
                            fn (?string $state): bool =>
                                filled($state)
                        )
                        ->helperText(
                            fn (string $operation): string =>
                                $operation === 'create'
                                    ? 'Password wajib diisi.'
                                    : 'Kosongkan jika password tidak ingin diubah.'
                        ),

                ])
                ->columns(2)
                ->columnSpanFull(),


            /*
            |--------------------------------------------------------------------------
            | ROLE
            |--------------------------------------------------------------------------
            */

            Section::make('Role Pengguna')
                ->description(
                    'Tentukan jenis pengguna dan tingkat aksesnya.'
                )
                ->schema([

                    Select::make('role')
                        ->label('Role')
                        ->options(
                            fn (): array =>
                                Role::query()
                                    ->where(
                                        'guard_name',
                                        'web'
                                    )
                                    ->where(
                                        'name',
                                        '!=',
                                        'super_admin'
                                    )
                                    ->orderBy('name')
                                    ->pluck(
                                        'name',
                                        'name'
                                    )
                                    ->toArray()
                        )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->helperText(
                            'Super Admin dikelola secara khusus dan tidak dapat diberikan melalui form ini.'
                        ),

                ])
                ->columnSpanFull(),


            /*
            |--------------------------------------------------------------------------
            | HAK AKSES
            |--------------------------------------------------------------------------
            */

            Section::make('Hak Akses')
                ->description(
                    'Pilih hak akses pengguna berdasarkan bagian sistem yang dapat digunakan.'
                )
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | MASTER DATA
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Master Data')
                        ->description(
                            'Hak akses untuk mengelola data utama sistem.'
                        )
                        ->schema([

                            self::permissionList(
                                'mst'
                            ),

                        ])
                        ->columnSpanFull(),


                    /*
                    |--------------------------------------------------------------------------
                    | TRANSAKSI
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Transaksi')
                        ->description(
                            'Hak akses untuk menjalankan dan mengelola transaksi sistem.'
                        )
                        ->schema([

                            self::permissionList(
                                'trx'
                            ),

                        ])
                        ->columnSpanFull(),

                ])
                ->columnSpanFull(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PERMISSION LIST
    |--------------------------------------------------------------------------
    |
    | Permission tetap berasal dari tabel "permissions".
    |
    | Prefix digunakan hanya untuk membagi tampilan:
    |
    | mst*  = Master Data
    | trx*  = Transaksi
    |
    | Urutan action:
    |
    | Create
    | Read
    | Update
    | Delete
    |
    |--------------------------------------------------------------------------
    */

    protected static function permissionList(
        string $prefix
    ): CheckboxList {

        return CheckboxList::make('permissions')
            ->label(false)

            ->options(
                fn (): array =>
                    Permission::query()
                        ->where(
                            'guard_name',
                            'web'
                        )
                        ->where(
                            'name',
                            'like',
                            "{$prefix}%"
                        )
                        ->get()
                        ->sortBy(
                            function (
                                Permission $permission
                            ): array {

                                $parts = explode(
                                    '.',
                                    $permission->name,
                                    2
                                );

                                $resource =
                                    $parts[0]
                                    ?? $permission->name;

                                $action =
                                    $parts[1]
                                    ?? '';

                                /*
                                |--------------------------------------------------------------------------
                                | URUTAN CRUD
                                |--------------------------------------------------------------------------
                                */

                                $actionOrder = match ($action) {
                                    'create' => 1,
                                    'view'   => 2,
                                    'update' => 3,
                                    'delete' => 4,
                                    default  => 99,
                                };

                                return [
                                    $resource,
                                    $actionOrder,
                                ];
                            }
                        )
                        ->mapWithKeys(
                            function (
                                Permission $permission
                            ): array {

                                $parts = explode(
                                    '.',
                                    $permission->name,
                                    2
                                );

                                $resource =
                                    $parts[0]
                                    ?? $permission->name;

                                $action =
                                    $parts[1]
                                    ?? null;

                                /*
                                |--------------------------------------------------------------------------
                                | NAMA MODUL
                                |--------------------------------------------------------------------------
                                */

                                $resourceLabel =
                                    str($resource)
                                        ->replaceFirst(
                                            'mst',
                                            ''
                                        )
                                        ->replaceFirst(
                                            'trx',
                                            ''
                                        )
                                        ->replace(
                                            ['_', '-'],
                                            ' '
                                        )
                                        ->title()
                                        ->toString();

                                /*
                                |--------------------------------------------------------------------------
                                | NAMA ACTION
                                |--------------------------------------------------------------------------
                                */

                                $actionLabel =
                                    match ($action) {

                                        'create' =>
                                            'Create',

                                        'view' =>
                                            'Read',

                                        'update' =>
                                            'Update',

                                        'delete' =>
                                            'Delete',

                                        default =>
                                            str($action ?? '')
                                                ->replace(
                                                    ['_', '-'],
                                                    ' '
                                                )
                                                ->title()
                                                ->toString(),
                                    };

                                return [
                                    $permission->name =>
                                        "{$resourceLabel} — {$actionLabel}",
                                ];
                            }
                        )
                        ->toArray()
            )

            ->columns(4)

            ->gridDirection('row')

            ->searchable()

            ->bulkToggleable()

            ->helperText(
                'Pilih tindakan yang diperbolehkan untuk pengguna.'
            );
    }
}
