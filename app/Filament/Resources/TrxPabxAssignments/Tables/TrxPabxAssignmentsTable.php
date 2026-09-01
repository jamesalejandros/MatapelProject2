<?php

namespace App\Filament\Resources\TrxPabxAssignments\Tables;

use App\Filament\Resources\TrxPabxAssignments\TrxPabxAssignmentResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Table;


class TrxPabxAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table


            ->recordUrl(
                fn ($record) =>
                    TrxPabxAssignmentResource::getUrl(
                        'edit',
                        [
                            'record' => $record,
                        ]
                    )
            )



            ->defaultSort(
                'IDAssignment',
                'desc'
            )



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



            ->modifyQueryUsing(
                function ($query) {

                    $query->with([

                        'asset.perusahaan',

                        'asset.karyawan.departemen',

                        'karyawan.departemen',

                        'karyawan.lokasi',

                        'ruangan.lokasi',

                    ]);

                }
            )



            ->columns([



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

                    ->formatStateUsing(
                        function ($state, $record) {

                            return

                                ($record->asset?->NoAssetIT
                                    ?? '-')

                                . ' | '

                                . ($record->asset?->Nama
                                    ?? '-');

                        }
                    )

                    ->searchable(
                        query:
                        function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'asset',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query->where(
                                                'NoAssetIT',
                                                'like',
                                                "%{$search}%"
                                            )

                                            ->orWhere(
                                                'NoAssetSAP',
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
                | NO EXT
                |--------------------------------------------------------------------------
                */

                TextColumn::make('NoExt')

                    ->label('NO. EXT')

                    ->searchable()

                    ->sortable()

                    ->weight('bold'),



                /*
                |--------------------------------------------------------------------------
                | KARYAWAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make('karyawan.Nama')

                    ->label('KARYAWAN')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap(),



                /*
                |--------------------------------------------------------------------------
                | NIK
                |--------------------------------------------------------------------------
                */

                TextColumn::make('NIK')

                    ->label('NIK')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->toggleable(),



                /*
                |--------------------------------------------------------------------------
                | RUANGAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make('ruangan.NamaRuangan')

                    ->label('RUANGAN')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap(),



                /*
                |--------------------------------------------------------------------------
                | LOKASI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Lokasi')

                    ->label('LOKASI')

                    ->state(
                        function ($record) {

                            return

                                $record
                                    ->karyawan
                                    ?->lokasi
                                    ?->NamaLokasi

                                ??

                                $record
                                    ->ruangan
                                    ?->lokasi
                                    ?->NamaLokasi

                                ??

                                '-';

                        }
                    )

                    ->badge()

                    ->color(
                        fn ($state) =>
                            $state !== '-'
                                ? 'info'
                                : 'gray'
                    )

                    ->sortable(false),



                /*
                |--------------------------------------------------------------------------
                | LANTAI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Lantai')

                    ->label('LANTAI')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable(),



                /*
                |--------------------------------------------------------------------------
                | JENIS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Jenis')

                    ->label('JENIS PABX')

                    ->badge()

                    ->color(
                        fn (?string $state): string =>
                            match ($state) {

                                'Digital' =>
                                    'info',

                                'Analog' =>
                                    'warning',

                                'IP' =>
                                    'success',

                                default =>
                                    'gray',

                            }
                    )

                    ->sortable(),

            ])



            ->filters([

                //

            ])



            ->recordActions([

                EditAction::make(),

                DeleteAction::make(),

            ])



            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ]);
    }
}
