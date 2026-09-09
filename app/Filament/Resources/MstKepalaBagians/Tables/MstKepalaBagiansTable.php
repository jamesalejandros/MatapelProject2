<?php

namespace App\Filament\Resources\MstKepalaBagians\Tables;

use App\Filament\Resources\MstKepalaBagians\MstKepalaBagianResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstKepalaBagiansTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |--------------------------------------------------------------------------
            | DEFAULT SORT
            |--------------------------------------------------------------------------
            */

            ->defaultSort(
                'name',
                'asc'
            )

            /*
            |--------------------------------------------------------------------------
            | COLUMNS
            |--------------------------------------------------------------------------
            */

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | NO
                |--------------------------------------------------------------------------
                */

                TextColumn::make('No')
                    ->label('NO')
                    ->rowIndex()
                    ->weight('bold'),

                /*
                |--------------------------------------------------------------------------
                | NAMA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('name')
                    ->label('NAMA KEPALA BAGIAN')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | EMAIL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('email')
                    ->label('EMAIL')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email berhasil disalin')
                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | JUMLAH USER
                |--------------------------------------------------------------------------
                */

                TextColumn::make('users_count')
                    ->label('JUMLAH USER')
                    ->counts('users')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | JUMLAH APPROVAL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('approvals_count')
                    ->label('JUMLAH APPROVAL')
                    ->counts('approvals')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | DIBUAT
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')
                    ->label('DIBUAT')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

            ])

            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                /*
                |--------------------------------------------------------------------------
                | EDIT
                |--------------------------------------------------------------------------
                */

                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            MstKepalaBagianResource::canEdit(
                                $record
                            )
                    ),

                /*
                |--------------------------------------------------------------------------
                | DELETE
                |--------------------------------------------------------------------------
                |
                | Tidak boleh menghapus Kepala Bagian yang masih
                | mempunyai user atau data approval.
                |
                */

                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            MstKepalaBagianResource::canDelete(
                                $record
                            )
                            &&
                            $record->users()->doesntExist()
                            &&
                            $record->approvals()->doesntExist()
                    )
                    ->requiresConfirmation()
                    ->modalHeading(
                        'Hapus Kepala Bagian'
                    )
                    ->modalDescription(
                        'Data Kepala Bagian yang dihapus tidak dapat dikembalikan.'
                    )
                    ->successNotificationTitle(
                        'Kepala Bagian berhasil dihapus'
                    ),

            ])

            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

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

            ->defaultPaginationPageOption(25);
    }
}
