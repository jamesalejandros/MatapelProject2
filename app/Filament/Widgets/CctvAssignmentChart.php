<?php

namespace App\Filament\Widgets;

use App\Models\TrxCctvAssignment;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CctvAssignmentChart extends ChartWidget
{
    protected ?string $heading = 'CCTV Berdasarkan Lokasi';

    /**
     * ==========================================================
     * FILTER
     * ==========================================================
     *
     * Filter berdasarkan Lokasi CCTV.
     *
     * Relasi:
     *
     * trxcctvassignment.NoAssetIT
     *     ↓
     * mstasset.NoAssetIT
     *     ↓
     * mstasset.IDLokasi
     *     ↓
     * mstlokasi.IDLokasi
     *
     * Default:
     *
     *     all = Semua Lokasi
     */
    public ?string $filter = 'all';


    /**
     * ==========================================================
     * FILTER OPTIONS
     * ==========================================================
     *
     * Mengambil daftar lokasi dari:
     *
     *     mstlokasi
     *
     * yang memiliki CCTV pada trxcctvassignment.
     */
    protected function getFilters(): ?array
    {
        $filters = [

            'all' => 'Semua Lokasi',

        ];


        /**
         * ======================================================
         * AMBIL LOKASI CCTV
         * ======================================================
         *
         * Join:
         *
         * trxcctvassignment
         *      → mstasset
         *      → mstlokasi
         */
        $lokasiCctv = TrxCctvAssignment::query()

            ->join(
                'mstasset',
                'mstasset.NoAssetIT',
                '=',
                'trxcctvassignment.NoAssetIT'
            )

            ->join(
                'mstlokasi',
                'mstlokasi.IDLokasi',
                '=',
                'mstasset.IDLokasi'
            )

            ->whereNotNull('mstasset.IDLokasi')

            ->whereNotNull('mstlokasi.NamaLokasi')

            ->where(
                'mstlokasi.NamaLokasi',
                '!=',
                ''
            )

            ->select(
                'mstlokasi.IDLokasi',
                'mstlokasi.NamaLokasi'
            )

            ->distinct()

            ->orderBy(
                'mstlokasi.NamaLokasi'
            )

            ->get();


        /**
         * ======================================================
         * MASUKKAN LOKASI KE FILTER
         * ======================================================
         */
        foreach ($lokasiCctv as $lokasi) {

            $filters[
                (string) $lokasi->IDLokasi
            ] = (string) $lokasi->NamaLokasi;
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
     *     mstasset
     *     mstlokasi
     *
     * Yang ditampilkan:
     *
     *     Jumlah CCTV berdasarkan Lokasi.
     *
     * Filter:
     *
     *     Lokasi CCTV
     */
    protected function getData(): array
    {
        /**
         * ======================================================
         * QUERY ASSIGNMENT CCTV
         * ======================================================
         *
         * Relasi:
         *
         * trxcctvassignment.NoAssetIT
         *     =
         * mstasset.NoAssetIT
         *
         * mstasset.IDLokasi
         *     =
         * mstlokasi.IDLokasi
         */
        $query = TrxCctvAssignment::query()

            ->join(
                'mstasset',
                'mstasset.NoAssetIT',
                '=',
                'trxcctvassignment.NoAssetIT'
            )

            ->join(
                'mstlokasi',
                'mstlokasi.IDLokasi',
                '=',
                'mstasset.IDLokasi'
            )

            /**
             * Lokasi wajib tersedia.
             */
            ->whereNotNull(
                'mstasset.IDLokasi'
            )

            ->whereNotNull(
                'mstlokasi.NamaLokasi'
            )

            ->where(
                'mstlokasi.NamaLokasi',
                '!=',
                ''
            );


        /**
         * ======================================================
         * APPLY FILTER LOKASI
         * ======================================================
         *
         * Jika:
         *
         *     all
         *
         * maka semua lokasi ditampilkan.
         *
         * Jika:
         *
         *     ID lokasi tertentu
         *
         * maka hanya CCTV pada lokasi tersebut
         * yang ditampilkan.
         */
        if (
            $this->filter !== null &&
            $this->filter !== '' &&
            $this->filter !== 'all'
        ) {

            $query->where(
                'mstlokasi.IDLokasi',
                $this->filter
            );
        }


        /**
         * ======================================================
         * HITUNG CCTV PER LOKASI
         * ======================================================
         *
         * Setiap baris assignment dihitung sebagai satu CCTV.
         */
        $result = $query

            ->select(
                'mstlokasi.IDLokasi',
                'mstlokasi.NamaLokasi'
            )

            ->selectRaw(
                'COUNT(*) as total'
            )

            ->groupBy(
                'mstlokasi.IDLokasi',
                'mstlokasi.NamaLokasi'
            )

            ->orderByDesc(
                'total'
            )

            ->get();


        /**
         * ======================================================
         * LABEL
         * ======================================================
         */
        $labels = $result

            ->map(
                fn ($row) =>
                    (string) $row->NamaLokasi
            )

            ->toArray();


        /**
         * ======================================================
         * LOCATION VALUES
         * ======================================================
         *
         * ID lokasi berdasarkan index chart.
         *
         * Digunakan oleh JavaScript ketika pie chart diklik.
         */
        $locationValues = $result

            ->map(
                fn ($row) =>
                    (int) $row->IDLokasi
            )

            ->toArray();


        /**
         * ======================================================
         * DATA
         * ======================================================
         */
        $data = $result

            ->map(
                fn ($row) =>
                    (int) $row->total
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
         * NAMA LOKASI YANG SEDANG DIFILTER
         * ======================================================
         */
        $selectedLocation = null;


        if (
            $this->filter !== null &&
            $this->filter !== '' &&
            $this->filter !== 'all'
        ) {

            $selectedLocation = DB::table('mstlokasi')

                ->where(
                    'IDLokasi',
                    $this->filter
                )

                ->value(
                    'NamaLokasi'
                );
        }


        /**
         * ======================================================
         * RETURN DATA
         * ======================================================
         */
        return [

            /**
             * Custom property untuk JavaScript.
             *
             * Nama lokasi berdasarkan index chart.
             */
            'locationValues' =>
                $locationValues,


            /**
             * Nama lokasi berdasarkan index chart.
             */
            'locationNames' =>
                $labels,


            /**
             * Lokasi yang sedang difilter.
             */
            'selectedLocation' =>
                $selectedLocation,


            'datasets' => [

                [

                    'label' =>
                        $this->filter === 'all'
                            ? 'Jumlah CCTV'
                            : 'Jumlah CCTV - ' . $selectedLocation,

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
         * LOKASI YANG DIKLIK
         * ======================================================
         */
        const locationId =
            chart.data.locationValues[index];


        const locationName =
            chart.data.locationNames[index];


        if (!locationId) {

            return;

        }


        console.log(
            'CCTV LOCATION CLICK:',
            locationId,
            locationName
        );


        /**
         * ======================================================
         * BUKA MODAL
         * ======================================================
         *
         * Mengirim:
         *
         *     locationId
         *     locationName
         *
         * Tidak lagi mengirim:
         *
         *     jenis
         *     tipe
         *     kondisi
         *     tahun
         */
        Livewire.dispatch(
            'open-cctv-assignment-detail-modal',
            {
                locationId: locationId,
                locationName: locationName,
            }
        );

    }

}

JS);
    }
}
