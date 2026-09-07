<?php

namespace App\Filament\Resources\UserPermissions\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Spatie\Permission\Models\Permission;


class UserPermissionForm
{
    public static function configure(
        Schema $schema
    ): Schema {

        return $schema->components([

            /**
             * ==================================================
             * INFORMASI USER
             * ==================================================
             */

            Section::make(
                'Informasi User'
            )
                ->schema([

                    TextInput::make('name')
                        ->label('Nama')
                        ->disabled(),

                    TextInput::make('email')
                        ->label('Email')
                        ->disabled(),

                ])
                ->columns(2),


            /**
             * ==================================================
             * PERMISSION
             * ==================================================
             */

            Section::make(
                'Hak Akses'
            )
                ->description(
                    'Centang fitur yang boleh digunakan oleh user ini.'
                )
                ->schema([

                    CheckboxList::make(
                        'permissions'
                    )
                        ->label('Permission')

                        /**
                         * ======================================
                         * OPTIONS
                         * ======================================
                         *
                         * Semua permission diambil langsung
                         * dari tabel permissions.
                         */

                        ->options(
                            fn (): array =>
                                Permission::query()
                                    ->where(
                                        'guard_name',
                                        'web'
                                    )
                                    ->orderBy('name')
                                    ->pluck(
                                        'name',
                                        'name'
                                    )
                                    ->toArray()
                        )

                        ->columns(2)

                        ->searchable()

                        ->bulkToggleable()

                        ->gridDirection('row')

                        ->helperText(
                            'Permission yang dicentang akan diberikan kepada user.'
                        ),

                ]),

        ]);
    }
}
