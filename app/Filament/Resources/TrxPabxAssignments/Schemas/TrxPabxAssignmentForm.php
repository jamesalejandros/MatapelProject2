<?php

namespace App\Filament\Resources\TrxPabxAssignments\Schemas;

use App\Models\MstKaryawan;
use App\Models\MstRuangan;
use App\Models\MstAsset;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

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
                | TARGET ASSIGNMENT
                |--------------------------------------------------------------------------
                */

                Radio::make('TargetAssignment')

                    ->label('Assign Kepada')

                    ->options([

                        'karyawan' =>
                            'Karyawan',

                        'ruangan' =>
                            'Ruangan',

                    ])

                    ->default('karyawan')

                    ->live()

                    ->required(),



                /*
                |--------------------------------------------------------------------------
                | KARYAWAN
                |--------------------------------------------------------------------------
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

                                    $lokasi =
                                        $karyawan
                                            ->lokasi
                                            ?->NamaLokasi
                                        ?? '-';

                                    return [

                                        $karyawan->NIK =>

                                            "{$karyawan->Nama}"
                                            . " | NIK: {$karyawan->NIK}"
                                            . " | {$departemen}"
                                            . " | {$lokasi}",

                                    ];

                                }
                            )

                    )

                    ->searchable()

                    ->preload()

                    ->visible(
                        fn ($get) =>
                            $get('TargetAssignment')
                            === 'karyawan'
                    )

                    ->required(
                        fn ($get) =>
                            $get('TargetAssignment')
                            === 'karyawan'
                    )

                    ->live()

                    ->afterStateUpdated(
                        function ($state, $set) {

                            if ($state) {

                                $set(
                                    'IDRuangan',
                                    null
                                );

                            }

                        }
                    ),



                /*
                |--------------------------------------------------------------------------
                | RUANGAN
                |--------------------------------------------------------------------------
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

                                    return [

                                        $ruangan->IDRuangan =>

                                            "{$ruangan->NamaRuangan}"
                                            . " | Lokasi: {$lokasi}",

                                    ];

                                }
                            )

                    )

                    ->searchable()

                    ->preload()

                    ->visible(
                        fn ($get) =>
                            $get('TargetAssignment')
                            === 'ruangan'
                    )

                    ->required(
                        fn ($get) =>
                            $get('TargetAssignment')
                            === 'ruangan'
                    )

                    ->live()

                    ->afterStateUpdated(
                        function ($state, $set) {

                            if ($state) {

                                $set(
                                    'NIK',
                                    null
                                );

                            }

                        }
                    ),



                /*
                |--------------------------------------------------------------------------
                | LANTAI
                |--------------------------------------------------------------------------
                */

                TextInput::make('Lantai')

                    ->label('Lantai')

                    ->maxLength(50)

                    ->nullable(),



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

            ]);
    }
}
