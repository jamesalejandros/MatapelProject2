<?php

namespace App\Filament\Resources\MstAssets\RelationManagers;

use App\Models\MstKaryawan;
use App\Models\MstRuangan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Radio;
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
     * Hanya tampil untuk Asset dengan JenisAsset = PABX
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

                TextInput::make('NoExt')
                    ->label('No. Extension')
                    ->required()
                    ->maxLength(50),


                Radio::make('TargetAssignment')
                    ->label('Assign To')
                    ->options([
                        'karyawan' => 'Karyawan',
                        'ruangan' => 'Ruangan',
                    ])
                    ->default('karyawan')
                    ->live()
                    ->required(),


                Select::make('NIK')
                    ->label('Karyawan')
                    ->options(
                        MstKaryawan::query()
                            ->orderBy('Nama')
                            ->get()
                            ->mapWithKeys(fn ($karyawan) => [
                                $karyawan->NIK =>
                                    "{$karyawan->Nama} | {$karyawan->NIK}"
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->required(
                        fn ($get) =>
                            $get('TargetAssignment') === 'karyawan'
                    )
                    ->visible(
                        fn ($get) =>
                            $get('TargetAssignment') === 'karyawan'
                    )
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {

                        if ($state) {
                            $set('IDRuangan', null);
                        }

                    }),


                Select::make('IDRuangan')
                    ->label('Ruangan')
                    ->options(
                        MstRuangan::query()
                            ->with('lokasi')
                            ->orderBy('NamaRuangan')
                            ->get()
                            ->mapWithKeys(fn ($ruangan) => [
                                $ruangan->IDRuangan =>
                                    "{$ruangan->NamaRuangan} | " .
                                    ($ruangan->lokasi?->NamaLokasi ?? '-')
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->required(
                        fn ($get) =>
                            $get('TargetAssignment') === 'ruangan'
                    )
                    ->visible(
                        fn ($get) =>
                            $get('TargetAssignment') === 'ruangan'
                    )
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {

                        if ($state) {
                            $set('NIK', null);
                        }

                    }),


                TextInput::make('Lantai')
                    ->label('Lantai')
                    ->maxLength(50)
                    ->nullable(),


                Select::make('Jenis')
                    ->label('Jenis PABX')
                    ->options([
                        'Digital' => 'Digital',
                        'Analog' => 'Analog',
                        'IP' => 'IP',
                    ])
                    ->required(),

            ]);
    }


    public function table(Table $table): Table
{
    return $table

        ->recordTitleAttribute('NoExt')

        ->modifyQueryUsing(function ($query) {

            $query->with([

                'karyawan.departemen',

                'karyawan.lokasi',

                'ruangan.lokasi',

            ]);

        })

        ->columns([

            TextColumn::make('NoExt')
                ->label('NO. EXT')
                ->searchable()
                ->sortable(),


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

            TextColumn::make('karyawan.departemen.NamaDept')
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
            |
            | Jika assignment ke Karyawan:
            | Karyawan → Lokasi
            |
            | Jika assignment ke Ruangan:
            | Ruangan → Lokasi
            |
            */

            TextColumn::make('Lokasi')

                ->label('LOKASI')

                ->state(function ($record) {

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

                })

                ->badge()

                ->color(
                    fn ($state) =>
                        $state !== '-'
                            ? 'info'
                            : 'gray'
                )

                ->sortable(false)

                ->searchable(
                    query: function ($query, string $search) {

                        $query->where(function ($query) use ($search) {

                            /*
                            |--------------------------------------------------------------------------
                            | Cari lokasi dari Karyawan
                            |--------------------------------------------------------------------------
                            */

                            $query->whereHas(
                                'karyawan.lokasi',
                                function ($query) use ($search) {

                                    $query->where(
                                        'NamaLokasi',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            )


                            /*
                            |--------------------------------------------------------------------------
                            | ATAU cari lokasi dari Ruangan
                            |--------------------------------------------------------------------------
                            */

                            ->orWhereHas(
                                'ruangan.lokasi',
                                function ($query) use ($search) {

                                    $query->where(
                                        'NamaLokasi',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                        });

                    }
                ),


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

                            'Digital' => 'info',

                            'Analog' => 'warning',

                            'IP' => 'success',

                            default => 'gray',

                        }
                )
                ->sortable(),

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
