<?php

namespace App\Filament\Widgets;

use App\Models\MstLokasi;
use App\Models\TrxPabxAssignment;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class PabxLocationChart extends ChartWidget
{
    protected ?string $heading = 'PABX Berdasarkan Jenis';

    /**
     * ==========================================================
     * FILTER BERDASARKAN LOKASI
     * ==========================================================
     *
     * all = semua lokasi
     */
    public ?string $filter = 'all';

    /**
     * ==========================================================
     * FILTER LOKASI
     * ==========================================================
     *
     * Lokasi diambil langsung dari mstlokasi.
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
     * FILTER:
     *     Lokasi
     *
     * YANG DITAMPILKAN:
     *     Jenis PABX
     *
     * Contoh:
     *
     * Filter Lokasi = Gedung A
     *
     * Chart:
     *
     * Panasonic = 10
     * Avaya     = 5
     * Cisco     = 2
     *
     * Sumber utama:
     *     trxpabxassignment
     *
     * Lokasi:
     *     trxpabxassignment
     *          -> asset
     *          -> IDLokasi
     */
    protected function getData(): array
    {
        /**
         * ==========================================================
         * QUERY ASSIGNMENT PABX
         * ==========================================================
         */
        $query = TrxPabxAssignment::query()

            /**
             * Hanya assignment yang memiliki asset.
             */
            ->whereHas(
                'asset',
                function ($query) {

                    /**
                     * ==================================================
                     * FILTER LOKASI
                     * ==================================================
                     */
                    if (
                        $this->filter !== null &&
                        $this->filter !== 'all'
                    ) {

                        $query->where(
                            'IDLokasi',
                            $this->filter
                        );
                    }
                }
            )

            /**
             * Jenis harus tersedia.
             */
            ->whereNotNull('Jenis')

            ->where(
                'Jenis',
                '!=',
                ''
            );

        /**
         * ==========================================================
         * HITUNG JUMLAH PABX PER JENIS
         * ==========================================================
         *
         * Setiap baris assignment dihitung sebagai satu PABX.
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
                fn ($jenis) =>
                    (string) $jenis
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
                fn ($total) =>
                    (int) $total
            )
            ->toArray();

        /**
         * ==========================================================
         * WARNA CHART
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
         * RETURN DATA
         * ==========================================================
         */
        return [

            /**
             * Custom property untuk JavaScript.
             *
             * Karena chart sekarang berdasarkan JENIS,
             * property ini menyimpan jenis yang sesuai
             * dengan index label/data.
             */
            'jenisValues' => $labels,

            /**
             * ID lokasi yang sedang difilter.
             */
            'locationId' =>
                $this->filter !== 'all'
                    ? $this->filter
                    : null,

            /**
             * Nama lokasi yang sedang difilter.
             */
            'locationName' =>
                $this->getSelectedLocationName(),

            'datasets' => [

                [

                    'label' =>
                        $this->filter === 'all'
                            ? 'Jumlah PABX'
                            : 'Jumlah PABX - ' .
                              $this->getSelectedLocationName(),

                    'data' =>
                        $data,

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

    /**
     * ==========================================================
     * NAMA LOKASI TERPILIH
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
     * CHART TYPE
     * ==========================================================
     */
    protected function getType(): string
    {
        return 'pie';
    }

    /**
     * ==========================================================
     * CHART OPTIONS
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

        /**
         * Jenis PABX yang diklik.
         */
        const jenis =
            chart.data.jenisValues[index];

        /**
         * Lokasi yang sedang dipilih
         * melalui filter chart.
         */
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

        /**
         * Buka modal:
         *
         * lokasi = filter lokasi
         * jenis   = potongan chart yang diklik
         */
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
