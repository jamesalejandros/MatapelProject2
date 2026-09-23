<?php

namespace App\Filament\Resources\TrxIspBandwidths\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;


class TrxIspBandwidthsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('TanggalUpgrade')

            ->columns([

                TextColumn::make('isp.vendor.NamaVendor')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('isp.NamaISP')
                    ->label('ISP')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('isp.ConnectionType')
                    ->label('Connection Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('isp.lokasi.NamaLokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('TanggalUpgrade')
                    ->label('Tanggal Upgrade')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('BandwidthInternasional')
                    ->label('Internasional')
                    ->suffix(' Mbps')
                    ->sortable(),

                TextColumn::make('BandwidthLokal')
                    ->label('Lokal')
                    ->suffix(' Mbps')
                    ->sortable(),

                TextColumn::make('Harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('Status')
                    ->label('Status')
                    ->badge()
                    ->color(
                        fn (?string $state): string => match ($state) {
                            'ACTIVE' => 'success',
                            'INACTIVE' => 'gray',
                            default => 'gray',
                        }
                    ),

                TextColumn::make('Keterangan')
                    ->label('Keterangan')
                    ->limit(40)
                    ->tooltip(
                        fn ($record) => $record->Keterangan
                    ),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
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
                                ->whereNotNull('ConnectionType')
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
                                fn ($query, $value) =>
                                    $query->whereHas(
                                        'isp',
                                        fn ($ispQuery) =>
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

                SelectFilter::make('Status')
                    ->label('Status')
                    ->options([
                        'ACTIVE' => 'Active',
                        'INACTIVE' => 'Inactive',
                    ])
                    ->default('ACTIVE'),

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
                'TanggalUpgrade',
                'desc'
            );
    }
}
