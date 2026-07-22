<?php

namespace App\Filament\Resources\MstAssets\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class MutasiAssetRelationManager extends RelationManager
{

    protected static string $relationship = 'mutasiAsset';



    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([


                Select::make('NIK')
                    ->label('Karyawan')
                    ->relationship(
                        'karyawan',
                        'Nama'
                    )
                    ->searchable()
                    ->preload()
                    ->required(),



                Select::make('IDLokasi')
                    ->label('Lokasi')
                    ->relationship(
                        'lokasi',
                        'NamaLokasi'
                    )
                    ->searchable()
                    ->preload(),



                TextInput::make('NoTransferSAP')
                    ->label('No Transfer SAP'),



                DateTimePicker::make('TanggalMutasi')
                    ->default(now())
                    ->required(),



                TextInput::make('AksesWebsite'),


                TextInput::make('AksesEmail'),


                TextInput::make('Keterangan'),

            ]);
    }





    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('NIK')

            ->columns([


                TextColumn::make('NIK')
                    ->label('NIK')
                    ->searchable(),



                TextColumn::make('karyawan.Nama')
                    ->label('Karyawan')
                    ->searchable(),



                TextColumn::make('karyawan.departemen.NamaDept')
                    ->label('Departemen'),



                TextColumn::make('lokasi.NamaLokasi')
                    ->label('Lokasi'),



                TextColumn::make('TanggalMutasi')
                    ->dateTime(),



            ])



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