<?php

namespace App\Filament\Resources\TrxIspDowntimes\Schemas;

use Carbon\Carbon;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;


class TrxIspDowntimeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('IDISP')
                    ->label('ISP')
                    ->relationship(
                        name: 'isp',
                        titleAttribute: 'NamaISP'
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn ($record): string =>
                            ($record->vendor?->NamaVendor ?? '-')
                            . ' - '
                            . $record->NamaISP
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),

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
                    ->afterStateUpdated(
                        function (
                            Get $get,
                            callable $set
                        ) {
                            self::calculateTotalJam(
                                $get,
                                $set
                            );
                        }
                    ),

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
                    ->afterStateUpdated(
                        function (
                            Get $get,
                            callable $set
                        ) {
                            self::calculateTotalJam(
                                $get,
                                $set
                            );
                        }
                    ),

                TextInput::make('TotalJam')
                    ->label('Total Downtime')
                    ->numeric()
                    ->suffix('jam')
                    ->disabled()
                    ->dehydrated()
                    ->placeholder(
                        'Otomatis dihitung'
                    )
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
        $tanggalMulai =
            $get('TanggalMulai');

        $tanggalSelesai =
            $get('TanggalSelesai');


        if (
            blank($tanggalMulai) ||
            blank($tanggalSelesai)
        ) {
            $set(
                'TotalJam',
                null
            );

            return;
        }


        try {

            $mulai =
                Carbon::parse(
                    $tanggalMulai
                );

            $selesai =
                Carbon::parse(
                    $tanggalSelesai
                );


            if (
                $selesai->lessThan($mulai)
            ) {
                $set(
                    'TotalJam',
                    null
                );

                return;
            }


            $totalMenit =
                $mulai->diffInMinutes(
                    $selesai
                );


            $totalJam =
                round(
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

            $set(
                'TotalJam',
                null
            );

        }
    }
}
