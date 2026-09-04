<?php

namespace App\Filament\Resources\MstAssets\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class CctvAssignmentRelationManager extends RelationManager
{
    protected static string $relationship = 'cctvAssignment';


    /**
     * Hanya tampil untuk Asset dengan Jenis = CCTV.
     */
    public static function canViewForRecord(
        $ownerRecord,
        string $pageClass
    ): bool {

        return $ownerRecord->Jenis === 'CCTV';

    }


    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    public function form(Schema $schema): Schema
    {
        return $schema

            ->components([


                /*
                |--------------------------------------------------------------------------
                | CHANNEL
                |--------------------------------------------------------------------------
                */

                TextInput::make('Channel')

                    ->label('Channel')

                    ->required()

                    ->maxLength(50),



                /*
                |--------------------------------------------------------------------------
                | JENIS CCTV
                |--------------------------------------------------------------------------
                |
                | Database tetap menggunakan VARCHAR / STRING.
                |
                | Pilihan pada form:
                | - IP
                | - Analog
                |
                */

                Select::make('Jenis')

                    ->label('Jenis CCTV')

                    ->options([

                        'IP' =>
                            'IP',

                        'Analog' =>
                            'Analog',

                    ])

                    ->required(),



                /*
                |--------------------------------------------------------------------------
                | TANGGAL PASANG
                |--------------------------------------------------------------------------
                */

                DatePicker::make('TanggalPasang')

                    ->label('Tanggal Pasang')

                    ->native(false)

                    ->displayFormat('d/m/Y')

                    ->format('Y-m-d')

                    ->suffixIcon('heroicon-m-calendar-days')

                    ->nullable(),



                /*
                |--------------------------------------------------------------------------
                | TIPE
                |--------------------------------------------------------------------------
                */

                TextInput::make('Tipe')

                    ->label('Tipe CCTV')

                    ->maxLength(100)

                    ->nullable(),



                /*
                |--------------------------------------------------------------------------
                | KONDISI
                |--------------------------------------------------------------------------
                */

                TextInput::make('Kondisi')

                    ->label('Kondisi')

                    ->maxLength(100)

                    ->nullable(),



                /*
                |--------------------------------------------------------------------------
                | KETERANGAN
                |--------------------------------------------------------------------------
                */

                Textarea::make('Keterangan')

                    ->label('Keterangan')

                    ->rows(5)

                    ->columnSpanFull()

                    ->nullable(),


            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('Channel')

            ->defaultSort(
                'IDAssignment',
                'desc'
            )


            /*
            |--------------------------------------------------------------------------
            | EAGER LOAD
            |--------------------------------------------------------------------------
            */

            ->modifyQueryUsing(
                function ($query) {

                    $query->with([
                        'asset',
                    ]);

                }
            )


            ->columns([


                /*
                |--------------------------------------------------------------------------
                | CHANNEL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Channel')

                    ->label('CHANNEL')

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
                | Diambil dari:
                |
                | trxcctvassignment
                |       ↓
                | NoAssetIT
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
                | JENIS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Jenis')

                    ->label('JENIS CCTV')

                    ->badge()

                    ->color(
                        fn (?string $state): string =>
                            match ($state) {

                                'IP' =>
                                    'success',

                                'Analog' =>
                                    'warning',

                                default =>
                                    'gray',

                            }
                    )

                    ->sortable(),



                /*
                |--------------------------------------------------------------------------
                | TANGGAL PASANG
                |--------------------------------------------------------------------------
                */

                TextColumn::make('TanggalPasang')

                    ->label('TANGGAL PASANG')

                    ->date('d/m/Y')

                    ->placeholder('-')
                    

                    ->sortable(),



                /*
                |--------------------------------------------------------------------------
                | TIPE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Tipe')

                    ->label('TIPE')

                    ->placeholder('-')

                    ->searchable()

                    ->sortable()

                    ->wrap(),



                /*
                |--------------------------------------------------------------------------
                | KONDISI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('Kondisi')

                    ->label('KONDISI')

                    ->placeholder('-')

                    ->badge()

                    ->color(
                        fn (?string $state): string =>
                            match ($state) {

                                'Baik' =>
                                    'success',

                                'Rusak' =>
                                    'danger',

                                'Perlu Maintenance' =>
                                    'warning',

                                default =>
                                    'gray',

                            }
                    )

                    ->searchable()

                    ->sortable(),



                /*
                |--------------------------------------------------------------------------
                | KETERANGAN
                |--------------------------------------------------------------------------
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


            /*
            |--------------------------------------------------------------------------
            | CREATE
            |--------------------------------------------------------------------------
            */

            ->headerActions([

                CreateAction::make(),

            ])


            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                EditAction::make(),

                DeleteAction::make(),

            ])


            /*
            |--------------------------------------------------------------------------
            | BULK ACTIONS
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ]);

    }
}
