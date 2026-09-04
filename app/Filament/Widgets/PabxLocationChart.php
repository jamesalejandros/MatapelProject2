<?php

namespace App\Filament\Widgets;

use App\Models\MstLokasi;
use App\Models\TrxPabxAssignment;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class PabxLocationChart extends ChartWidget
{
    protected ?string $heading = 'PABX Berdasarkan Lokasi';

    /**
     * Filter berdasarkan Jenis PABX.
     *
     * all = semua jenis
     */
    public ?string $filter = 'all';

    /**
     * ==========================================================
     * FILTER JENIS PABX
     * ==========================================================
     *
     * Mengambil seluruh Jenis yang benar-benar terdapat
     * pada tabel trxpabxassignment.
     */
    protected function getFilters(): ?array
    {
        $filters = [
            'all' => 'Semua Jenis',
        ];

        $jenisList = TrxPabxAssignment::query()
            ->whereNotNull('Jenis')
            ->where('Jenis', '!=', '')
            ->select('Jenis')
            ->distinct()
            ->orderBy('Jenis')
            ->pluck('Jenis')
            ->toArray();

        foreach ($jenisList as $jenis) {
            $filters[$jenis] = $jenis;
        }

        return $filters;
    }

    /**
     * ==========================================================
     * DATA CHART
     * ==========================================================
     *
     * Yang dihitung adalah JUMLAH ASSIGNMENT PABX.
     *
     * Sumber utama:
     *     trxpabxassignment
     *
     * Lokasi:
     *     trxpabxassignment
     *          -> asset
     *          -> IDLokasi
     *
     * Filter:
     *     trxpabxassignment.Jenis
     */
    protected function getData(): array
    {
        /**
         * ==========================================================
         * QUERY ASSIGNMENT PABX
         * ==========================================================
         *
         * Join ke mstasset hanya untuk mendapatkan lokasi asset.
         *
         * Tidak menggunakan COUNT(DISTINCT NoAssetIT),
         * karena yang ingin dihitung adalah jumlah assignment PABX.
         */
        $query = TrxPabxAssignment::query()
            ->join(
                'mstasset',
                'trxpabxassignment.NoAssetIT',
                '=',
                'mstasset.NoAssetIT'
            );

        /**
         * ==========================================================
         * FILTER JENIS
         * ==========================================================
         */
        if (
            $this->filter !== null &&
            $this->filter !== 'all'
        ) {
            $query->where(
                'trxpabxassignment.Jenis',
                $this->filter
            );
        }

        /**
         * ==========================================================
         * HITUNG JUMLAH ASSIGNMENT PER LOKASI
         * ==========================================================
         *
         * Setiap baris pada trxpabxassignment dihitung.
         *
         * Contoh:
         *
         * Asset A
         * ├── Assignment PABX 1
         * └── Assignment PABX 2
         *
         * Maka dihitung = 2.
         */
        $result = $query
            ->selectRaw(
                'mstasset.IDLokasi, COUNT(trxpabxassignment.IDAssignment) as total'
            )
            ->groupBy(
                'mstasset.IDLokasi'
            )
            ->pluck(
                'total',
                'mstasset.IDLokasi'
            );

        /**
         * ==========================================================
         * AMBIL SEMUA LOKASI
         * ==========================================================
         *
         * Lokasi yang belum mempunyai PABX tetap ditampilkan
         * dengan nilai 0.
         */
        $locations = MstLokasi::query()
            ->get([
                'IDLokasi',
                'NamaLokasi',
            ]);

        /**
         * ==========================================================
         * GABUNGKAN LOKASI + JUMLAH PABX
         * ==========================================================
         */
        $locations = $locations
            ->map(function ($location) use ($result) {

                $location->totalPabx = (int) (
                    $result[$location->IDLokasi] ?? 0
                );

                return $location;
            })

            /**
             * ======================================================
             * SORTING
             * ======================================================
             *
             * Jumlah PABX terbesar -> terkecil.
             *
             * Jika sama, urut berdasarkan nama lokasi.
             */
            ->sort(function ($a, $b) {

                if (
                    $a->totalPabx ===
                    $b->totalPabx
                ) {
                    return strcasecmp(
                        $a->NamaLokasi ?? '',
                        $b->NamaLokasi ?? ''
                    );
                }

                return $b->totalPabx
                    <=> $a->totalPabx;
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
            ->pluck('totalPabx')
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
             * Index harus selalu sama dengan labels/data.
             */
            'locationIds' => $locationIds,

            'datasets' => [

                [

                    'label' => $this->filter === 'all'
                        ? 'Jumlah PABX'
                        : 'Jumlah PABX - ' . $this->filter,

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

        const locationId =
            chart.data.locationIds[index];

        const locationName =
            chart.data.labels[index];

        if (!locationId) {
            return;
        }

        console.log(
            'PABX LOCATION CLICK:',
            locationId,
            locationName
        );

        Livewire.dispatch(
            'open-pabx-location-detail-modal',
            {
                location: locationId,
                jenis: $wire.filter,
            }
        );
    }
}

JS);
    }
}
