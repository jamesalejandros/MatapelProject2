<?php

namespace App\Filament\Resources\TrxRetireAssets\Tables;

use App\Filament\Resources\TrxRetireAssets\TrxRetireAssetResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms\Components\DatePicker;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;


class TrxRetireAssetsTable
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
                'TanggalRetire',
                'desc'
            )


            /*
            |--------------------------------------------------------------------------
            | COLUMNS
            |--------------------------------------------------------------------------
            */

            ->columns([


                TextColumn::make('asset.NoAssetIT')
                    ->label('ASSET')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('asset.Nama')
                    ->label('NAMA ASSET')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('NoRetireSAP')
                    ->label('NO RETIRE SAP')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('TanggalRetire')
                    ->label('TANGGAL RETIRE')
                    ->date('d M Y')
                    ->sortable(),


                TextColumn::make('AlasanRetire')
                    ->label('ALASAN RETIRE')
                    ->badge()
                    ->searchable()
                    ->sortable(),


                TextColumn::make('Kondisi')
                    ->label('KONDISI')
                    ->badge()
                    ->searchable()
                    ->sortable(),


                TextColumn::make('EksekutorIT')
                    ->label('EKSEKUTOR IT')
                    ->searchable()
                    ->toggleable(),


                TextColumn::make('NilaiSisa')
                    ->label('NILAI SISA')
                    ->money('IDR')
                    ->sortable(),


                TextColumn::make('KeteranganDetail')
                    ->label('KETERANGAN')
                    ->limit(50)
                    ->tooltip(
                        fn ($record) =>
                            $record->KeteranganDetail
                    )
                    ->wrap()
                    ->searchable()
                    ->toggleable(),

            ])


            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            ->filters([

                Filter::make('TanggalRetire')
                    ->label('Tanggal Retire')
                    ->form([

                        DatePicker::make('dari')
                            ->label('Dari Tanggal'),

                        DatePicker::make('sampai')
                            ->label('Sampai Tanggal'),

                    ])
                    ->query(
                        function (
                            Builder $query,
                            array $data
                        ): Builder {

                            return $query

                                ->when(
                                    $data['dari'] ?? null,
                                    fn (
                                        Builder $query,
                                        $date
                                    ) =>
                                        $query->whereDate(
                                            'TanggalRetire',
                                            '>=',
                                            $date
                                        )
                                )

                                ->when(
                                    $data['sampai'] ?? null,
                                    fn (
                                        Builder $query,
                                        $date
                                    ) =>
                                        $query->whereDate(
                                            'TanggalRetire',
                                            '<=',
                                            $date
                                        )
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


                /**
                 * ==================================================
                 * EDIT
                 * ==================================================
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            TrxRetireAssetResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            TrxRetireAssetResource::canDelete($record)
                    ),

            ])


            /*
            |--------------------------------------------------------------------------
            | TOOLBAR ACTIONS
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([

                BulkActionGroup::make([


                    /**
                     * ==================================================
                     * DELETE BULK
                     * ==================================================
                     */

                    DeleteBulkAction::make()
                        ->visible(
                            fn () =>
                                auth()->check()
                                && auth()->user()->can(
                                    'trxretireasset.delete'
                                )
                        ),

                ]),

            ]);

    }
}
