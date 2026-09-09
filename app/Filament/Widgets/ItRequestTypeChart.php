<?php

namespace App\Filament\Widgets;

use App\Models\ItRequest;
use Carbon\Carbon;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class ItRequestTypeChart extends ChartWidget
{
    protected ?string $heading = 'Permintaan IT Berdasarkan Jenis';

    /*
    |--------------------------------------------------------------------------
    | DEFAULT FILTER
    |--------------------------------------------------------------------------
    |
    | Format:
    |
    | YYYY
    |     = semua bulan dalam tahun tersebut
    |
    | YYYY-MM
    |     = bulan tertentu
    |
    */

    public ?string $filter = null;

    /*
    |--------------------------------------------------------------------------
    | JENIS MAPPING
    |--------------------------------------------------------------------------
    |
    | Mapping nama jenis yang berasal dari mstjenispermintaan.
    |
    */

    public array $jenisMapping = [];

    /*
    |--------------------------------------------------------------------------
    | FILTER OPTIONS
    |--------------------------------------------------------------------------
    */

    protected function getFilters(): ?array
    {
        $currentYear = now()->year;

        /*
        |--------------------------------------------------------------------------
        | AMBIL TAHUN YANG MEMANG ADA DATA
        |--------------------------------------------------------------------------
        */

        $years = ItRequest::query()
            ->selectRaw('YEAR(created_at) as year')
            ->whereNotNull('created_at')
            ->groupByRaw('YEAR(created_at)')
            ->orderByRaw('YEAR(created_at) DESC')
            ->pluck('year')
            ->map(fn ($year) => (int) $year)
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN TAHUN SEKARANG SELALU ADA
        |--------------------------------------------------------------------------
        */

        if (! in_array($currentYear, $years, true)) {
            array_unshift($years, $currentYear);
        }

        /*
        |--------------------------------------------------------------------------
        | SORT DESC
        |--------------------------------------------------------------------------
        */

        $years = collect($years)
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | BUILD FILTER
        |--------------------------------------------------------------------------
        */

        $filters = [];

        foreach ($years as $year) {

            /*
            |--------------------------------------------------------------------------
            | DEFAULT: SEMUA BULAN
            |--------------------------------------------------------------------------
            */

            $filters[(string) $year] =
                $year . ' — Semua Bulan';


            /*
            |--------------------------------------------------------------------------
            | BULAN
            |--------------------------------------------------------------------------
            */

            for ($month = 1; $month <= 12; $month++) {

                $value =
                    $year
                    . '-'
                    . str_pad(
                        $month,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );

                $monthName = Carbon::create(
                    $year,
                    $month,
                    1
                )->translatedFormat('F');

                $filters[$value] =
                    $year
                    . ' — '
                    . $monthName;

            }

        }

        return $filters;
    }


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    protected function getData(): array
    {
        /*
        |--------------------------------------------------------------------------
        | DEFAULT FILTER
        |--------------------------------------------------------------------------
        */

        $filter =
            $this->filter
            ??
            (string) now()->year;


        /*
        |--------------------------------------------------------------------------
        | PARSE YEAR / MONTH
        |--------------------------------------------------------------------------
        */

        if (
            str_contains(
                $filter,
                '-'
            )
        ) {

            [$year, $month] =
                array_map(
                    'intval',
                    explode(
                        '-',
                        $filter
                    )
                );

        } else {

            $year =
                (int) $filter;

            $month = null;

        }


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = ItRequest::query()
            ->with('jenisPermintaan')
            ->whereYear(
                'created_at',
                $year
            );


        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN
        |--------------------------------------------------------------------------
        */

        if ($month !== null) {

            $query->whereMonth(
                'created_at',
                $month
            );

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL REQUEST
        |--------------------------------------------------------------------------
        */

        $requests = $query
            ->orderBy(
                'created_at',
                'asc'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | JENIS
        |--------------------------------------------------------------------------
        |
        | Ambil seluruh jenis yang digunakan oleh request
        | dalam periode filter.
        |
        */

        $jenisNames = $requests
            ->flatMap(
                fn ($request) =>
                    $request
                        ->jenisPermintaan
                        ->pluck('name')
            )
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | FALLBACK JIKA TIDAK ADA DATA
        |--------------------------------------------------------------------------
        */

        if ($jenisNames->isEmpty()) {

            $jenisNames = collect([
                'Hardware',
                'Software',
                'Data',
                'Lain-lain',
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | LABEL BULAN
        |--------------------------------------------------------------------------
        */

        if ($month !== null) {

            $labels = [
                Carbon::create(
                    $year,
                    $month,
                    1
                )->translatedFormat('F'),
            ];

        } else {

            $labels = [];

            for ($i = 1; $i <= 12; $i++) {

                $labels[] =
                    Carbon::create(
                        $year,
                        $i,
                        1
                    )->translatedFormat('F');

            }

        }


        /*
        |--------------------------------------------------------------------------
        | DATASET
        |--------------------------------------------------------------------------
        */

        $datasets = [];


        /*
        |--------------------------------------------------------------------------
        | WARNA
        |--------------------------------------------------------------------------
        */

        $colors = [

            '#3B82F6', // Blue
            '#10B981', // Green
            '#F59E0B', // Amber
            '#EF4444', // Red
            '#8B5CF6', // Violet
            '#06B6D4', // Cyan
            '#F97316', // Orange
            '#EC4899', // Pink
            '#14B8A6', // Teal
            '#6366F1', // Indigo
            '#84CC16', // Lime
            '#A855F7', // Purple

        ];


        /*
        |--------------------------------------------------------------------------
        | LOOP JENIS
        |--------------------------------------------------------------------------
        */

        foreach (
            $jenisNames as $jenisIndex => $jenis
        ) {

            $data = [];


            /*
            |--------------------------------------------------------------------------
            | BULAN TERPILIH
            |--------------------------------------------------------------------------
            */

            if ($month !== null) {

                $total = $requests
                    ->filter(
                        function ($request) use (
                            $jenis
                        ) {

                            return
                                $request
                                    ->jenisPermintaan
                                    ->contains(
                                        'name',
                                        $jenis
                                    );

                        }
                    )
                    ->count();


                $data[] = $total;

            }


            /*
            |--------------------------------------------------------------------------
            | SEMUA BULAN
            |--------------------------------------------------------------------------
            */

            else {

                for (
                    $currentMonth = 1;
                    $currentMonth <= 12;
                    $currentMonth++
                ) {

                    $total = $requests
                        ->filter(
                            function ($request) use (
                                $currentMonth,
                                $jenis
                            ) {

                                if (
                                    Carbon::parse(
                                        $request->created_at
                                    )->month
                                    !==
                                    $currentMonth
                                ) {

                                    return false;

                                }

                                return
                                    $request
                                        ->jenisPermintaan
                                        ->contains(
                                            'name',
                                            $jenis
                                        );

                            }
                        )
                        ->count();


                    $data[] = $total;

                }

            }


            $color =
                $colors[
                    $jenisIndex
                    %
                    count($colors)
                ];


            /*
            |--------------------------------------------------------------------------
            | DATASET
            |--------------------------------------------------------------------------
            */

            $datasets[] = [

                'label' =>
                    $jenis,

                'data' =>
                    $data,

                'backgroundColor' =>
                    $color,

                'borderColor' =>
                    $color,

                'borderWidth' =>
                    1,

                'borderRadius' =>
                    4,

                'borderSkipped' =>
                    false,

            ];

        }


        /*
        |--------------------------------------------------------------------------
        | MAPPING UNTUK CLICK
        |--------------------------------------------------------------------------
        */

        $this->jenisMapping =
            $jenisNames
                ->values()
                ->mapWithKeys(
                    fn ($jenis, $index) => [
                        $jenis => $jenis,
                    ]
                )
                ->toArray();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return [

            'datasets' =>
                $datasets,

            'labels' =>
                $labels,

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | CHART TYPE
    |--------------------------------------------------------------------------
    */

    protected function getType(): string
    {
        return 'bar';
    }


    /*
    |--------------------------------------------------------------------------
    | CHART OPTIONS
    |--------------------------------------------------------------------------
    */

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'

{
    responsive: true,

    maintainAspectRatio: false,

    interaction: {
        mode: 'nearest',
        intersect: true
    },

    plugins: {

        legend: {
            position: 'bottom',

            labels: {
                usePointStyle: true,
                padding: 15
            }
        },

        tooltip: {

            callbacks: {

                label: function(context)
                {

                    const label =
                        context.dataset.label
                        || '';

                    const value =
                        context.parsed.y
                        || 0;

                    return label + ': ' + value + ' Request';

                }

            }

        }

    },

    scales: {

        x: {

            stacked: true,

            title: {
                display: true,
                text: 'Bulan'
            },

            grid: {
                display: false
            }

        },

        y: {

            stacked: true,

            beginAtZero: true,

            ticks: {

                precision: 0

            },

            title: {
                display: true,
                text: 'Jumlah Request'
            }

        }

    },

    onClick(event, elements, chart)
    {

        if (!elements.length) {
            return;
        }


        const element =
            elements[0];


        const datasetIndex =
            element.datasetIndex;


        const index =
            element.index;


        const jenis =
            chart
                .data
                .datasets[datasetIndex]
                .label;


        const bulan =
            chart
                .data
                .labels[index];


        const filter =
            $wire.filter;


        console.log(
            'IT REQUEST CLICK:',
            {
                jenis: jenis,
                bulan: bulan,
                filter: filter
            }
        );


        Livewire.dispatch(
            'open-it-request-detail-modal',
            {
                jenis: jenis,
                bulan: bulan,
                filter: filter
            }
        );

    }

}

JS);
    }
}
