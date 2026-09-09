<?php

namespace App\Filament\Resources\ItRequests\Tables;

use App\Filament\Resources\ItRequests\ItRequestResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItRequestsTable
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
                fn ($record) => ItRequestResource::getUrl(
                    'edit',
                    [
                        'record' => $record,
                    ]
                )
            )

            /*
            |--------------------------------------------------------------------------
            | SORT
            |--------------------------------------------------------------------------
            */

            ->defaultSort(
                'IDRequest',
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

            ->modifyQueryUsing(
                function ($query) {

                    $query->with([

                        /*
                        |--------------------------------------------------------------------------
                        | PEMOHON
                        |--------------------------------------------------------------------------
                        */

                        'pemohon.karyawan.departemen',
                        'pemohon.karyawan.lokasi',
                        'pemohon.kepalaBagian',

                        /*
                        |--------------------------------------------------------------------------
                        | ASSET
                        |--------------------------------------------------------------------------
                        */

                        'assets',

                        /*
                        |--------------------------------------------------------------------------
                        | JENIS PERMINTAAN
                        |--------------------------------------------------------------------------
                        */

                        'jenisPermintaan',

                        /*
                        |--------------------------------------------------------------------------
                        | PENYELESAI
                        |--------------------------------------------------------------------------
                        */

                        'penyelesai.karyawan',

                        /*
                        |--------------------------------------------------------------------------
                        | USER TERKAIT
                        |--------------------------------------------------------------------------
                        */

                        'relatedUsers.karyawan.departemen',

                        /*
                        |--------------------------------------------------------------------------
                        | APPROVAL KEPALA BAGIAN
                        |--------------------------------------------------------------------------
                        */

                        'approval.kepalaBagian',

                    ]);

                }
            )

            /*
            |--------------------------------------------------------------------------
            | GLOBAL SEARCH
            |--------------------------------------------------------------------------
            |
            | Search manual agar:
            |
            | - No Request
            | - Pemohon
            | - NIK
            | - Email
            | - Departemen
            | - Jenis Permintaan
            | - Permintaan
            | - Keterangan
            | - Asset
            | - Bagian Terkait
            | - Kepala Bagian
            | - Penyelesai
            |
            | semuanya bisa dicari.
            |
            */

            ->searchable()

            ->modifyQueryUsing(
                function ($query) {

                    /*
                    |--------------------------------------------------------------------------
                    | AMBIL SEARCH
                    |--------------------------------------------------------------------------
                    */

                    $search =
                        request()->query('tableSearch')
                        ??
                        request()->query('search');

                    if (blank($search)) {
                        return;
                    }

                    $search = trim($search);

                    /*
                    |--------------------------------------------------------------------------
                    | SEARCH GROUP
                    |--------------------------------------------------------------------------
                    */

                    $query->where(
                        function ($query) use ($search) {

                            /*
                            |--------------------------------------------------------------------------
                            | NO REQUEST
                            |--------------------------------------------------------------------------
                            */

                            $query->where(
                                'it_requests.NoRequest',
                                'like',
                                "%{$search}%"
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | PEMOHON
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'pemohon',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'users.name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.email',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | DEPARTEMEN
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'pemohon.karyawan.departemen',
                                function ($query) use ($search) {

                                    $query->where(
                                        'mstdepartemen.NamaDept',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PERMINTAAN
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'jenisPermintaan',
                                function ($query) use ($search) {

                                    $query->where(
                                        'mstjenispermintaan.name',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | PERMINTAAN
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhere(
                                'it_requests.Permintaan',
                                'like',
                                "%{$search}%"
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhere(
                                'it_requests.Keterangan',
                                'like',
                                "%{$search}%"
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | ASSET
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'assets',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'mstasset.NoAssetIT',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'mstasset.NoAssetSAP',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'mstasset.Nama',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'mstasset.SN',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | BAGIAN TERKAIT
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'relatedUsers',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'users.name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.email',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | KEPALA BAGIAN
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'pemohon.kepalaBagian',
                                function ($query) use ($search) {

                                    $query->where(
                                        'mstkepalabagian.name',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | PENYELESAI
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'penyelesai',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'users.name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.email',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                        }
                    );

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
                | NO
                |--------------------------------------------------------------------------
                */

                TextColumn::make('No')
                    ->label('NO')
                    ->rowIndex()
                    ->weight('bold')
                    ->width('70px'),

                /*
                |--------------------------------------------------------------------------
                | NO REQUEST
                |--------------------------------------------------------------------------
                */

                TextColumn::make('NoRequest')
                    ->label('NO. REQUEST')
                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->where(
                                'it_requests.NoRequest',
                                'like',
                                "%{$search}%"
                            );

                        }
                    )
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->width('150px')
                    ->wrap()
                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | PEMOHON
                |--------------------------------------------------------------------------
                */

                TextColumn::make('pemohon.name')
                    ->label('PEMOHON')

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            $nama =
                                $record
                                    ->pemohon
                                    ?->karyawan
                                    ?->Nama
                                ??
                                $record
                                    ->pemohon
                                    ?->name
                                ??
                                '-';

                            $nik =
                                $record
                                    ->pemohon
                                    ?->NIK
                                ??
                                '-';

                            return
                                $nama
                                . ' | NIK: '
                                . $nik;

                        }
                    )

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'pemohon',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'users.name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.email',
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

                    ->width('220px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | DEPARTEMEN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'pemohon.karyawan.departemen.NamaDept'
                )

                    ->label('DEPARTEMEN')

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            return
                                $record
                                    ->pemohon
                                    ?->karyawan
                                    ?->departemen
                                    ?->NamaDept
                                ??
                                '-';

                        }
                    )

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'pemohon.karyawan.departemen',
                                function ($query) use ($search) {

                                    $query->where(
                                        'mstdepartemen.NamaDept',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                        }
                    )

                    ->width('180px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | JENIS PERMINTAAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'jenisPermintaan'
                )

                    ->label('JENIS')

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            if (
                                ! $record->jenisPermintaan
                                ||
                                $record
                                    ->jenisPermintaan
                                    ->isEmpty()
                            ) {

                                return '-';

                            }

                            return
                                $record
                                    ->jenisPermintaan
                                    ->map(
                                        function ($jenis) {

                                            return
                                                $jenis->name
                                                ??
                                                '-';

                                        }
                                    )
                                    ->filter()
                                    ->implode(', ');

                        }
                    )

                    ->badge()

                    ->color('violet')

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'jenisPermintaan',
                                function ($query) use ($search) {

                                    $query->where(
                                        'mstjenispermintaan.name',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                        }
                    )

                    ->width('180px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | PERMINTAAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Permintaan')

                    ->label('PERMINTAAN')

                    ->limit(80)

                    ->wrap()

                    ->lineClamp(5)

                    ->width('300px')

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->where(
                                'it_requests.Permintaan',
                                'like',
                                "%{$search}%"
                            );

                        }
                    ),

                /*
                |--------------------------------------------------------------------------
                | ASSET IT
                |--------------------------------------------------------------------------
                */

                TextColumn::make('assets')

                    ->label('ASSET IT')

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            if (
                                ! $record->assets
                                ||
                                $record->assets->isEmpty()
                            ) {

                                return '-';

                            }

                            return
                                $record
                                    ->assets
                                    ->map(
                                        function ($asset) {

                                            $noAsset =
                                                $asset->NoAssetIT
                                                ??
                                                '-';

                                            $namaAsset =
                                                $asset->Nama
                                                ??
                                                '';

                                            if (
                                                $namaAsset === ''
                                            ) {

                                                return
                                                    $noAsset;

                                            }

                                            return
                                                $noAsset
                                                . ' | '
                                                . $namaAsset;

                                        }
                                    )
                                    ->implode(', ');

                        }
                    )

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'assets',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'mstasset.NoAssetIT',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'mstasset.NoAssetSAP',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'mstasset.Nama',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'mstasset.SN',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                        }
                    )

                    ->width('250px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | BAGIAN TERKAIT
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'relatedUsers.name'
                )

                    ->label('BAGIAN TERKAIT')

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            if (
                                ! $record->relatedUsers
                                ||
                                $record
                                    ->relatedUsers
                                    ->isEmpty()
                            ) {

                                return '-';

                            }

                            return
                                $record
                                    ->relatedUsers
                                    ->map(
                                        function ($user) {

                                            $nik =
                                                $user->NIK
                                                ??
                                                '-';

                                            $nama =
                                                $user
                                                    ->karyawan
                                                    ?->Nama
                                                ??
                                                $user->name
                                                ??
                                                '-';

                                            $dept =
                                                $user
                                                    ->karyawan
                                                    ?->departemen
                                                    ?->NamaDept
                                                ??
                                                '-';

                                            return
                                                $nik
                                                . ' - '
                                                . $nama
                                                . ' - '
                                                . $dept;

                                        }
                                    )
                                    ->implode(', ');

                        }
                    )

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'relatedUsers',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'users.name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.email',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                        }
                    )

                    ->placeholder('-')

                    ->width('300px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | KEPALA BAGIAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'pemohon.kepalaBagian.name'
                )

                    ->label('KEPALA BAGIAN')

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            return
                                $record
                                    ->pemohon
                                    ?->kepalaBagian
                                    ?->name
                                ??
                                '-';

                        }
                    )

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'pemohon.kepalaBagian',
                                function ($query) use ($search) {

                                    $query->where(
                                        'mstkepalabagian.name',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                        }
                    )

                    ->width('220px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | APPROVAL KEPALA BAGIAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'approval.status'
                )

                    ->label(
                        'APPROVAL KEPALA BAGIAN'
                    )

                    ->badge()

                    ->formatStateUsing(
                        function (
                            $state
                        ) {

                            return match ($state) {

                                'pending' =>
                                    'Menunggu Persetujuan',

                                'approved' =>
                                    'Disetujui',

                                'rejected' =>
                                    'Ditolak',

                                default =>
                                    $state
                                    ?
                                    ucfirst($state)
                                    :
                                    'Belum Ada',

                            };

                        }
                    )

                    ->color(
                        function (
                            $state
                        ) {

                            return match ($state) {

                                'pending' =>
                                    'warning',

                                'approved' =>
                                    'success',

                                'rejected' =>
                                    'danger',

                                default =>
                                    'gray',

                            };

                        }
                    )

                    ->placeholder(
                        'Belum Ada'
                    )

                    ->width('220px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | PENYELESAI
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'penyelesai.name'
                )

                    ->label('PENYELESAI')

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            return
                                $record
                                    ->penyelesai
                                    ?->karyawan
                                    ?->Nama
                                ??
                                $record
                                    ->penyelesai
                                    ?->name
                                ??
                                '-';

                        }
                    )

                    ->searchable(
                        query: function (
                            $query,
                            string $search
                        ): void {

                            $query->whereHas(
                                'penyelesai',
                                function ($query) use ($search) {

                                    $query->where(
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'users.name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.NIK',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'users.email',
                                                    'like',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                                }
                            );

                        }
                    )

                    ->placeholder('-')

                    ->sortable()

                    ->width('220px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | STATUS REQUEST
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Status')

                    ->label('STATUS')

                    ->badge()

                    ->formatStateUsing(
                        fn ($state) => match ($state) {

                            'diajukan' =>
                                'Diajukan',

                            'disetujui' =>
                                'Disetujui',

                            'diproses' =>
                                'Diproses',

                            'selesai' =>
                                'Selesai',

                            'ditolak' =>
                                'Ditolak',

                            'dibatalkan' =>
                                'Dibatalkan',

                            default =>
                                $state
                                ?
                                ucfirst($state)
                                :
                                '-',

                        }
                    )

                    ->color(
                        fn ($state) => match ($state) {

                            'diajukan' =>
                                'warning',

                            'disetujui' =>
                                'success',

                            'diproses' =>
                                'info',

                            'selesai' =>
                                'success',

                            'ditolak' =>
                                'danger',

                            'dibatalkan' =>
                                'gray',

                            default =>
                                'gray',

                        }
                    )

                    ->sortable()

                    ->width('140px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | SERAH TERIMA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('SerahTerima')

                    ->label('SERAH TERIMA')

                    ->badge()

                    ->formatStateUsing(
                        function (
                            $state,
                            $record
                        ) {

                            if (
                                $record->SerahTerima === true
                            ) {

                                return 'Sudah Diterima';

                            }

                            if (
                                $record->isSelesai()
                            ) {

                                return 'Menunggu Serah Terima';

                            }

                            return 'Belum';

                        }
                    )

                    ->color(
                        function (
                            $state,
                            $record
                        ) {

                            if (
                                $record->SerahTerima === true
                            ) {

                                return 'success';

                            }

                            if (
                                $record->isSelesai()
                            ) {

                                return 'warning';

                            }

                            return 'gray';

                        }
                    )

                    ->sortable()

                    ->width('200px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | TANGGAL SERAH TERIMA
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'TanggalSerahTerima'
                )

                    ->label(
                        'TANGGAL SERAH TERIMA'
                    )

                    ->dateTime(
                        'd/m/Y H:i'
                    )

                    ->placeholder('-')

                    ->sortable()

                    ->width('190px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | RENCANA SELESAI
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'RencanaSelesai'
                )

                    ->label(
                        'RENCANA SELESAI'
                    )

                    ->date('d/m/Y')

                    ->placeholder('-')

                    ->sortable()

                    ->width('160px')

                    ->wrap()

                    ->lineClamp(5),

                /*
                |--------------------------------------------------------------------------
                | TANGGAL REQUEST
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'created_at'
                )

                    ->label(
                        'DIAJUKAN'
                    )

                    ->dateTime(
                        'd/m/Y H:i'
                    )

                    ->sortable()

                    ->width('180px')

                    ->wrap()

                    ->lineClamp(5),

            ])

            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            ->filters([

                /*
                |--------------------------------------------------------------------------
                | FILTER JENIS PERMINTAAN
                |--------------------------------------------------------------------------
                |
                | Menggunakan whereHas karena JenisPermintaan adalah
                | relasi many-to-many.
                |
                */

                SelectFilter::make(
                    'jenis_permintaan'
                )

                    ->label(
                        'Jenis Permintaan'
                    )

                    ->options([

                        'hardware' =>
                            'Hardware',

                        'software' =>
                            'Software',

                        'data' =>
                            'Data',

                        'lain_lain' =>
                            'Lain-lain',

                    ])

                    ->multiple()

                    ->query(
                        function (
                            $query,
                            array $data
                        ) {

                            $values =
                                $data['values']
                                ?? [];

                            if (
                                empty($values)
                            ) {
                                return;
                            }

                            $query->whereHas(
                                'jenisPermintaan',
                                function ($query) use (
                                    $values
                                ) {

                                    $query->whereIn(
                                        'mstjenispermintaan.name',
                                        $values
                                    );

                                }
                            );

                        }
                    ),

                /*
                |--------------------------------------------------------------------------
                | FILTER APPROVAL KEPALA BAGIAN
                |--------------------------------------------------------------------------
                |
                | Approval merupakan relasi.
                |
                | Filter menggunakan whereHas agar tidak bergantung
                | pada kolom approval_status di it_requests.
                |
                */

                SelectFilter::make(
                    'approval_status'
                )

                    ->label(
                        'Approval Kepala Bagian'
                    )

                    ->options([

                        'pending' =>
                            'Menunggu Persetujuan',

                        'approved' =>
                            'Disetujui',

                        'rejected' =>
                            'Ditolak',

                    ])

                    ->query(
                        function (
                            $query,
                            array $data
                        ) {

                            $value =
                                $data['value']
                                ?? null;

                            if (
                                blank($value)
                            ) {
                                return;
                            }

                            $query->whereHas(
                                'approval',
                                function ($query) use (
                                    $value
                                ) {

                                    $query->where(
                                        'status',
                                        $value
                                    );

                                }
                            );

                        }
                    ),

                /*
                |--------------------------------------------------------------------------
                | FILTER STATUS REQUEST
                |--------------------------------------------------------------------------
                */

                SelectFilter::make(
                    'Status'
                )

                    ->label(
                        'Status Request'
                    )

                    ->options([

                        'diajukan' =>
                            'Diajukan',

                        'disetujui' =>
                            'Disetujui',

                        'diproses' =>
                            'Diproses',

                        'selesai' =>
                            'Selesai',

                        'ditolak' =>
                            'Ditolak',

                        'dibatalkan' =>
                            'Dibatalkan',

                    ])

                    ->query(
                        function (
                            $query,
                            array $data
                        ) {

                            $value =
                                $data['value']
                                ?? null;

                            if (
                                blank($value)
                            ) {
                                return;
                            }

                            $query->where(
                                'it_requests.Status',
                                $value
                            );

                        }
                    ),

                /*
                |--------------------------------------------------------------------------
                | FILTER SERAH TERIMA
                |--------------------------------------------------------------------------
                */

                SelectFilter::make(
                    'SerahTerima'
                )

                    ->label(
                        'Serah Terima'
                    )

                    ->options([

                        '1' =>
                            'Sudah Diterima',

                        '0' =>
                            'Belum / Menunggu Serah Terima',

                    ])

                    ->query(
                        function (
                            $query,
                            array $data
                        ) {

                            $value =
                                $data['value']
                                ?? null;

                            if (
                                blank($value)
                            ) {
                                return;
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | SUDAH DITERIMA
                            |--------------------------------------------------------------------------
                            |
                            | Nilai SerahTerima = 1.
                            |
                            */

                            if (
                                $value === '1'
                            ) {

                                $query->where(
                                    'it_requests.SerahTerima',
                                    1
                                );

                                return;

                            }

                            /*
                            |--------------------------------------------------------------------------
                            | BELUM / MENUNGGU SERAH TERIMA
                            |--------------------------------------------------------------------------
                            |
                            | Data yang belum serah terima bisa berupa:
                            |
                            | - NULL
                            | - string kosong ''
                            | - 0
                            |
                            | Jadi semuanya dimasukkan ke filter ini.
                            |
                            */

                            if (
                                $value === '0'
                            ) {

                                $query->where(
                                    function ($query) {

                                        $query
                                            ->whereNull(
                                                'it_requests.SerahTerima'
                                            )
                                            ->orWhere(
                                                'it_requests.SerahTerima',
                                                ''
                                            )
                                            ->orWhere(
                                                'it_requests.SerahTerima',
                                                0
                                            );

                                    }
                                );

                            }

                        }
                    ),

            ])

            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                EditAction::make()

                    ->visible(
                        fn ($record) =>
                            ItRequestResource::canEdit(
                                $record
                            )
                    ),

                DeleteAction::make()

                    ->visible(
                        fn ($record) =>
                            ItRequestResource::canDelete(
                                $record
                            )
                    ),

            ])

            /*
            |--------------------------------------------------------------------------
            | BULK ACTIONS
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make()

                        ->visible(
                            fn () =>
                                auth()->check()
                                &&
                                auth()
                                    ->user()
                                    ->can(
                                        'itrequest.delete'
                                    )
                        ),

                ]),

            ]);

    }
}
