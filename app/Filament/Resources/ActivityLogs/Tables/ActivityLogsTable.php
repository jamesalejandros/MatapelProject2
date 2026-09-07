<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Spatie\Activitylog\Models\Activity;


class ActivityLogsTable
{
    public static function configure(
        Table $table
    ): Table {

        return $table

            /**
             * ==================================================
             * DEFAULT SORT
             * ==================================================
             */

            ->defaultSort(
                'created_at',
                'desc'
            )


            /**
             * ==================================================
             * COLUMNS
             * ==================================================
             */

            ->columns([

                /**
                 * ------------------------------------------------
                 * WAKTU
                 * ------------------------------------------------
                 */

                TextColumn::make(
                    'created_at'
                )
                    ->label('Waktu')
                    ->dateTime(
                        'd M Y H:i:s'
                    )
                    ->sortable(),


                /**
                 * ------------------------------------------------
                 * ACTOR
                 * ------------------------------------------------
                 */

                TextColumn::make(
                    'causer.name'
                )
                    ->label('Dilakukan Oleh')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),


                /**
                 * ------------------------------------------------
                 * MODULE
                 * ------------------------------------------------
                 */

                TextColumn::make(
                    'log_name'
                )
                    ->label('Module')
                    ->badge()
                    ->color(
                        fn (?string $state) =>
                            match ($state) {

                                'permission' =>
                                    'warning',

                                'crud' =>
                                    'primary',

                                default =>
                                    'gray',

                            }
                    ),


                /**
                 * ------------------------------------------------
                 * SUBJECT
                 * ------------------------------------------------
                 */

                TextColumn::make(
                    'subject_type'
                )
                    ->label('Model')
                    ->formatStateUsing(
                        fn (?string $state) =>
                            $state
                                ? class_basename($state)
                                : '-'
                    )
                    ->toggleable(),


                /**
                 * ------------------------------------------------
                 * RECORD
                 * ------------------------------------------------
                 */

                TextColumn::make(
                    'subject_id'
                )
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),


                /**
                 * ------------------------------------------------
                 * AKTIVITAS
                 * ------------------------------------------------
                 */

                TextColumn::make(
                    'description'
                )
                    ->label('Aktivitas')
                    ->searchable()
                    ->wrap(),

            ])


            /**
             * ==================================================
             * FILTER
             * ==================================================
             */

            ->filters([

                SelectFilter::make(
                    'log_name'
                )
                    ->label('Module')
                    ->options([

                        'permission' =>
                            'Permission',

                        'crud' =>
                            'CRUD',

                    ]),

            ])


            /**
             * ==================================================
             * ACTION
             * ==================================================
             */

            ->actions([])


            /**
             * ==================================================
             * BULK ACTION
             * ==================================================
             */

            ->bulkActions([]);
    }
}
