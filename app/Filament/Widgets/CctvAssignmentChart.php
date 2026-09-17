<?php

namespace App\Filament\Widgets;

use App\Models\MstLokasi;
use App\Models\TrxCctvAssignment;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class CctvAssignmentChart extends ChartWidget
{
    protected ?string $heading = 'CCTV Berdasarkan Jenis';

    /**
     * ==========================================================
     * FILTER BERDASARKAN LOKASI
     * ==========================================================
     *
     * Filter:
     *
     *     Lokasi
     *
     * Isi chart:
     *
     *     Jenis CCTV
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

            ->whereNotNull(
                'NamaLokasi'
            )

            ->where(
                'NamaLokasi',
                '!=',
                ''
            )

            ->orderBy(
                'NamaLokasi'
            )

            ->get([
                'IDLokasi',
                'NamaLokasi',
            ]);


        foreach ($locations as $location) {

            $filters[
                (string) $location->IDLokasi
            ] = (string) $location->NamaLokasi;

        }


        return $filters;
    }


    /**
     * ==========================================================
     * DATA CHART
     * ==========================================================
     *
     * FILTER:
     *
     *     Lokasi CCTV
     *
     * YANG DITAMPILKAN:
     *
     *     Jenis CCTV
     *
     * Relasi lokasi:
     *
     *     trxcctvassignment
     *          ->
     *     asset
     *          ->
     *     IDLokasi
     */
    protected function getData(): array
    {
        /**
         * ======================================================
         * QUERY ASSIGNMENT CCTV
         * ======================================================
         */
        $query = TrxCctvAssignment::query()

            /**
             * ==================================================
             * FILTER BERDASARKAN LOKASI
             * ==================================================
             */
            ->whereHas(
                'asset',
                function ($assetQuery) {

                    if (
                        $this->filter !== null &&
                        $this->filter !== '' &&
                        $this->filter !== 'all'
                    ) {

                        $assetQuery->where(
                            'IDLokasi',
                            $this->filter
                        );

                    }

                }
            )

            /**
             * ==================================================
             * JENIS CCTV WAJIB TERSEDIA
             * ==================================================
             */
            ->whereNotNull(
                'Jenis'
            )

            ->where(
                'Jenis',
                '!=',
                ''
            );


        /**
         * ======================================================
         * HITUNG JUMLAH CCTV PER JENIS
         * ======================================================
         */
        $result = $query

            ->selectRaw(
                'Jenis, COUNT(*) as total'
            )

            ->groupBy(
                'Jenis'
            )

            ->orderByDesc(
                'total'
            )

            ->pluck(
                'total',
                'Jenis'
            );


        /**
         * ======================================================
         * LABEL
         * ======================================================
         *
         * Label chart = Jenis CCTV.
         */
        $labels = $result

            ->keys()

            ->map(
                fn ($jenis) =>
                    (string) $jenis
            )

            ->toArray();


        /**
         * ======================================================
         * DATA
         * ======================================================
         */
        $data = $result

            ->values()

            ->map(
                fn ($total) =>
                    (int) $total
            )

            ->toArray();


        /**
         * ======================================================
         * WARNA CHART
         * ======================================================
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
         * ======================================================
         * RETURN DATA
         * ======================================================
         */
        return [

            /**
             * ==================================================
             * JENIS VALUES
             * ==================================================
             *
             * Digunakan JavaScript ketika
             * pie chart diklik.
             */
            'jenisValues' =>
                $labels,


            /**
             * ==================================================
             * ID LOKASI YANG SEDANG DIFILTER
             * ==================================================
             */
            'locationId' =>
                (
                    $this->filter !== null &&
                    $this->filter !== '' &&
                    $this->filter !== 'all'
                )
                    ? (string) $this->filter
                    : null,


            /**
             * ==================================================
             * NAMA LOKASI YANG SEDANG DIFILTER
             * ==================================================
             */
            'locationName' =>
                $this->getSelectedLocationName(),


            'datasets' => [

                [

                    'label' =>
                        $this->filter === 'all'

                            ? 'Jumlah CCTV'

                            : 'Jumlah CCTV - ' .
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
            $this->filter === '' ||
            $this->filter === 'all'
        ) {

            return 'Semua Lokasi';
        }


        return MstLokasi::query()

            ->where(
                'IDLokasi',
                $this->filter
            )

            ->value(
                'NamaLokasi'
            )

            ?? '-';
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
                        ' CCTV';

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
         * ======================================================
         * JENIS CCTV YANG DIKLIK
         * ======================================================
         */
        const jenis =
            chart.data.jenisValues[index];


        /**
         * ======================================================
         * LOKASI DARI FILTER
         * ======================================================
         */
        const location =
            chart.data.locationId;


        const locationName =
            chart.data.locationName;


        if (!jenis) {

            return;

        }


        console.log(
            'CCTV JENIS CLICK:',
            jenis,
            'LOCATION:',
            location,
            locationName
        );


        /**
         * ======================================================
         * BUKA MODAL DETAIL
         * ======================================================
         *
         * location = lokasi dari Filter Lokasi
         * jenis    = jenis CCTV dari pie chart
         */
        Livewire.dispatch(
            'open-cctv-assignment-detail-modal',
            {
                location: location,
                locationName: locationName,
                jenis: jenis,
            }
        );

    }

}

JS);
    }
}
