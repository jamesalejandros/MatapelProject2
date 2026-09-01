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

            ->columns([

                TextColumn::make('NoExt')
                    ->label('NO. EXT')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('karyawan.Nama')
                    ->label('KARYAWAN')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('ruangan.NamaRuangan')
                    ->label('RUANGAN')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('Lantai')
                    ->label('LANTAI')
                    ->placeholder('-'),


                TextColumn::make('Jenis')
                    ->label('JENIS')
                    ->badge()
                    ->color(fn ($state) => match ($state) {

                        'Digital' => 'info',

                        'Analog' => 'warning',

                        'IP' => 'success',

                        default => 'gray',

                    }),

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
