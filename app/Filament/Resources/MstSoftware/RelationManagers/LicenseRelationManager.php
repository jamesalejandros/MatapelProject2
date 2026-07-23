<?php

namespace App\Filament\Resources\MstSoftware\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LicenseRelationManager extends RelationManager
{
    protected static string $relationship = 'license';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('IDLicense')
                    ->label('ID License')
                    ->placeholder('Contoh: MSOFT050406')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),


                Select::make('IDPerusahaan')
                    ->label('Perusahaan')
                    ->relationship('perusahaan', 'NamaPerusahaan')
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('ProductKey')
                    ->label('Product Key')
                    ->columnSpanFull(),

                Select::make('TipeLisensi')
                    ->options([
                        'OEM' => 'OEM',
                        'Retail' => 'Retail',
                        'OLP' => 'OLP',
                        'Volume' => 'Volume',
                        'Subscription' => 'Subscription',
                    ]),

                TextInput::make('JumlahLisensi')
                    ->numeric()
                    ->default(1)
                    ->required(),

                Toggle::make('HasDVD')
                    ->label('DVD Installer'),

                TextInput::make('Barcode'),

                TextInput::make('LokasiSimpan'),

                TextInput::make('TempatSimpan'),

                Select::make('StatusLisensi')
                    ->options([
                        'Active' => 'Active',
                        'Expired' => 'Expired',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active')
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ProductKey')

            ->columns([

                TextColumn::make('IDLicense')
                    ->label('ID LICENSE')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('perusahaan.NamaPerusahaan')
                    ->label('PERUSAHAAN')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ProductKey')
                    ->label('PRODUCT KEY')
                    ->copyable()
                    ->copyMessage('Product Key berhasil disalin')
                    ->searchable()
                    ->limit(35)
                    ->tooltip(fn($record) => $record->ProductKey)
                    ->wrap(),

                BadgeColumn::make('TipeLisensi')
                    ->label('TIPE')
                    ->colors([
                        'primary' => 'OEM',
                        'success' => 'Retail',
                        'warning' => 'OLP',
                        'danger' => 'Volume',
                        'gray' => 'Subscription',
                    ]),

                TextColumn::make('JumlahLisensi')
                    ->label('JUMLAH')
                    ->badge()
                    ->alignCenter()
                    ->sortable(),

                IconColumn::make('HasDVD')
                    ->label('DVD')
                    ->boolean(),

                TextColumn::make('Barcode')
                    ->label('BARCODE')
                    ->placeholder('-')
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('LokasiSimpan')
                    ->label('LOKASI')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('TempatSimpan')
                    ->label('TEMPAT')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('StatusLisensi')
                    ->label('STATUS')
                    ->colors([
                        'success' => 'Active',
                        'warning' => 'Expired',
                        'danger' => 'Inactive',
                    ]),

            ])

            ->filters([

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