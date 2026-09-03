<?php

namespace App\Filament\Resources\TrxMutasiAssets\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class TrxMutasiAssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->defaultSort(
                'TanggalMutasi',
                'desc'
            )

            ->columns([


                TextColumn::make('asset.NoAssetIT')
                    ->label('ASSET')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('karyawan.NIK')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('karyawan.Nama')
                    ->label('KARYAWAN')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('karyawan.departemen.NamaDept')
                    ->label('DEPARTEMEN')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('lokasi.NamaLokasi')
                    ->label('LOKASI')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('NoTransferSAP')
                    ->label('NO TRANSFER SAP')
                    ->searchable()
                    ->toggleable(),


                TextColumn::make('TanggalMutasi')
                    ->label('TANGGAL MUTASI')
                    ->date('d M Y')
                    ->sortable(),


                TextColumn::make('AksesWebsite')
                    ->label('AKSES WEBSITE')
                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('AksesEmail')
                    ->label('AKSES EMAIL')
                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('Keterangan')
                    ->label('KETERANGAN')
                    ->placeholder('-')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->Keterangan)
                    ->wrap()
                    ->searchable()
                    ->toggleable(),

            ])

            ->filters([

                Filter::make('TanggalMutasi')
                    ->label('Tanggal Mutasi')
                    ->form([

                        DatePicker::make('dari')
                            ->label('Dari Tanggal'),

                        DatePicker::make('sampai')
                            ->label('Sampai Tanggal'),

                    ])
                    ->query(function (Builder $query, array $data): Builder {

                        return $query
                            ->when(
                                $data['dari'] ?? null,
                                fn (Builder $query, $date) =>
                                    $query->whereDate(
                                        'TanggalMutasi',
                                        '>=',
                                        $date
                                    )
                            )
                            ->when(
                                $data['sampai'] ?? null,
                                fn (Builder $query, $date) =>
                                    $query->whereDate(
                                        'TanggalMutasi',
                                        '<=',
                                        $date
                                    )
                            );

                    }),

            ])

            ->recordActions([

                EditAction::make(),

                DeleteAction::make(),

            ]);
    }
}
