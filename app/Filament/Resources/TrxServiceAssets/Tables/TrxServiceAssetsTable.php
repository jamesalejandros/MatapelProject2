<?php

namespace App\Filament\Resources\TrxServiceAssets\Tables;

use App\Filament\Exports\TrxServiceAssetExporter;
use App\Filament\Resources\TrxServiceAssets\TrxServiceAssetResource;
use App\Models\MstAsset;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;

use Filament\Forms\Components\DatePicker;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;


class TrxServiceAssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table


            /*
            |--------------------------------------------------------------------------
            | EAGER LOAD + DEFAULT SORT
            |--------------------------------------------------------------------------
            */

            ->modifyQueryUsing(function ($query) {

                $query->with([
                    'asset',
                    'vendor',
                ])
                    ->orderByDesc('TanggalMasuk')
                    ->orderByDesc('IDService');

            })


            /*
            |--------------------------------------------------------------------------
            | COLUMNS
            |--------------------------------------------------------------------------
            */

            ->columns([


                TextColumn::make('asset.NoAssetIT')

                    ->label('ASSET')

                    ->formatStateUsing(function ($state, $record) {

                        return

                            ($record->asset?->NoAssetIT ?? '-')

                            . ' | '

                            .

                            ($record->asset?->Nama ?? '-');

                    })

                    ->searchable([
                        'asset.NoAssetIT',
                        'asset.Nama',
                    ])

                    ->sortable()

                    ->wrap(),


                TextColumn::make('asset.karyawan.Nama')

                    ->label('NAMA')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable(),


                TextColumn::make('asset.perusahaan.NamaPerusahaan')

                    ->label('PERUSAHAAN')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable(),


                TextColumn::make('TanggalMasuk')

                    ->label('TANGGAL MASUK')

                    ->date('d M Y')

                    ->sortable(),


                TextColumn::make('TanggalSelesai')

                    ->label('TANGGAL SELESAI')

                    ->date('d M Y')

                    ->placeholder('-')

                    ->sortable(),


                TextColumn::make('lama_perbaikan')

                    ->label('LAMA PERBAIKAN')

                    ->state(function ($record) {

                        if (!$record->TanggalSelesai) {
                            return 'Belum Selesai';
                        }


                        $mulai = Carbon::parse(
                            $record->TanggalMasuk
                        )->startOfDay();


                        $selesai = Carbon::parse(
                            $record->TanggalSelesai
                        )->startOfDay();


                        $lama = $mulai->diffInDays(
                            $selesai
                        );


                        return $lama . ' Hari';

                    })

                    ->badge(),


                TextColumn::make('JenisService')

                    ->label('JENIS SERVICE')

                    ->searchable()

                    ->sortable()

                    ->badge(),


                TextColumn::make('Kerusakan')

                    ->label('KERUSAKAN')

                    ->limit(50)

                    ->wrap(),


                TextColumn::make('Tindakan')

                    ->label('TINDAKAN')

                    ->limit(50)

                    ->wrap(),


                TextColumn::make('vendor.NamaVendor')

                    ->label('VENDOR SERVICE')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable(),


                TextColumn::make('Biaya')

                    ->label('BIAYA')

                    ->money(
                        'IDR',
                        locale: 'id'
                    )

                    ->sortable(),


                TextColumn::make('StatusService')

                    ->label('STATUS SERVICE')

                    ->badge()

                    ->sortable()

                    ->color(
                        fn (?string $state): string =>
                            match ($state) {

                                'Proses' =>
                                    'warning',

                                'Selesai' =>
                                    'success',

                                'Unrepairable' =>
                                    'danger',

                                default =>
                                    'gray',

                            }
                    ),


                TextColumn::make('Oleh')

                    ->label('TEKNISI IT')

                    ->searchable(),

            ])


            /*
            |--------------------------------------------------------------------------
            | FILTERS
            |--------------------------------------------------------------------------
            */

            ->filters([


                Filter::make('TanggalMasuk')

                    ->label('Tanggal Masuk')

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
                                            'TanggalMasuk',
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
                                            'TanggalMasuk',
                                            '<=',
                                            $date
                                        )
                                );

                        }
                    ),


                SelectFilter::make('tahun')

                    ->label('TAHUN SERVICE')

                    ->options(function () {

                        return \App\Models\TrxServiceAsset::query()

                            ->selectRaw(
                                'YEAR(TanggalMasuk) as tahun'
                            )

                            ->distinct()

                            ->orderByDesc('tahun')

                            ->pluck(
                                'tahun',
                                'tahun'
                            );

                    })

                    ->query(function ($query, array $data) {

                        if (!empty($data['value'])) {

                            $query->whereYear(
                                'TanggalMasuk',
                                $data['value']
                            );

                        }

                    }),


                SelectFilter::make('StatusService')

                    ->label('STATUS SERVICE')

                    ->options([

                        'Proses' =>
                            'Proses',

                        'Selesai' =>
                            'Selesai',

                        'Unrepairable' =>
                            'Unrepairable',

                    ]),


                SelectFilter::make('JenisService')

                    ->label('JENIS SERVICE')

                    ->options([

                        'Maintenance' =>
                            'Maintenance',

                        'Perbaikan' =>
                            'Perbaikan',

                        'Upgrade' =>
                            'Upgrade',

                    ]),

            ])


            /*
            |--------------------------------------------------------------------------
            | HEADER ACTIONS
            |--------------------------------------------------------------------------
            */

            ->headerActions([

                ExportAction::make()

                    ->label('Export Excel')

                    ->exporter(
                        TrxServiceAssetExporter::class
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
                            TrxServiceAssetResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 */

                DeleteAction::make()

                    ->visible(
                        fn ($record) =>
                            TrxServiceAssetResource::canDelete($record)
                    )

                    ->after(function ($record) {

                        $asset = MstAsset::where(
                            'NoAssetIT',
                            $record->NoAssetIT
                        )->first();


                        if (!$asset) {
                            return;
                        }


                        $services = $asset
                            ->service()
                            ->get();


                        if (
                            $services
                                ->where(
                                    'StatusService',
                                    'Proses'
                                )
                                ->isNotEmpty()
                        ) {

                            $status =
                                'In Service';

                        } elseif (
                            $services
                                ->where(
                                    'StatusService',
                                    'Unrepairable'
                                )
                                ->isNotEmpty()
                        ) {

                            $status =
                                'Retired';

                        } else {

                            $status =
                                'Available';

                        }


                        $asset->update([
                            'StatusAsset' =>
                                $status,
                        ]);

                    }),

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
                                    'trxserviceasset.delete'
                                )
                        ),

                ]),

            ]);

    }
}
