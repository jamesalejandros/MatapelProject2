<?php

namespace App\Filament\Resources\MstJenisPermintaans\Tables;

use App\Filament\Resources\MstJenisPermintaans\MstJenisPermintaanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MstJenisPermintaansTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |--------------------------------------------------------------------------
            | DEFAULT SORT
            |--------------------------------------------------------------------------
            */

            ->defaultSort(
                'name',
                'asc'
            )

            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            ->paginated([
                10,
                25,
                50,
                100,
                'all',
            ])

            ->paginationPageOptions([
                10,
                25,
                50,
                100,
                'all',
            ])

            ->defaultPaginationPageOption(10)

            /*
            |--------------------------------------------------------------------------
            | COLUMNS
            |--------------------------------------------------------------------------
            */

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | NO
                |--------------------------------------------------------------------------
                */

                TextColumn::make('No')
                    ->label('NO')
                    ->rowIndex()
                    ->weight('bold')
                    ->width('70px'),

                /*
                |--------------------------------------------------------------------------
                | NAMA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('name')
                    ->label('NAMA JENIS PERMINTAAN')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->width('280px')
                    ->wrap()
                    ->lineClamp(3),

                /*
                |--------------------------------------------------------------------------
                | KETERANGAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make('keterangan')
                    ->label('KETERANGAN')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable()
                    ->width('350px')
                    ->wrap()
                    ->lineClamp(4),

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('is_active')
                    ->label('STATUS')
                    ->badge()
                    ->formatStateUsing(
                        fn ($state) =>
                            $state
                                ? 'Aktif'
                                : 'Nonaktif'
                    )
                    ->color(
                        fn ($state) =>
                            $state
                                ? 'success'
                                : 'gray'
                    )
                    ->sortable()
                    ->width('130px'),

                /*
                |--------------------------------------------------------------------------
                | CREATED
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')
                    ->label('DIBUAT')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->width('170px'),

            ])

            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            ->filters([

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([

                        '1' =>
                            'Aktif',

                        '0' =>
                            'Nonaktif',

                    ])

                    ->query(
                        function (
                            $query,
                            array $data
                        ) {

                            $value =
                                $data['value']
                                ?? null;

                            if (
                                blank($value)
                            ) {
                                return;
                            }

                            $query->where(
                                'is_active',
                                $value
                            );

                        }
                    ),

            ])

            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstJenisPermintaanResource::canEdit(
                                $record
                            )
                    ),

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstJenisPermintaanResource::canDelete(
                                $record
                            )
                    ),

            ]);
    }
}
