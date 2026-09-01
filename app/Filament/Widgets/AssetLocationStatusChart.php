<?php

namespace App\Filament\Widgets;

use App\Models\MstAsset;
use App\Models\MstLokasi;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AssetLocationStatusChart extends ChartWidget
{
    protected ?string $heading = 'Asset Berdasarkan Lokasi';

    // protected static ?int $sort = 3;

    /**
     * Filter STATUS
     */
    public ?string $filter = 'all';

    /**
     * Daftar filter status
     */
    protected function getFilters(): ?array
    {
        return [
            'all' => 'Semua Status',
            'Available' => 'Available',
            'In Service' => 'In Service',
            'Not Used' => 'Not Used',
            'Retired' => 'Retired',
        ];
    }

    /**
     * Data Chart
     *
     * Label  : Lokasi
     * Data   : Jumlah Asset
     * Filter : Status
     *
     * Urutan :
     * Jumlah asset terbesar → terkecil
     */
    protected function getData(): array
    {
        /**
         * ==========================================================
         * QUERY ASSET
         * ==========================================================
         *
         * Hitung jumlah asset berdasarkan lokasi.
         */
        $query = MstAsset::query();

        /**
         * FILTER STATUS
         */
        if (
            $this->filter !== null &&
            $this->filter !== 'all'
        ) {
            $query->where(
                'StatusAsset',
                $this->filter
            );
        }

        /**
         * ==========================================================
         * HITUNG ASSET PER LOKASI
         * ==========================================================
         */
        $result = $query
            ->selectRaw(
                'IDLokasi, COUNT(*) as total'
            )
            ->groupBy('IDLokasi')
            ->pluck(
                'total',
                'IDLokasi'
            );

        /**
         * ==========================================================
         * AMBIL SEMUA LOKASI
         * ==========================================================
         *
         * Tetap mengambil semua lokasi agar lokasi dengan
         * 0 asset tetap muncul di chart.
         */
        $locations = MstLokasi::query()
            ->get([
                'IDLokasi',
                'NamaLokasi',
            ]);

        /**
         * ==========================================================
         * GABUNGKAN LOKASI + JUMLAH ASSET
         * ==========================================================
         *
         * Setiap lokasi diberi nilai total asset.
         */
        $locations = $locations
            ->map(function ($location) use ($result) {

                $location->totalAsset = (int) (
                    $result[$location->IDLokasi] ?? 0
                );

                return $location;
            })

            /**
             * ======================================================
             * SORTING BERDASARKAN JUMLAH ASSET
             * ======================================================
             *
             * Terbesar → terkecil.
             *
             * Jika jumlah sama, baru diurutkan berdasarkan
             * nama lokasi agar hasil tetap konsisten.
             */
            ->sort(function ($a, $b) {

                if (
                    $a->totalAsset ===
                    $b->totalAsset
                ) {
                    return strcasecmp(
                        $a->NamaLokasi ?? '',
                        $b->NamaLokasi ?? ''
                    );
                }

                return $b->totalAsset
                    <=> $a->totalAsset;
            })
            ->values();

        /**
         * ==========================================================
         * LOCATION IDS
         * ==========================================================
         */
        $locationIds = $locations
            ->pluck('IDLokasi')
            ->toArray();

        /**
         * ==========================================================
         * LABELS
         * ==========================================================
         */
        $labels = $locations
            ->map(
                fn ($location) =>
                    $location->NamaLokasi ?? '-'
            )
            ->toArray();

        /**
         * ==========================================================
         * DATA
         * ==========================================================
         */
        $data = $locations
            ->pluck('totalAsset')
            ->map(
                fn ($total) =>
                    (int) $total
            )
            ->toArray();

        /**
         * ==========================================================
         * WARNA BAR
         * ==========================================================
         */
        $colors = [
            '#3B82F6',
            '#10B981',
            '#F59E0B',
            '#EF4444',
            '#8B5CF6',
            '#06B6D4',
            '#EC4899',
            '#84CC16',
            '#F97316',
            '#6366F1',
            '#14B8A6',
            '#EAB308',
            '#A855F7',
            '#0EA5E9',
            '#22C55E',
        ];

        $backgroundColors = collect($data)
            ->map(
                fn ($value, $index) =>
                    $colors[
                        $index % count($colors)
                    ]
            )
            ->toArray();

        /**
         * ==========================================================
         * RETURN DATA
         * ==========================================================
         */
        return [

            /**
             * Custom property untuk JavaScript.
             *
             * Index-nya tetap mengikuti labels dan data
             * sehingga ketika chart diklik, ID lokasi tetap benar.
             */
            'locationIds' => $locationIds,

            'datasets' => [

                [

                    'label' => $this->filter === 'all'
                        ? 'Jumlah Asset'
                        : 'Jumlah Asset - ' . $this->filter,

                    'data' => $data,

                    'backgroundColor' =>
                        $backgroundColors,

                    'borderColor' =>
                        '#FFFFFF',

                    'borderWidth' =>
                        2,

                    'borderRadius' =>
                        6,

                    'hoverOffset' =>
                        8,

                ],

            ],

            'labels' =>
                $labels,

        ];
    }


    protected function getType(): string
    {
        return 'pie';
    }


    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'

{
    responsive: true,

    maintainAspectRatio: false,

    plugins: {

        legend: {
            display: true,

            position: 'right',
        },

        tooltip: {

            callbacks: {

                label: function(context) {

                    const label =
                        context.label || '';

                    const value =
                        context.raw || 0;

                    return label +
                        ': ' +
                        value +
                        ' Asset';
                }

            }

        }

    },


    onClick(event, elements, chart)
    {
        if (!elements.length) {
            return;
        }

        const index =
            elements[0].index;

        const locationId =
            chart.data.locationIds[index];

        const locationName =
            chart.data.labels[index];

        if (!locationId) {
            return;
        }

        console.log(
            'LOCATION CLICK:',
            locationId,
            locationName
        );

        Livewire.dispatch(
            'open-location-status-detail-modal',
            {
                location: locationId,
                status: $wire.filter,
            }
        );
    }
}

JS);
    }
}
