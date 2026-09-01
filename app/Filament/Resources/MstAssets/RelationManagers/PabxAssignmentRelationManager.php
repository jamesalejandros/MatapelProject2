<?php

namespace App\Filament\Resources\MstAssets\RelationManagers;

use App\Models\MstKaryawan;
use App\Models\MstRuangan;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

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
| trxpabxassignment.Sambungan
|
| Tipe:
| STRING nullable
|
| User dapat:
| 1. Memilih opsi yang sudah tersedia
| 2. Mengetik nilai custom sendiri
|
*/

                TextInput::make('Sambungan')

                    ->label('Sambungan')

                    ->maxLength(255)

                    ->nullable()

                    ->datalist([

                        'Telephone keluar hanya lokal saja, tidak bisa HP',

                        'Telephone keluar lokal, interlokal (antar daearah / kode area indonesia) dan HP',

                        'Hanya internal pabrik dan gudang. Tidak bisa telephone keluar',

                    ]),


            ]);
    }


    public function table(Table $table): Table
{
    return $table

        ->recordTitleAttribute('NoExt')


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
            */

            TextColumn::make('Sambungan')

                ->label('SAMBUNGAN')

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
