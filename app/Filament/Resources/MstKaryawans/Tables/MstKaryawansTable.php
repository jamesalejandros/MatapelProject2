<?php

namespace App\Filament\Resources\MstKaryawans\Tables;

use App\Filament\Resources\MstKaryawans\MstKaryawanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstKaryawansTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |--------------------------------------------------------------------------
            | EAGER LOAD
            |--------------------------------------------------------------------------
            |
            | Karena sekarang MstKaryawan memiliki self-reference:
            |
            | mstkaryawan.NIKKepalaBagian
            |          ↓
            | mstkaryawan.NIK
            |
            | Kita eager-load kepalaBagian agar tidak terjadi N+1 query.
            |
            */

            ->modifyQueryUsing(
                function ($query) {
                    $query->with([
                        'perusahaan',
                        'departemen',
                        'kepalaBagian',
                    ]);
                }
            )

            /*
            |--------------------------------------------------------------------------
            | COLUMNS
            |--------------------------------------------------------------------------
            */

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | NIK
                |--------------------------------------------------------------------------
                */

                TextColumn::make('NIK')
                    ->label('NIK')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                /*
                |--------------------------------------------------------------------------
                | NAMA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Nama')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | PERUSAHAAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'perusahaan.NamaPerusahaan'
                )
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | DEPARTEMEN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'departemen.NamaDept'
                )
                    ->label('Departemen')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | KEPALA BAGIAN
                |--------------------------------------------------------------------------
                |
                | Menggunakan self-reference:
                |
                | $record->kepalaBagian
                |
                */

                TextColumn::make(
                    'kepalaBagian.Nama'
                )
                    ->label('Kepala Bagian')
                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {
                            $kepalaBagian =
                                $record->kepalaBagian;

                            if (
                                ! $kepalaBagian
                            ) {
                                return '-';
                            }

                            return
                                ($kepalaBagian->NIK ?? '-')
                                . ' | '
                                . ($kepalaBagian->Nama ?? '-');
                        }
                    )
                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'kepalaBagian',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'mstkaryawan.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'mstkaryawan.Nama',
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
                    ->placeholder('-')
                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | JUMLAH BAWAHAN
                |--------------------------------------------------------------------------
                |
                | Menampilkan jumlah karyawan yang memiliki
                | karyawan ini sebagai Kepala Bagian.
                |
                */

                TextColumn::make(
                    'bawahan_count'
                )
                    ->label('JUMLAH BAWAHAN')
                    ->counts('bawahan')
                    ->sortable()
                    ->badge()
                    ->color('info'),

            ])

            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                /*
                |--------------------------------------------------------------------------
                | EDIT
                |--------------------------------------------------------------------------
                |
                | Tombol Edit hanya ditampilkan apabila user
                | memiliki permission melalui:
                |
                | MstKaryawanResource::canEdit()
                |
                */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstKaryawanResource::canEdit(
                                $record
                            )
                    ),

                /*
                |--------------------------------------------------------------------------
                | DELETE
                |--------------------------------------------------------------------------
                |
                | Tombol Delete hanya ditampilkan apabila user
                | memiliki permission melalui:
                |
                | MstKaryawanResource::canDelete()
                |
                */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstKaryawanResource::canDelete(
                                $record
                            )
                    ),

            ]);

    }
}
