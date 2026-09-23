<?php

namespace App\Filament\Resources\MstIsp\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

use Filament\Resources\RelationManagers\RelationManager;


class BandwidthRelationManager extends RelationManager
{
    protected static string $relationship =
        'bandwidths';

    protected static ?string $title =
        'Bandwidth';

    protected static string|\BackedEnum|null $icon =
        'heroicon-o-signal';


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                DatePicker::make('TanggalUpgrade')
                    ->label('Tanggal Upgrade')
                    ->required()
                    ->displayFormat('d M Y')
                    ->format('Y-m-d'),

                TextInput::make('BandwidthInternasional')
                    ->label('Bandwidth Internasional')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->suffix('Mbps'),

                TextInput::make('BandwidthLokal')
                    ->label('Bandwidth Lokal')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->suffix('Mbps'),

                TextInput::make('Harga')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->prefix('Rp'),

                Select::make('Status')
                    ->label('Status')
                    ->options([
                        'ACTIVE' => 'Active',
                        'INACTIVE' => 'Inactive',
                        'PENDING' => 'Pending',
                    ])
                    ->default('ACTIVE')
                    ->required()
                    ->native(false),

                Textarea::make('Keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->columnSpanFull(),

            ]);
    }


    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('TanggalUpgrade')

            ->columns([

                TextColumn::make('TanggalUpgrade')
                    ->label('Tanggal Upgrade')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('BandwidthInternasional')
                    ->label('Internasional')
                    ->suffix(' Mbps')
                    ->sortable(),

                TextColumn::make('BandwidthLokal')
                    ->label('Lokal')
                    ->suffix(' Mbps')
                    ->sortable(),

                TextColumn::make('Harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('Status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'ACTIVE' => 'success',
                        'INACTIVE' => 'gray',
                        'PENDING' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('Keterangan')
                    ->label('Keterangan')
                    ->limit(40)
                    ->tooltip(
                        fn ($record) => $record->Keterangan
                    ),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

            ])

            ->filters([

                SelectFilter::make('Status')
                    ->options([
                        'ACTIVE' => 'Active',
                        'INACTIVE' => 'Inactive',
                        'PENDING' => 'Pending',
                    ]),

            ])

            ->headerActions([

                CreateAction::make()
                    ->label('Tambah Bandwidth')
                    ->icon('heroicon-o-plus'),

            ])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort(
                'TanggalUpgrade',
                'desc'
            );
    }
}
