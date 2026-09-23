<?php

namespace App\Filament\Resources\MstIsp\RelationManagers;

use Carbon\Carbon;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

use Filament\Tables\Table;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

use Filament\Resources\RelationManagers\RelationManager;

use Illuminate\Database\Eloquent\Builder;


class DowntimeRelationManager extends RelationManager
{
    protected static string $relationship =
        'downtimes';

    protected static ?string $title =
        'Downtime';

    protected static string|\BackedEnum|null $icon =
        'heroicon-o-exclamation-triangle';


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('NoTiket')
                    ->label('No. Tiket')
                    ->maxLength(100)
                    ->placeholder('Contoh: INC-2026-001')
                    ->helperText(
                        'Nomor tiket gangguan jika tersedia.'
                    )
                    ->nullable(),

                DateTimePicker::make('TanggalMulai')
                    ->label('Tanggal & Waktu Mulai')
                    ->required()
                    ->displayFormat('d M Y H:i')
                    ->format('Y-m-d H:i')
                    ->live()
                    ->afterStateUpdated(function (
                        Get $get,
                        callable $set
                    ) {
                        self::calculateTotalJam(
                            $get,
                            $set
                        );
                    }),

                DateTimePicker::make('TanggalSelesai')
                    ->label('Tanggal & Waktu Selesai')
                    ->nullable()
                    ->displayFormat('d M Y H:i')
                    ->format('Y-m-d H:i')
                    ->after('TanggalMulai')
                    ->live()
                    ->helperText(
                        'Kosongkan jika downtime masih berlangsung.'
                    )
                    ->afterStateUpdated(function (
                        Get $get,
                        callable $set
                    ) {
                        self::calculateTotalJam(
                            $get,
                            $set
                        );
                    }),

                TextInput::make('TotalJam')
                    ->label('Total Downtime')
                    ->numeric()
                    ->suffix('jam')
                    ->disabled()
                    ->dehydrated()
                    ->placeholder('Otomatis dihitung')
                    ->helperText(
                        'Otomatis dihitung dari waktu mulai dan selesai.'
                    ),

                Textarea::make('LokasiPutus')
                    ->label('Lokasi Putus')
                    ->rows(2)
                    ->placeholder(
                        'Contoh: Link FO menuju Plant 2'
                    )
                    ->columnSpanFull(),

                Textarea::make('Penyebab')
                    ->label('Penyebab')
                    ->rows(3)
                    ->placeholder(
                        'Jelaskan penyebab gangguan.'
                    )
                    ->columnSpanFull(),

                Textarea::make('Dampak')
                    ->label('Dampak')
                    ->rows(3)
                    ->placeholder(
                        'Jelaskan dampak yang terjadi akibat downtime.'
                    )
                    ->columnSpanFull(),

                Textarea::make('Keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->placeholder(
                        'Keterangan tambahan.'
                    )
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }


    /**
     * Menghitung total downtime dalam jam.
     */
    protected static function calculateTotalJam(
        Get $get,
        callable $set
    ): void {
        $tanggalMulai = $get('TanggalMulai');
        $tanggalSelesai = $get('TanggalSelesai');

        if (
            blank($tanggalMulai) ||
            blank($tanggalSelesai)
        ) {
            $set('TotalJam', null);

            return;
        }

        try {
            $mulai = Carbon::parse($tanggalMulai);
            $selesai = Carbon::parse($tanggalSelesai);

            if ($selesai->lessThan($mulai)) {
                $set('TotalJam', null);

                return;
            }

            $totalMenit = $mulai->diffInMinutes(
                $selesai
            );

            $totalJam = round(
                $totalMenit / 60,
                2
            );

            $set(
                'TotalJam',
                number_format(
                    $totalJam,
                    2,
                    '.',
                    ''
                )
            );
        } catch (\Throwable $e) {
            $set('TotalJam', null);
        }
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('NoTiket')

            ->columns([

                TextColumn::make('NoTiket')
                    ->label('No. Tiket')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('TanggalMulai')
                    ->label('Mulai')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('TanggalSelesai')
                    ->label('Selesai')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Masih berlangsung'),

                TextColumn::make('TotalJam')
                    ->label('Total')
                    ->numeric(
                        decimalPlaces: 2
                    )
                    ->suffix(' jam')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('LokasiPutus')
                    ->label('Lokasi Putus')
                    ->limit(40)
                    ->tooltip(
                        fn ($record) =>
                            $record->LokasiPutus
                    )
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('Penyebab')
                    ->label('Penyebab')
                    ->limit(50)
                    ->tooltip(
                        fn ($record) =>
                            $record->Penyebab
                    )
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('Dampak')
                    ->label('Dampak')
                    ->limit(50)
                    ->tooltip(
                        fn ($record) =>
                            $record->Dampak
                    )
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('StatusDowntime')
                    ->label('Status')
                    ->state(
                        fn ($record) =>
                            $record->TanggalSelesai
                                ? 'Selesai'
                                : 'Berlangsung'
                    )
                    ->badge()
                    ->color(
                        fn ($state) =>
                            $state === 'Selesai'
                                ? 'success'
                                : 'danger'
                    ),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),
            ])

            ->filters([

                Filter::make('sedang_berlangsung')
                    ->label('Sedang Berlangsung')
                    ->query(
                        fn (Builder $query) =>
                            $query->whereNull(
                                'TanggalSelesai'
                            )
                    ),

                Filter::make('sudah_selesai')
                    ->label('Sudah Selesai')
                    ->query(
                        fn (Builder $query) =>
                            $query->whereNotNull(
                                'TanggalSelesai'
                            )
                    ),

                Filter::make('periode')
                    ->label('Periode')
                    ->form([

                        DateTimePicker::make('mulai')
                            ->label('Mulai')
                            ->displayFormat('d M Y H:i')
                            ->format('Y-m-d H:i'),

                        DateTimePicker::make('selesai')
                            ->label('Selesai')
                            ->displayFormat('d M Y H:i')
                            ->format('Y-m-d H:i'),

                    ])
                    ->query(
                        function (
                            Builder $query,
                            array $data
                        ): Builder {

                            return $query

                                ->when(
                                    $data['mulai'] ?? null,
                                    fn (
                                        Builder $query,
                                        $date
                                    ) =>
                                        $query->where(
                                            'TanggalMulai',
                                            '>=',
                                            $date
                                        )
                                )

                                ->when(
                                    $data['selesai'] ?? null,
                                    fn (
                                        Builder $query,
                                        $date
                                    ) =>
                                        $query->where(
                                            'TanggalMulai',
                                            '<=',
                                            $date
                                        )
                                );
                        }
                    ),
            ])

            ->headerActions([

                CreateAction::make()
                    ->label('Tambah Downtime')
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
                'TanggalMulai',
                'desc'
            );
    }
}
