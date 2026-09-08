<?php

namespace App\Filament\Resources\TrxSoftwareAssignments\Tables;

use App\Filament\Resources\TrxSoftwareAssignments\TrxSoftwareAssignmentResource;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class TrxSoftwareAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table


            /*
            |--------------------------------------------------------------------------
            | RECORD URL
            |--------------------------------------------------------------------------
            */

            ->recordUrl(
                fn ($record) =>
                    TrxSoftwareAssignmentResource::getUrl(
                        'edit',
                        [
                            'record' => $record,
                        ]
                    )
            )


            /*
            |--------------------------------------------------------------------------
            | DEFAULT SORT
            |--------------------------------------------------------------------------
            */

            ->defaultSort(
                'TanggalAssign',
                'desc'
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
                250,
                'all',
            ])


            ->paginationPageOptions([
                10,
                25,
                50,
                100,
                250,
                'all',
            ])


            ->defaultPaginationPageOption('all')


            /*
            |--------------------------------------------------------------------------
            | EAGER LOAD
            |--------------------------------------------------------------------------
            */

            ->modifyQueryUsing(function ($query) {

                $query->with([

                    'asset.karyawan.departemen',

                    'asset.perusahaan',

                    'license.software',

                    'license.perusahaan',

                ]);

            })


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

                    ->weight('bold'),


                /*
                |--------------------------------------------------------------------------
                | ASSET
                |--------------------------------------------------------------------------
                */

                TextColumn::make('asset.NoAssetIT')

                    ->label('ASSET')

                    ->formatStateUsing(function ($state, $record) {

                        return

                            ($record->asset?->NoAssetIT ?? '-')

                            . ' | '

                            .

                            ($record->asset?->Nama ?? '-');

                    })

                    ->searchable(
                        query: function ($query, string $search): void {

                            $query->whereHas(
                                'asset',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'NoAssetIT',
                                                    'like',
                                                    "%{$search}%"
                                                )

                                                ->orWhere(
                                                    'Nama',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                        }
                    )

                    ->sortable()

                    ->wrap(),


                /*
                |--------------------------------------------------------------------------
                | PEMEGANG ASSET
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'asset.karyawan.Nama'
                )

                    ->label('PEMEGANG ASSET')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | DEPARTEMEN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'asset.karyawan.departemen.NamaDept'
                )

                    ->label('DEPARTEMEN')

                    ->placeholder('-')

                    ->badge()

                    ->searchable()

                    ->sortable()

                    ->toggleable(),


                /*
                |--------------------------------------------------------------------------
                | PERUSAHAAN ASSET
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'asset.perusahaan.NamaPerusahaan'
                )

                    ->label('PERUSAHAAN ASSET')

                    ->placeholder('-')

                    ->badge()

                    ->color('info')

                    ->searchable()

                    ->sortable()

                    ->toggleable(),


                /*
                |--------------------------------------------------------------------------
                | SOFTWARE
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'license.software.NamaSoftware'
                )

                    ->label('SOFTWARE')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap(),


                /*
                |--------------------------------------------------------------------------
                | ID LICENSE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('license.IDLicense')

                    ->label('ID LICENSE')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap(),


                /*
                |--------------------------------------------------------------------------
                | PERUSAHAAN LICENSE
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'license.perusahaan.NamaPerusahaan'
                )

                    ->label('PERUSAHAAN LICENSE')

                    ->placeholder('-')

                    ->badge()

                    ->color('primary')

                    ->searchable()

                    ->sortable()

                    ->toggleable(),


                /*
                |--------------------------------------------------------------------------
                | TIPE LISENSI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('license.TipeLisensi')

                    ->label('TIPE LISENSI')

                    ->badge()

                    ->color('warning')

                    ->sortable()

                    ->toggleable(),


                /*
                |--------------------------------------------------------------------------
                | PRODUCT KEY
                |--------------------------------------------------------------------------
                */

                TextColumn::make('license.ProductKey')

                    ->label('PRODUCT KEY')

                    ->formatStateUsing(
                        fn () =>
                            '••••••••••••••'
                    )

                    ->copyable(false)

                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),


                /*
                |--------------------------------------------------------------------------
                | TANGGAL INSTALL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('TanggalAssign')

                    ->label('TANGGAL INSTALL')

                    ->date('d M Y')

                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | TANGGAL REVOKE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('TanggalRevoke')

                    ->label('TANGGAL REVOKE')

                    ->date('d M Y')

                    ->placeholder('-')

                    ->sortable()

                    ->toggleable(),


                /*
                |--------------------------------------------------------------------------
                | STATUS ASSET
                |--------------------------------------------------------------------------
                */

                TextColumn::make('asset.StatusAsset')

                    ->label('STATUS ASSET')

                    ->badge()

                    ->color(
                        fn (?string $state): string =>
                            match ($state) {

                                'Available' =>
                                    'success',

                                'In Service' =>
                                    'warning',

                                'Retired' =>
                                    'danger',

                                default =>
                                    'gray',

                            }
                    )

                    ->sortable()

                    ->toggleable(),


                /*
                |--------------------------------------------------------------------------
                | STATUS SOFTWARE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('StatusAssignment')

                    ->label('STATUS SOFTWARE')

                    ->badge()

                    ->sortable()

                    ->color(
                        fn (?string $state): string =>
                            match ($state) {

                                'Installed' =>
                                    'success',

                                'Revoked' =>
                                    'danger',

                                'Expired' =>
                                    'warning',

                                default =>
                                    'gray',

                            }
                    ),

            ])


            /*
            |--------------------------------------------------------------------------
            | FILTERS
            |--------------------------------------------------------------------------
            */

            ->filters([


                /*
                |--------------------------------------------------------------------------
                | STATUS ASSET
                |--------------------------------------------------------------------------
                |
                | Filter berdasarkan status asset dari tabel mstasset.
                |
                */

                SelectFilter::make('StatusAsset')

                    ->label('STATUS ASSET')

                    ->options([
                        'Available' => 'Available',
                        'In Service' => 'In Service',
                        'Retired' => 'Retired',
                    ])

                    ->query(
                        function ($query, array $data) {

                            if (
                                blank(
                                    $data['value'] ?? null
                                )
                            ) {
                                return;
                            }

                            $query->whereHas(
                                'asset',
                                function ($query) use ($data) {

                                    $query->where(
                                        'StatusAsset',
                                        $data['value']
                                    );

                                }
                            );

                        }
                    )


                    ->native(false),


                /*
                |--------------------------------------------------------------------------
                | STATUS SOFTWARE
                |--------------------------------------------------------------------------
                |
                | Filter berdasarkan StatusAssignment.
                |
                */

                SelectFilter::make('StatusAssignment')

                    ->label('STATUS SOFTWARE')

                    ->options([
                        'Installed' => 'Installed',
                        'Revoked' => 'Revoked',
                        'Expired' => 'Expired',
                    ])

                    ->native(false),


            ])


            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([


                /**
                 * ==================================================
                 * VIEW PRODUCT KEY
                 * ==================================================
                 *
                 * Product key tidak ditampilkan langsung di tabel.
                 * User dapat melihatnya melalui slide-over.
                 */

                Action::make('viewLicense')

                    ->label('Product Key')

                    ->icon('heroicon-o-key')

                    ->color('warning')

                    ->slideOver()

                    ->modalHeading(
                        fn ($record) =>
                            'Product Key - ' .
                            (
                                $record->license?->software?->NamaSoftware
                                ??
                                '-'
                            )
                    )

                    ->modalSubmitAction(false)

                    ->modalCancelActionLabel('Close')

                    ->modalContent(
                        fn ($record) =>
                            view(
                                'filament.tables.columns.assignment-product-key',
                                [
                                    'license' =>
                                        $record->license,
                                ]
                            )
                    ),


                /**
                 * ==================================================
                 * EDIT
                 * ==================================================
                 */

                EditAction::make()

                    ->visible(
                        fn ($record) =>
                            TrxSoftwareAssignmentResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 */

                DeleteAction::make()

                    ->visible(
                        fn ($record) =>
                            TrxSoftwareAssignmentResource::canDelete($record)
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
                                    'trxsoftwareassignment.delete'
                                )
                        ),

                ]),

            ]);

    }
}
