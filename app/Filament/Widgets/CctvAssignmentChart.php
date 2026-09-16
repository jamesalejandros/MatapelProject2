<?php

namespace App\Filament\Widgets;

use App\Models\TrxCctvAssignment;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class CctvAssignmentChart extends ChartWidget
{
    protected ?string $heading = 'CCTV Berdasarkan Jenis';

    /**
     * ==========================================================
     * FILTER
     * ==========================================================
     *
     * Filter hanya berdasarkan Jenis CCTV.
     *
     * Contoh:
     *
     *     Semua Jenis
     *     IP
     *     Analog
     *
     * Default:
     *
     *     all = Semua Jenis
     */
    public ?string $filter = 'all';


    /**
     * ==========================================================
     * FILTER OPTIONS
     * ==========================================================
     *
     * Filament ChartWidget menggunakan getFilters()
     * untuk menampilkan dropdown filter di bagian atas widget.
     *
     * Data filter diambil langsung dari:
     *
     *     trxcctvassignment.Jenis
     */
    protected function getFilters(): ?array
    {
        $filters = [

            'all' =>
                'Semua Jenis',

        ];


        /**
         * ======================================================
         * AMBIL JENIS CCTV
         * ======================================================
         *
         * Hanya mengambil Jenis yang memiliki nilai.
         */
        $jenisCctv = TrxCctvAssignment::query()

            ->whereNotNull('Jenis')

            ->where(
                'Jenis',
                '!=',
                ''
            )

            ->select('Jenis')

            ->distinct()

            ->orderBy('Jenis')

            ->pluck('Jenis');


        /**
         * ======================================================
         * MASUKKAN JENIS KE FILTER
         * ======================================================
         */
        foreach ($jenisCctv as $jenis) {

            $filters[
                (string) $jenis
            ] = (string) $jenis;
        }


        return $filters;
    }


    /**
     * ==========================================================
     * DATA CHART
     * ==========================================================
     *
     * Sumber:
     *
     *     trxcctvassignment
     *
     * Yang ditampilkan:
     *
     *     Jumlah CCTV berdasarkan Jenis.
     *
     * Filter:
     *
     *     Jenis CCTV
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
             * Jenis wajib tersedia.
             */
            ->whereNotNull('Jenis')

            ->where(
                'Jenis',
                '!=',
                ''
            );


        /**
         * ======================================================
         * APPLY FILTER JENIS
         * ======================================================
         *
         * Jika:
         *
         *     all
         *
         * maka semua CCTV ditampilkan.
         *
         * Jika:
         *
         *     IP
         *
         * maka hanya CCTV dengan Jenis = IP.
         */
        if (
            $this->filter !== null &&
            $this->filter !== '' &&
            $this->filter !== 'all'
        ) {

            $query->where(
                'Jenis',
                $this->filter
            );
        }


        /**
         * ======================================================
         * HITUNG CCTV PER JENIS
         * ======================================================
         *
         * Setiap baris assignment dihitung sebagai satu CCTV.
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
         * ======================================================
         * LABEL
         * ======================================================
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

            '#2563EB',
            '#7C3AED',
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
             * Custom property untuk JavaScript.
             *
             * Jenis CCTV berdasarkan index chart.
             */
            'jenisValues' =>
                $labels,


            /**
             * Jenis CCTV yang sedang difilter.
             */
            'selectedJenis' =>
                $this->filter !== 'all'
                    ? $this->filter
                    : null,


            'datasets' => [

                [

                    'label' =>
                        $this->filter === 'all'
                            ? 'Jumlah CCTV'
                            : 'Jumlah CCTV - ' . $this->filter,

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


        if (!jenis) {

            return;

        }


        console.log(
            'CCTV JENIS CLICK:',
            jenis
        );


        /**
         * ======================================================
         * BUKA MODAL
         * ======================================================
         *
         * Hanya mengirim Jenis CCTV.
         *
         * Tidak ada:
         *
         *     location
         *     tipe
         *     kondisi
         *     tahun
         */
        Livewire.dispatch(
            'open-cctv-assignment-detail-modal',
            {
                jenis: jenis,
            }
        );

    }

}

JS);
    }
}
