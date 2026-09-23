<?php

namespace App\Filament\Resources\TrxIspDowntimes\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Filament\Forms\Components\DateTimePicker;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

use Illuminate\Database\Eloquent\Builder;


class TrxIspDowntimesTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('NoTiket')

            ->columns([

                TextColumn::make(
                    'isp.vendor.NamaVendor'
                )
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make(
                    'isp.NamaISP'
                )
                    ->label('ISP')
                    ->searchable()
                    ->sortable(),

                TextColumn::make(
                    'isp.ConnectionType'
                )
                    ->label('Connection Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make(
                    'isp.lokasi.NamaLokasi'
                )
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('NoTiket')
                    ->label('No. Tiket')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('TanggalMulai')
                    ->label('Mulai')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('TanggalSelesai')
                    ->label('Selesai')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder(
                        'Masih berlangsung'
                    ),

                TextColumn::make('TotalJam')
                    ->label('Total')
                    ->numeric(
                        decimalPlaces: 2
                    )
                    ->suffix(' jam')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('LokasiPutus')
                    ->label('Lokasi Putus')
                    ->limit(40)
                    ->tooltip(
                        fn ($record) =>
                            $record->LokasiPutus
                    )
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('Penyebab')
                    ->label('Penyebab')
                    ->limit(50)
                    ->tooltip(
                        fn ($record) =>
                            $record->Penyebab
                    )
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('Dampak')
                    ->label('Dampak')
                    ->limit(50)
                    ->tooltip(
                        fn ($record) =>
                            $record->Dampak
                    )
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('StatusDowntime')
                    ->label('Status')
                    ->state(
                        fn ($record) =>
                            $record->TanggalSelesai
                                ? 'Selesai'
                                : 'Berlangsung'
                    )
                    ->badge()
                    ->color(
                        fn ($state) =>
                            $state === 'Selesai'
                                ? 'success'
                                : 'danger'
                    ),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

            ])

            ->filters([

                SelectFilter::make('IDISP')
                    ->label('ISP')
                    ->relationship(
                        'isp',
                        'NamaISP'
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('connection_type')
                    ->label('Connection Type')
                    ->options(
                        fn () =>
                            \App\Models\MstIsp::query()
                                ->whereNotNull(
                                    'ConnectionType'
                                )
                                ->where(
                                    'ConnectionType',
                                    '!=',
                                    ''
                                )
                                ->distinct()
                                ->orderBy(
                                    'ConnectionType'
                                )
                                ->pluck(
                                    'ConnectionType',
                                    'ConnectionType'
                                )
                                ->toArray()
                    )
                    ->query(
                        fn (
                            $query,
                            array $data
                        ) =>
                            $query->when(
                                $data['value'] ?? null,
                                fn (
                                    $query,
                                    $value
                                ) =>
                                    $query->whereHas(
                                        'isp',
                                        fn (
                                            $ispQuery
                                        ) =>
                                            $ispQuery->where(
                                                'ConnectionType',
                                                $value
                                            )
                                    )
                            )
                    ),

                SelectFilter::make('lokasi')
                    ->label('Lokasi')
                    ->relationship(
                        'isp.lokasi',
                        'NamaLokasi'
                    )
                    ->searchable()
                    ->preload(),

                Filter::make('sedang_berlangsung')
                    ->label('Sedang Berlangsung')
                    ->query(
                        fn (Builder $query) =>
                            $query->whereNull(
                                'TanggalSelesai'
                            )
                    ),

                Filter::make('sudah_selesai')
                    ->label('Sudah Selesai')
                    ->query(
                        fn (Builder $query) =>
                            $query->whereNotNull(
                                'TanggalSelesai'
                            )
                    ),

                Filter::make('periode')
                    ->label('Periode')
                    ->form([

                        DateTimePicker::make('mulai')
                            ->label('Mulai')
                            ->displayFormat(
                                'd M Y H:i'
                            )
                            ->format(
                                'Y-m-d H:i'
                            ),

                        DateTimePicker::make('selesai')
                            ->label('Selesai')
                            ->displayFormat(
                                'd M Y H:i'
                            )
                            ->format(
                                'Y-m-d H:i'
                            ),

                    ])
                    ->query(
                        function (
                            Builder $query,
                            array $data
                        ): Builder {

                            return $query

                                ->when(
                                    $data['mulai'] ?? null,
                                    fn (
                                        Builder $query,
                                        $date
                                    ) =>
                                        $query->where(
                                            'TanggalMulai',
                                            '>=',
                                            $date
                                        )
                                )

                                ->when(
                                    $data['selesai'] ?? null,
                                    fn (
                                        Builder $query,
                                        $date
                                    ) =>
                                        $query->where(
                                            'TanggalMulai',
                                            '<=',
                                            $date
                                        )
                                );
                        }
                    ),

            ])

            ->recordActions([

                EditAction::make(),

                DeleteAction::make(),

            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ])

            ->defaultSort(
                'TanggalMulai',
                'desc'
            );
    }
}
