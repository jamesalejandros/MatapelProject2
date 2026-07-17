<?php

namespace App\Filament\Widgets;

use App\Models\MstAsset;

use Filament\Widgets\ChartWidget;


class AssetCompanyChart extends ChartWidget
{

    protected ?string $heading = 'Asset Berdasarkan Perusahaan';


    protected function getData(): array
    {

        $data = MstAsset::query()
            ->selectRaw(
                'IDPerusahaan, COUNT(*) as total'
            )
            ->with('perusahaan')
            ->groupBy('IDPerusahaan')
            ->get();


        return [

            'datasets' => [
                [
                    'label' => 'Jumlah Asset',
                    'data' => $data
                        ->pluck('total')
                        ->toArray(),
                ],
            ],


            'labels' => $data
                ->map(fn ($item) =>
                    $item->perusahaan?->NamaPerusahaan ?? 'Tanpa Perusahaan'
                )
                ->toArray(),

        ];

    }


    protected function getType(): string
    {
        return 'bar';
    }

}