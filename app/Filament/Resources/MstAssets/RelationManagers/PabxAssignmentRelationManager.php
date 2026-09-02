<?php

namespace App\Filament\Resources\MstAssets\RelationManagers;

use App\Models\MstKaryawan;
use App\Models\MstRuangan;
use App\Models\MstSambungan;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class PabxAssignmentRelationManager extends RelationManager
{
    protected static string $relationship = 'pabxAssignment';


    /**
     * Hanya tampil untuk Asset dengan Jenis = PABX
     */
    public static function canViewForRecord(
        $ownerRecord,
        string $pageClass
    ): bool {

        return $ownerRecord->Jenis === 'PABX';

    }


    public function form(Schema $schema): Schema
    {
        return $schema

            ->components([


                /*
                |--------------------------------------------------------------------------
                | NOMOR EXTENSION
                |--------------------------------------------------------------------------
                */

                TextInput::make('NoExt')

                    ->label('No. Extension')

                    ->required()

                    ->maxLength(50),



                /*
                |--------------------------------------------------------------------------
                | KARYAWAN
                |--------------------------------------------------------------------------
                |
                | Karyawan boleh kosong.
                |
                | Jika diisi:
                |
                | NIK
                |  ↓
                | MstKaryawan
                |  ↓
                | Department
                |
                */

                Select::make('NIK')

                    ->label('Karyawan')

                    ->options(

                        MstKaryawan::query()

                            ->with([
                                'departemen',
                                'lokasi',
                            ])

                            ->orderBy('Nama')

                            ->get()

                            ->mapWithKeys(
                                function ($karyawan) {

                                    $departemen =
                                        $karyawan
                                            ->departemen
                                                ?->NamaDept
                                        ?? '-';



                                    return [

                                        $karyawan->NIK =>

                                            "{$karyawan->Nama}"
                                            . " | NIK: {$karyawan->NIK}"
                                            . " | {$departemen}"
                                            ,

                                    ];

                                }
                            )

                    )

                    ->searchable()

                    ->preload()

                    ->nullable(),



                /*
                |--------------------------------------------------------------------------
                | RUANGAN
                |--------------------------------------------------------------------------
                |
                | Ruangan wajib dipilih.
                |
                | Lantai dan Lokasi nantinya diambil dari Ruangan.
                |
                */

                Select::make('IDRuangan')

                    ->label('Ruangan')

                    ->options(

                        MstRuangan::query()

                            ->with('lokasi')

                            ->orderBy('NamaRuangan')

                            ->get()

                            ->mapWithKeys(
                                function ($ruangan) {

                                    $lokasi =
                                        $ruangan
                                            ->lokasi
                                                ?->NamaLokasi
                                        ?? '-';


                                    $lantai =
                                        $ruangan->Lantai
                                        ??
                                        '-';


                                    return [

                                        $ruangan->IDRuangan =>

                                            "{$ruangan->NamaRuangan}"
                                            . " | Lantai: {$lantai}"
                                            . " | {$lokasi}",

                                    ];

                                }
                            )

                    )

                    ->searchable()

                    ->preload()

                    ->required(),



                /*
                |--------------------------------------------------------------------------
                | JENIS PABX
                |--------------------------------------------------------------------------
                */

                Select::make('Jenis')

                    ->label('Jenis PABX')

                    ->options([

                        'Digital' =>
                            'Digital',

                        'Analog' =>
                            'Analog',

                        'IP' =>
                            'IP',

                    ])

                    ->required(),



                /*
                |--------------------------------------------------------------------------
                | PIN
                |--------------------------------------------------------------------------
                */

                TextInput::make('Pin')

                    ->label('PIN')

                    ->maxLength(100)

                    ->nullable(),



                /*
                |--------------------------------------------------------------------------
                | SAMBUNGAN
                |--------------------------------------------------------------------------
                |
                | Database:
                | trxpabxassignment.IDSambungan
                |
                | Relasi:
                | trxpabxassignment
                |       ↓
                | IDSambungan
                |       ↓
                | mstsambungan
                |       ↓
                | Rule
                |
                */

                Select::make('IDSambungan')

                    ->label('Sambungan')

                    ->options(

                        MstSambungan::query()

                            ->orderBy('Rule')

                            ->pluck(
                                'Rule',
                                'IDSambungan'
                            )

                    )

                    ->searchable()

                    ->preload()

                    ->nullable(),



                /*
                |--------------------------------------------------------------------------
                | KETERANGAN
                |--------------------------------------------------------------------------
                |
                | Field biasa pada trxpabxassignment.
                |
                */

                Textarea::make('Keterangan')

                    ->label('Keterangan')

                    ->rows(5)

                    ->columnSpanFull()

                    ->nullable(),


            ]);
    }


    public function table(Table $table): Table
{
    return $table

        ->recordTitleAttribute('NoExt')

        ->defaultSort('IDAssignment', 'desc')


        /*
        |--------------------------------------------------------------------------
        | EAGER LOAD
        |--------------------------------------------------------------------------
        */

        ->modifyQueryUsing(
            function ($query) {

                $query->with([

                    'asset',

                    'karyawan.departemen',

                    'karyawan.lokasi',

                    'ruangan.lokasi',

                    'sambungan',

                ]);

            }
        )


        ->columns([


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

                ->searchable()

                ->sortable()

                ->wrap(),



            /*
            |--------------------------------------------------------------------------
            | IP ADDRESS
            |--------------------------------------------------------------------------
            |
            | Sumber:
            |
            | trxpabxassignment.NoAssetIT
            |       ↓
            | mstasset
            |       ↓
            | IPAddress
            |
            */

            TextColumn::make('asset.IPAddress')

                ->label('IP ADDRESS')

                ->placeholder('-')

                ->searchable()

                ->sortable()

                ->copyable()

                ->toggleable(),



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
            | DEPARTMENT
            |--------------------------------------------------------------------------
            |
            | Diambil dari:
            |
            | trxpabxassignment.NIK
            |       ↓
            | mstkaryawan
            |       ↓
            | departemen
            |
            */

            TextColumn::make(
                'karyawan.departemen.NamaDept'
            )

                ->label('DEPARTMENT')

                ->placeholder('-')

                ->badge()

                ->color('primary')

                ->searchable()

                ->sortable()

                ->toggleable(),



            /*
            |--------------------------------------------------------------------------
            | RUANGAN
            |--------------------------------------------------------------------------
            */

            TextColumn::make(
                'ruangan.NamaRuangan'
            )

                ->label('RUANGAN')

                ->placeholder('-')

                ->searchable()

                ->sortable()

                ->wrap(),



            /*
            |--------------------------------------------------------------------------
            | LOKASI
            |--------------------------------------------------------------------------
            |
            | Assignment
            |     ↓
            | Ruangan
            |     ↓
            | Lokasi
            |
            */

            TextColumn::make(
                'ruangan.lokasi.NamaLokasi'
            )

                ->label('LOKASI')

                ->placeholder('-')

                ->badge()

                ->color(
                    fn ($state) =>
                        $state
                            ? 'info'
                            : 'gray'
                )

                ->searchable()

                ->sortable(),



            /*
            |--------------------------------------------------------------------------
            | LANTAI
            |--------------------------------------------------------------------------
            |
            | Tidak lagi mengambil dari trxpabxassignment.
            |
            | Sekarang:
            |
            | trxpabxassignment
            |        ↓
            | IDRuangan
            |        ↓
            | mstruangan.Lantai
            |
            */

            TextColumn::make(
                'ruangan.Lantai'
            )

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



            /*
            |--------------------------------------------------------------------------
            | PIN
            |--------------------------------------------------------------------------
            */

            TextColumn::make('Pin')

                ->label('PIN')

                ->placeholder('-')

                ->searchable()

                ->toggleable(),



            /*
            |--------------------------------------------------------------------------
            | SAMBUNGAN
            |--------------------------------------------------------------------------
            |
            | Database:
            | trxpabxassignment.IDSambungan
            |
            | Ditampilkan dari:
            | mstsambungan.Rule
            |
            */

            TextColumn::make('sambungan.Rule')

                ->label('SAMBUNGAN')

                ->placeholder('-')

                ->searchable()

                ->sortable()

                ->wrap()

                ->toggleable(),



            /*
            |--------------------------------------------------------------------------
            | KETERANGAN
            |--------------------------------------------------------------------------
            |
            | Field langsung dari:
            | trxpabxassignment.Keterangan
            |
            */

            TextColumn::make('Keterangan')

                ->label('KETERANGAN')

                ->placeholder('-')

                ->searchable()

                ->sortable()

                ->wrap()

                ->toggleable(),


        ])


        ->filters([])


        ->headerActions([

            CreateAction::make(),

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
