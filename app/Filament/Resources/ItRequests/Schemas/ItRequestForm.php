<?php

namespace App\Filament\Resources\ItRequests\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ItRequestForm
{
    public static function configure(
        Schema $schema
    ): Schema {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | INFORMASI REQUEST
                |--------------------------------------------------------------------------
                */

                Section::make(
                    'Informasi Permintaan'
                )
                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | NO REQUEST
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make(
                            'NoRequest'
                        )
                            ->label(
                                'No. Request'
                            )
                            ->disabled()
                            ->dehydrated(false),

                        /*
                        |--------------------------------------------------------------------------
                        | PEMOHON
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'UserPemohonID'
                        )
                            ->label(
                                'Pemohon'
                            )
                            ->relationship(
                                'pemohon',
                                'name'
                            )
                            ->getOptionLabelFromRecordUsing(
                                function (
                                    User $record
                                ): string {
                                    return
                                        ($record->NIK ?? '-')
                                        . ' | '
                                        . (
                                            $record->karyawan?->Nama
                                            ?? $record->name
                                        );
                                }
                            )
                            ->searchable([
                                'name',
                                'email',
                                'NIK',
                            ])
                            ->preload()
                            ->disabled()
                            ->dehydrated(false),

                        /*
                        |--------------------------------------------------------------------------
                        | JENIS PERMINTAAN - MULTIPLE
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'jenisPermintaan'
                        )
                            ->label(
                                'Jenis Permintaan'
                            )
                            ->relationship(
                                'jenisPermintaan',
                                'name'
                            )
                            ->getOptionLabelFromRecordUsing(
                                function (
                                    $record
                                ): string {
                                    return
                                        $record->Nama
                                        ?? $record->name
                                        ?? $record->JenisPermintaan
                                        ?? '-';
                                }
                            )
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | ASSET IT - MULTIPLE
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'assets'
                        )
                            ->label(
                                'No. Asset IT'
                            )
                            ->relationship(
                                'assets',
                                'NoAssetIT'
                            )
                            ->getOptionLabelFromRecordUsing(
                                function (
                                    $record
                                ): string {
                                    return
                                        ($record->NoAssetIT ?? '-')
                                        . ' | '
                                        . ($record->Nama ?? '-');
                                }
                            )
                            ->searchable([
                                'NoAssetIT',
                                'NoAssetSAP',
                                'Nama',
                                'SN',
                            ])
                            ->preload()
                            ->multiple()
                            ->nullable()
                            ->helperText(
                                'Asset dapat dipilih lebih dari satu.'
                            )
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | PERMINTAAN
                        |--------------------------------------------------------------------------
                        */

                        Textarea::make(
                            'Permintaan'
                        )
                            ->label(
                                'Permintaan'
                            )
                            ->rows(6)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | KETERANGAN
                        |--------------------------------------------------------------------------
                        */

                        Textarea::make(
                            'Keterangan'
                        )
                            ->label(
                                'Keterangan'
                            )
                            ->rows(8)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | BAGIAN TERKAIT
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'relatedUsers'
                        )
                            ->label(
                                'Bagian Terkait'
                            )
                            ->relationship(
                                'relatedUsers',
                                'name'
                            )
                            ->getOptionLabelFromRecordUsing(
                                function (
                                    User $record
                                ): string {
                                    $nik =
                                        $record->NIK
                                        ?? '-';

                                    $nama =
                                        $record->karyawan?->Nama
                                        ?? $record->name;

                                    $dept =
                                        $record
                                            ->karyawan
                                            ?->departemen
                                            ?->NamaDept
                                        ?? $record
                                            ->karyawan
                                            ?->departemen
                                            ?->NamaDepartemen
                                        ?? '-';

                                    return
                                        "{$nik} | {$nama} | {$dept}";
                                }
                            )
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->helperText(
                                'Bagian terkait tidak dapat diubah dari halaman Admin.'
                            ),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | APPROVAL KEPALA BAGIAN
                |--------------------------------------------------------------------------
                */

                Section::make(
                    'Persetujuan Kepala Bagian'
                )
                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | KEPALA BAGIAN
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make(
                            'approval_kepala_bagian'
                        )
                            ->label(
                                'Kepala Bagian'
                            )
                            ->formatStateUsing(
                                function ($state, $record) {
                                    return
                                        $record
                                            ?->approval
                                            ?->kepalaBagian
                                            ?->name
                                        ?? $record
                                            ?->pemohon
                                            ?->kepalaBagian
                                            ?->name
                                        ?? '-';
                                }
                            )
                            ->disabled()
                            ->dehydrated(false),

                        /*
                        |--------------------------------------------------------------------------
                        | STATUS APPROVAL
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make(
                            'approval_status'
                        )
                            ->label(
                                'Status Approval'
                            )
                            ->formatStateUsing(
                                function ($state, $record) {
                                    return match (
                                        $record?->approval?->status
                                    ) {
                                        'pending' =>
                                            'Menunggu Persetujuan',

                                        'approved' =>
                                            'Disetujui',

                                        'rejected' =>
                                            'Ditolak',

                                        default =>
                                            'Belum Ada',
                                    };
                                }
                            )
                            ->disabled()
                            ->dehydrated(false),

                        /*
                        |--------------------------------------------------------------------------
                        | TANGGAL APPROVAL
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make(
                            'approval_date'
                        )
                            ->label(
                                'Tanggal Persetujuan'
                            )
                            ->formatStateUsing(
                                function ($state, $record) {
                                    return
                                        $record
                                            ?->approval
                                            ?->approved_at
                                            ?->format(
                                                'd/m/Y H:i'
                                            )
                                        ?? '-';
                                }
                            )
                            ->disabled()
                            ->dehydrated(false),

                        /*
                        |--------------------------------------------------------------------------
                        | CATATAN KEPALA BAGIAN
                        |--------------------------------------------------------------------------
                        */

