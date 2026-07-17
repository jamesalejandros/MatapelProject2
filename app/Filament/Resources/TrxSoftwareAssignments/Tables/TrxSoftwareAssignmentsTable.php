<?php

namespace App\Filament\Resources\TrxSoftwareAssignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrxSoftwareAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('asset.NoAssetIT')
                    ->label('Asset')
                    ->searchable(),

                TextColumn::make('license.software.NamaSoftware')
                    ->label('Software')
                    ->searchable(),

                TextColumn::make('license.TipeLisensi')
                    ->label('License'),

                TextColumn::make('TanggalAssign')
                    ->date()
                    ->sortable(),

                TextColumn::make('TanggalRevoke')
                    ->date()
                    ->sortable(),

                BadgeColumn::make('StatusAssignment')
                    ->colors([
                        'success' => 'Installed',
                        'warning' => 'Expired',
                        'danger' => 'Revoked',
                    ]),

            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}