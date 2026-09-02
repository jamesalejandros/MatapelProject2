<?php

namespace App\Filament\Resources\TrxPabxAssignments\Schemas;

use App\Models\MstKaryawan;
use App\Models\MstRuangan;
use App\Models\MstSambungan;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Schemas\Schema;


class TrxPabxAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([


                /*
                |--------------------------------------------------------------------------
                | ASSET
                |--------------------------------------------------------------------------
                |
                | Hanya Asset dengan Jenis = PABX yang dapat dipilih.
                |
                */

                Select::make('NoAssetIT')

                    ->label('Asset PABX')

                    ->relationship(
                        'asset',
                        'NoAssetIT',
                        fn ($query) =>
                            $query->where(
                                'Jenis',
                                'PABX'
                            )
                    )

                    ->getOptionLabelFromRecordUsing(
                        function ($record) {

                            return

                                ($record->NoAssetIT ?? '-')

                                . ' | '

                                . ($record->NoAssetSAP ?? '-')

                                . ' | '

                                . ($record->Nama ?? '-')

                                . ' | '

                                . ($record->perusahaan?->NamaPerusahaan ?? '-');

                        }
                    )

                    ->searchable([

                        'NoAssetIT',

                        'NoAssetSAP',

                        'Nama',

                    ])

                    ->preload()

                    ->required(),



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
                | Karyawan bersifat OPTIONAL / nullable.
                |
                | Jika assignment memang ditujukan ke ruangan saja,
                | NIK boleh dikosongkan.
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
                                            . " | {$departemen}",

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
                | Lantai dan Lokasi nantinya mengikuti Ruangan.
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
                | User memilih Rule dari tabel MstSambungan.
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
                | Field biasa pada:
                | trxpabxassignment.Keterangan
                |
                */

                Textarea::make('Keterangan')

                    ->label('Keterangan')

                    ->rows(5)

                    ->columnSpanFull()

                    ->nullable(),


            ]);
    }
}