                        Textarea::make(
                            'approval_catatan'
                        )
                            ->label(
                                'Catatan Kepala Bagian'
                            )
                            ->formatStateUsing(
                                function ($state, $record) {
                                    return
                                        $record
                                            ?->approval
                                            ?->catatan
                                        ?? '-';
                                }
                            )
                            ->rows(5)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | PENYELESAIAN
                |--------------------------------------------------------------------------
                */

                Section::make(
                    'Penyelesaian'
                )
                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | PENYELESAI
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'UserPenyelesaiID'
                        )
                            ->label(
                                'Yang Menyelesaikan'
                            )
                            ->relationship(
                                'penyelesai',
                                'name',
                                modifyQueryUsing:
                                    function (
                                        Builder $query
                                    ) {
                                        $query->whereHas(
                                            'roles',
                                            function (
                                                $roleQuery
                                            ) {
                                                $roleQuery->whereIn(
                                                    'name',
                                                    [
                                                        'super_admin',
                                                        'staff_it',
                                                    ]
                                                );
                                            }
                                        );
                                    }
                            )
                            ->getOptionLabelFromRecordUsing(
                                function (
                                    User $record
                                ): string {
                                    return
                                        ($record->NIK ?? '-')
                                        . ' | '
                                        . (
                                            $record
                                                ->karyawan
                                                ?->Nama
                                            ?? $record->name
                                        );
                                }
                            )
                            ->searchable([
                                'name',
                                'email',
                                'NIK',
                            ])
                            ->preload()
                            ->default(
                                fn (): ?int =>
                                    auth()->id()
                            )
                            ->afterStateHydrated(
                                function (
                                    Select $component,
                                    $state
                                ): void {
                                    if (
                                        blank($state)
                                        &&
                                        auth()->check()
                                    ) {
                                        $component->state(
                                            auth()->id()
                                        );
                                    }
                                }
                            )
                            ->disabled()
                            ->dehydrated(),

                        /*
                        |--------------------------------------------------------------------------
                        | STATUS
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'Status'
                        )
                            ->label(
                                'Status'
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
                            ->required()

                            /*
                            |--------------------------------------------------------------------------
                            | OTOMATIS TANGGAL SELESAI
                            |--------------------------------------------------------------------------
                            |
                            | Ketika Admin memilih status "Selesai",
                            | TanggalSelesai otomatis menjadi waktu sekarang.
                            |
                            */

                            ->live()

                            ->afterStateUpdated(
                                function (
                                    $state,
                                    callable $set
                                ): void {

                                    if (
                                        $state === 'selesai'
                                    ) {
                                        $set(
                                            'TanggalSelesai',
                                            now()
                                        );
                                    }

                                }
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | RENCANA SELESAI
                        |--------------------------------------------------------------------------
                        */

                        DatePicker::make(
                            'RencanaSelesai'
                        )
                            ->label(
                                'Rencana Selesai'
                            )
                            ->nullable(),

                        /*
                        |--------------------------------------------------------------------------
                        | TANGGAL SELESAI
                        |--------------------------------------------------------------------------
                        */

                        DateTimePicker::make(
                            'TanggalSelesai'
                        )
                            ->label(
                                'Tanggal Selesai'
                            )
                            ->nullable(),

                        /*
                        |--------------------------------------------------------------------------
                        | CATATAN PENYELESAIAN
                        |--------------------------------------------------------------------------
                        */

                        Textarea::make(
                            'CatatanPenyelesaian'
                        )
                            ->label(
                                'Catatan Penyelesaian'
                            )
                            ->rows(6)
                            ->nullable()
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | SERAH TERIMA
                        |--------------------------------------------------------------------------
                        |
                        | Read-only.
                        |
                        | Admin hanya dapat melihat status serah terima
                        | dan tanggal serah terima. Nilai tidak dikirim
                        | kembali dari form.
                        |
                        */

                        TextInput::make(
                            'SerahTerima'
                        )
                            ->label(
                                'Serah Terima'
                            )
                            ->formatStateUsing(
                                function (
                                    $state,
                                    $record
                                ) {

                                    return $record?->SerahTerima
                                        ? 'Sudah Serah Terima'
                                        : 'Belum Serah Terima';

                                }
                            )
                            ->disabled()
                            ->dehydrated(false),

                        /*
                        |--------------------------------------------------------------------------
                        | TANGGAL SERAH TERIMA
                        |--------------------------------------------------------------------------
                        */

                        DateTimePicker::make(
                            'TanggalSerahTerima'
                        )
                            ->label(
                                'Tanggal Serah Terima'
                            )
                            ->disabled()
                            ->dehydrated(false)
                            ->nullable(),

                    ])
                    ->columns(2),
            ]);
    }
}
