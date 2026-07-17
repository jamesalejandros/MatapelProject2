<?php

namespace App\Filament\Widgets;

use App\Models\MstAsset;

use Filament\Widgets\ChartWidget;


class AssetStatusChart extends ChartWidget
{

    protected ?string $heading = 'Asset Berdasarkan Status';


    protected function getData(): array
    {

        $data = MstAsset::selectRaw(
                'StatusAsset, COUNT(*) as total'
            )
            ->groupBy('StatusAsset')
            ->pluck('total', 'StatusAsset');


        return [

            'datasets' => [
                [
                    'label' => 'Jumlah Asset',
                    'data' => $data->values()->toArray(),
                ],
            ],


            'labels' => $data->keys()->toArray(),

        ];

    }


    protected function getType(): string
    {
        return 'pie';
    }

}