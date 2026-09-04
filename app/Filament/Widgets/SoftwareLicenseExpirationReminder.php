<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\MstSoftwareLicenses\MstSoftwareLicenseResource;
use App\Models\MstSoftwareLicense;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

use Illuminate\Database\Eloquent\Builder;


class SoftwareLicenseExpirationReminder extends TableWidget
{

    /*
    |--------------------------------------------------------------------------
    | WIDGET CONFIGURATION
    |--------------------------------------------------------------------------
    */

    protected static ?string $heading =
        'Software License Expiration Reminder';

    protected static ?string $description =
        'License Active yang tanggal expired-nya sudah mendekati.';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {
        return $table

            /*
            |--------------------------------------------------------------------------
            | QUERY
            |--------------------------------------------------------------------------
            |
            | Hanya menampilkan:
            |
            | - StatusLisensi = Active
            | - ExpiredDate tersedia
            | - ExpiredDate >= hari ini
            | - ExpiredDate <= 30 hari dari sekarang
            |
            | IMPORTANT:
            | ExpiredDate TIDAK mengubah StatusLisensi.
            |
            */

            ->query(
                MstSoftwareLicense::query()
                    ->with([
                        'software',
                        'perusahaan',
                    ])
                    ->where('StatusLisensi', 'Active')
                    ->whereNotNull('ExpiredDate')
                    ->whereDate(
                        'ExpiredDate',
                        '>=',
                        today()
                    )
                    ->whereDate(
                        'ExpiredDate',
                        '<=',
                        today()->addDays(30)
                    )
                    ->orderBy(
                        'ExpiredDate',
                        'asc'
                    )
            )


            /*
            |--------------------------------------------------------------------------
            | COLUMNS
            |--------------------------------------------------------------------------
            */

            ->columns([


                /*
                |--------------------------------------------------------------------------
                | ID LICENSE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('IDLicense')
                    ->label('ID LICENSE')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),


                /*
                |--------------------------------------------------------------------------
                | SOFTWARE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('software.NamaSoftware')
                    ->label('SOFTWARE')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),


                /*
                |--------------------------------------------------------------------------
                | PERUSAHAAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make('perusahaan.NamaPerusahaan')
                    ->label('PERUSAHAAN')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | TIPE LICENSE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('TipeLisensi')
                    ->label('TIPE')
                    ->badge()
                    ->color('primary'),


                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                |
                | Status tetap mengikuti database.
                |
                | ExpiredDate yang lewat TIDAK mengubah Active menjadi Expired.
                |
                */

                TextColumn::make('StatusLisensi')
                    ->label('STATUS')
                    ->badge()
                    ->color(fn ($state): string => match ($state) {

                        'Active' =>
                            'success',

                        'Inactive' =>
                            'gray',

                        default =>
                            'gray',

                    }),


                /*
                |--------------------------------------------------------------------------
                | EXPIRED DATE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('ExpiredDate')
                    ->label('EXPIRED DATE')
                    ->date('d/m/Y')
                    ->sortable()
                    ->weight('bold')
                    ->color(function ($record): string {

                        if (! $record->ExpiredDate) {
                            return 'gray';
                        }

                        $days = today()->diffInDays(
                            $record->ExpiredDate,
                            false
                        );

                        return match (true) {

                            $days <= 7 =>
                                'danger',

                            $days <= 14 =>
                                'warning',

                            default =>
                                'success',

                        };

                    }),


                /*
                |--------------------------------------------------------------------------
                | SISA HARI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('remaining_days')
                    ->label('SISA HARI')
                    ->state(function ($record): string {

                        if (! $record->ExpiredDate) {
                            return '-';
                        }

                        $days = today()->diffInDays(
                            $record->ExpiredDate,
                            false
                        );

                        if ($days === 0) {
                            return 'Hari ini';
                        }

                        if ($days === 1) {
                            return '1 hari';
                        }

                        return $days . ' hari';

                    })
                    ->badge()
                    ->color(function ($record): string {

                        if (! $record->ExpiredDate) {
                            return 'gray';
                        }

                        $days = today()->diffInDays(
                            $record->ExpiredDate,
                            false
                        );

                        return match (true) {

                            $days <= 7 =>
                                'danger',

                            $days <= 14 =>
                                'warning',

                            default =>
                                'success',

                        };

                    }),

            ])


            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            |
            | Default = 30 hari.
            |
            | User dapat mengganti menjadi:
            |
            | 7 hari
            | 14 hari
            | 30 hari
            | 60 hari
            | 90 hari
            |
            */

            ->filters([

                SelectFilter::make('reminder_period')
                    ->label('REMINDER')
                    ->options([

                        '7' =>
                            '7 Hari',

                        '14' =>
                            '14 Hari',

                        '30' =>
                            '30 Hari',

                        '60' =>
                            '60 Hari',

                        '90' =>
                            '90 Hari',

                    ])
                    ->default('30')

                    ->query(function (
                        Builder $query,
                        array $data
                    ) {

                        $days = (int) (
                            $data['value'] ?? 30
                        );

                        return $query

                            ->where('StatusLisensi', 'Active')

                            ->whereNotNull('ExpiredDate')

                            ->whereDate(
                                'ExpiredDate',
                                '>=',
                                today()
                            )

                            ->whereDate(
                                'ExpiredDate',
                                '<=',
                                today()->addDays($days)
                            );

                    }),

            ])


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            ->paginated([
                5,
                10,
                25,
            ])

            ->defaultPaginationPageOption(10)


            /*
            |--------------------------------------------------------------------------
            | RECORD URL
            |--------------------------------------------------------------------------
            |
            | Klik row -> Edit License.
            |
            */

            ->recordUrl(
                fn ($record) =>
                    MstSoftwareLicenseResource::getUrl(
                        'edit',
                        [
                            'record' => $record,
                        ]
                    )
            )


            /*
            |--------------------------------------------------------------------------
            | EMPTY STATE
            |--------------------------------------------------------------------------
            */

            ->emptyStateHeading(
                'Tidak ada license yang akan expired'
            )

            ->emptyStateDescription(
                'Tidak ditemukan license Active yang akan expired dalam periode reminder.'
            )

            ->emptyStateIcon(
                'heroicon-o-check-circle'
            );

    }

}
