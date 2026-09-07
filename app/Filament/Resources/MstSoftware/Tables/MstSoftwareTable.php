<?php

namespace App\Filament\Resources\MstSoftware\Tables;

use App\Filament\Tables\SoftwareSummary;

use App\Filament\Resources\MstSoftware\MstSoftwareResource;
use App\Filament\Exports\MstSoftwareExporter;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class MstSoftwareTable
{
    public static function configure(Table $table): Table
    {
        return $table


            /**
             * ==================================================
             * RECORD URL
             * ==================================================
             *
             * Klik record akan membuka halaman Edit.
             */

            ->recordUrl(
                fn ($record) =>
                    MstSoftwareResource::getUrl(
                        'edit',
                        [
                            'record' => $record,
                        ]
                    )
            )


            /**
             * ==================================================
             * PAGINATION
             * ==================================================
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


            /**
             * ==================================================
             * QUERY
             * ==================================================
             */

            ->modifyQueryUsing(function ($query) {

                $query->with([
                    'license.perusahaan',
                ]);

            })


            /**
             * ==================================================
             * COLUMNS
             * ==================================================
             */

            ->columns([


                TextColumn::make('No')
                    ->label('NO')
                    ->rowIndex()
                    ->weight('bold'),


                TextColumn::make('NamaSoftware')
                    ->label('NAMA SOFTWARE')
                    ->sortable()
                    ->searchable(),


                TextColumn::make('license_count')
                    ->counts('license')
                    ->label('PRODUCT KEY')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(
                        fn ($state) =>
                            $state . ' Key'
                    ),


                TextColumn::make(
                    'license.perusahaan.NamaPerusahaan'
                )
                    ->label('PERUSAHAAN')
                    ->badge()
                    ->getStateUsing(function ($record) {

                        return $record->license
                            ->pluck(
                                'perusahaan.NamaPerusahaan'
                            )
                            ->filter()
                            ->unique()
                            ->values()
                            ->toArray();

                    })
                    ->separator(',')
                    ->searchable(),


                TextColumn::make('SoftCategory')
                    ->label('KATEGORI')
                    ->badge(),


                TextColumn::make('Jenis')
                    ->label('JENIS')
                    ->badge(),


                TextColumn::make('Version')
                    ->label('VERSION'),


                TextColumn::make('EndSupportDate')
                    ->label('END SUPPORT')
                    ->date('d/m/Y')
                    ->sortable(),


                IconColumn::make('Is32Bit')
                    ->label('32')
                    ->boolean(),


                IconColumn::make('Is64Bit')
                    ->label('64')
                    ->boolean(),

            ])


            /**
             * ==================================================
             * FILTERS
             * ==================================================
             */

            ->filters([


                /**
                 * ==================================================
                 * FILTER PERUSAHAAN
                 * ==================================================
                 */

                SelectFilter::make('IDPerusahaan')
                    ->label('PERUSAHAAN')
                    ->options(function () {

                        return \App\Models\MstPerusahaan::query()

                            ->whereHas(
                                'softwareLicenses'
                            )

                            ->orderBy(
                                'NamaPerusahaan'
                            )

                            ->pluck(
                                'NamaPerusahaan',
                                'IDPerusahaan'
                            )

                            ->toArray();

                    })

                    ->query(function ($query, $state) {

                        if (
                            filled(
                                $state['value'] ?? null
                            )
                        ) {

                            $query->whereHas(
                                'license',
                                function ($q) use ($state) {

                                    $q->where(
                                        'IDPerusahaan',
                                        $state['value']
                                    );

                                }
                            );

                        }

                    })

                    ->searchable(),


                /**
                 * ==================================================
                 * FILTER KATEGORI
                 * ==================================================
                 */

                SelectFilter::make('SoftCategory')
                    ->label('KATEGORI')
                    ->options(function () {

                        return \App\Models\MstSoftware::query()

                            ->whereNotNull(
                                'SoftCategory'
                            )

                            ->where(
                                'SoftCategory',
                                '!=',
                                ''
                            )

                            ->distinct()

                            ->orderBy(
                                'SoftCategory'
                            )

                            ->pluck(
                                'SoftCategory',
                                'SoftCategory'
                            )

                            ->toArray();

                    }),

            ])


            /**
             * ==================================================
             * SUMMARY TABLE
             * ==================================================
             */

            ->contentFooter(function ($livewire) {

                $summary = SoftwareSummary::generate(
                    $livewire->getFilteredTableQuery()
                );

                return view(
                    'filament.tables.software-summary',
                    $summary
                );

            })


            /**
             * ==================================================
             * RECORD ACTIONS
             * ==================================================
             */

            ->recordActions([


                /**
                 * ==================================================
                 * PRODUCT KEYS
                 * ==================================================
                 *
                 * Action ini hanya menampilkan informasi license.
                 * Tidak termasuk CRUD utama software.
                 */

                Action::make('licenses')
                    ->label('Product Keys')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->slideOver()
                    ->modalWidth('4xl')
                    ->modalHeading(
                        fn ($record) =>
                            'Product Keys - ' .
                            $record->NamaSoftware
                    )
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(
                        fn ($record) =>
                            view(
                                'filament.tables.columns.software-product-keys',
                                [
                                    'licenses' =>
                                        $record->license,
                                ]
                            )
                    ),


                /**
                 * ==================================================
                 * EDIT
                 * ==================================================
                 *
                 * Hanya muncul apabila user memiliki:
                 *
                 * mstsoftware.update
                 */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstSoftwareResource::canEdit($record)
                    ),


                /**
                 * ==================================================
                 * DELETE
                 * ==================================================
                 *
                 * Hanya muncul apabila user memiliki:
                 *
                 * mstsoftware.delete
                 *
                 * Permission update tidak memberikan
                 * permission delete secara otomatis.
                 */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstSoftwareResource::canDelete($record)
                    ),

            ])


            /**
             * ==================================================
             * TOOLBAR ACTIONS
             * ==================================================
             */

            ->toolbarActions([


                /**
                 * ==================================================
                 * EXPORT
                 * ==================================================
                 */

                ExportAction::make()
                    ->label('Export Excel')
                    ->exporter(
                        MstSoftwareExporter::class
                    ),


                /**
                 * ==================================================
                 * BULK ACTIONS
                 * ==================================================
                 */

                BulkActionGroup::make([


                    /**
                     * ==================================================
                     * DELETE BULK
                     * ==================================================
                     *
                     * Hanya muncul apabila user memiliki:
                     *
                     * mstsoftware.delete
                     */

                    DeleteBulkAction::make()
                        ->visible(
                            fn () =>
                                auth()->check()
                                && auth()->user()->can(
                                    'mstsoftware.delete'
                                )
                        ),

                ]),

            ]);
    }
}