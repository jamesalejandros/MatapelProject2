<?php

namespace App\Filament\Resources\MstRuangans\Tables;

use App\Filament\Resources\MstRuangans\MstRuanganResource;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Table;


class MstRuangansTable
{
    public static function configure(Table $table): Table
    {
        return $table


            ->recordUrl(
                fn ($record) =>
                    MstRuanganResource::getUrl(
                        'edit',
                        [
                            'record' => $record,
                        ]
                    )
            )



            ->defaultSort(
                'IDRuangan',
                'asc'
            )



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



            ->modifyQueryUsing(
                function ($query) {

                    $query->with([
                        'lokasi',
                    ]);

                }
            )



            ->columns([


                TextColumn::make('No')

                    ->label('NO')

                    ->rowIndex()

                    ->weight('bold'),



                TextColumn::make('IDRuangan')

                    ->label('ID RUANGAN')

                    ->searchable()

                    ->sortable(),



                TextColumn::make('NamaRuangan')

                    ->label('NAMA RUANGAN')

                    ->searchable()

                    ->sortable()

                    ->weight('bold')

                    ->wrap(),

                TextColumn::make('Lantai')

                    ->label('LANTAI')

                    ->searchable()

                    ->sortable()

                    ->wrap(),



                TextColumn::make('lokasi.NamaLokasi')

                    ->label('LOKASI')

                    ->badge()

                    ->color('info')

                    ->searchable()

                    ->sortable()

                    ->placeholder('-'),



            ])



            ->filters([

                //

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
