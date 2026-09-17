<?php

namespace App\Filament\Widgets;

use App\Models\MstLokasi;
use App\Models\TrxPabxAssignment;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class PabxLocationChart extends ChartWidget
{
    protected ?string $heading = 'PABX Berdasarkan Jenis';

    public ?string $filter = 'all';

    /**
     * ==========================================================
     * FILTER LOKASI
     * ==========================================================
     */
    protected function getFilters(): ?array
    {
        $filters = [
            'all' => 'Semua Lokasi',
        ];

        $locations = MstLokasi::query()
            ->whereNotNull('NamaLokasi')
            ->where('NamaLokasi', '!=', '')
            ->orderBy('NamaLokasi')
            ->get([
                'IDLokasi',
                'NamaLokasi',
            ]);

        foreach ($locations as $location) {
            $filters[
                (string) $location->IDLokasi
            ] = $location->NamaLokasi;
        }

        return $filters;
    }

    /**
     * ==========================================================
     * DATA CHART
     * ==========================================================
     *
     * Sumber PABX:
     *     trxpabxassignment
     *
     * Jenis:
     *     trxpabxassignment.Jenis
     *
     * Lokasi:
     *     mstasset.IDLokasi
     *
     * Karyawan:
     *     TIDAK digunakan pada chart.
     */
    protected function getData(): array
    {
        $query = TrxPabxAssignment::query()

            /**
             * ==================================================
             * FILTER LOKASI
             * ==================================================
             *
             * Lokasi asset tetap berasal dari mstasset.
             */
            ->when(
                $this->filter !== null &&
                $this->filter !== 'all',

                function ($query) {
                    $query->whereHas(
                        'asset',
                        function ($assetQuery) {
                            $assetQuery->where(
                                'IDLokasi',
                                $this->filter
                            );
                        }
                    );
                }
            )

            /**
             * ==================================================
             * JENIS PABX
             * ==================================================
             */
            ->whereNotNull('Jenis')
            ->where('Jenis', '!=', '');

        /**
         * ==========================================================
         * HITUNG JUMLAH PABX PER JENIS
         * ==========================================================
         */
        $result = $query
            ->selectRaw(
                'Jenis, COUNT(*) as total'
            )
            ->groupBy('Jenis')
            ->orderByDesc('total')
            ->pluck(
                'total',
                'Jenis'
            );

        /**
         * ==========================================================
         * LABEL
         * ==========================================================
         */
        $labels = $result
            ->keys()
            ->map(
                fn ($jenis) => (string) $jenis
            )
            ->toArray();

        /**
         * ==========================================================
         * DATA
         * ==========================================================
         */
        $data = $result
            ->values()
            ->map(
                fn ($total) => (int) $total
            )
            ->toArray();

        /**
         * ==========================================================
         * WARNA
         * ==========================================================
         */
        $colors = [
            '#7C3AED',
            '#2563EB',
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
            '#D946EF',
            '#0891B2',
            '#65A30D',
            '#EA580C',
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
         * RETURN
         * ==========================================================
         */
        return [
            'jenisValues' => $labels,

            'locationId' =>
                $this->filter !== 'all'
                    ? $this->filter
                    : null,

            'locationName' =>
                $this->getSelectedLocationName(),

            'datasets' => [
                [
                    'label' =>
                        $this->filter === 'all'
                            ? 'Jumlah PABX'
                            : 'Jumlah PABX - ' .
                              $this->getSelectedLocationName(),

                    'data' => $data,

                    'backgroundColor' =>
                        $backgroundColors,

                    'borderColor' => '#FFFFFF',

                    'borderWidth' => 2,

                    'borderRadius' => 6,

                    'hoverOffset' => 8,
                ],
            ],

            'labels' => $labels,
        ];
    }

    /**
     * ==========================================================
     * NAMA LOKASI
     * ==========================================================
     */
    protected function getSelectedLocationName(): string
    {
        if (
            $this->filter === null ||
            $this->filter === 'all'
        ) {
            return 'Semua Lokasi';
        }

        return MstLokasi::query()
            ->where(
                'IDLokasi',
                $this->filter
            )
            ->value('NamaLokasi') ?? '-';
    }

    /**
     * ==========================================================
     * TYPE
     * ==========================================================
     */
    protected function getType(): string
    {
        return 'pie';
    }

    /**
     * ==========================================================
     * OPTIONS
     * ==========================================================
     */
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
                        ' PABX';
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

        const jenis =
            chart.data.jenisValues[index];

        const location =
            chart.data.locationId;

        const locationName =
            chart.data.locationName;

        if (!jenis) {
            return;
        }

        console.log(
            'PABX JENIS CLICK:',
            jenis,
            'LOCATION:',
            location,
            locationName
        );

        Livewire.dispatch(
            'open-pabx-location-detail-modal',
            {
                location: location,
                jenis: jenis,
            }
        );
    }
}

JS);
    }
}
