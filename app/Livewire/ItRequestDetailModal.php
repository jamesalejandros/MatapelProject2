<?php

namespace App\Livewire;

use App\Models\ItRequest;
use Carbon\Carbon;
use Livewire\Component;

class ItRequestDetailModal extends Component
{
    public bool $show = false;

    public ?string $jenis = null;

    public ?string $bulan = null;

    public ?string $filter = null;


    /*
    |--------------------------------------------------------------------------
    | LISTENER
    |--------------------------------------------------------------------------
    */

    protected $listeners = [

        'open-it-request-detail-modal' =>
            'open',

    ];


    /*
    |--------------------------------------------------------------------------
    | OPEN
    |--------------------------------------------------------------------------
    */

    public function open(
        $jenis,
        $bulan,
        $filter
    ): void {

        $this->jenis =
            $jenis;

        $this->bulan =
            $bulan;

        $this->filter =
            $filter;

        $this->show =
            true;

    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE
    |--------------------------------------------------------------------------
    */

    public function close(): void
    {
        $this->show = false;
    }


    /*
    |--------------------------------------------------------------------------
    | REQUEST DATA
    |--------------------------------------------------------------------------
    */

    public function getRequestsProperty()
    {
        if (
            blank($this->jenis)
            ||
            blank($this->bulan)
        ) {

            return collect();

        }


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN TAHUN
        |--------------------------------------------------------------------------
        */

        if (
            str_contains(
                $this->filter ?? '',
                '-'
            )
        ) {

            [$year] =
                array_map(
                    'intval',
                    explode(
                        '-',
                        $this->filter
                    )
                );

        } else {

            $year =
                (int) (
                    $this->filter
                    ??
                    now()->year
                );

        }


        /*
        |--------------------------------------------------------------------------
        | BULAN DARI LABEL CHART
        |--------------------------------------------------------------------------
        */

        $monthNumber =
            collect(
                range(1, 12)
            )
            ->first(
                function ($month) {

                    return
                        Carbon::create(
                            null,
                            $month,
                            1
                        )->translatedFormat('F')
                        ===
                        $this->bulan;

                }
            );


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        return ItRequest::query()

            ->with([
                'pemohon.karyawan.departemen',
                'jenisPermintaan',
                'penyelesai.karyawan',
            ])

            ->whereYear(
                'created_at',
                $year
            )

            ->whereMonth(
                'created_at',
                $monthNumber
            )

            ->whereHas(
                'jenisPermintaan',
                function ($query) {

                    $query->where(
                        'mstjenispermintaan.name',
                        $this->jenis
                    );

                }
            )

            ->orderBy(
                'created_at',
                'desc'
            )

            ->get();

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.it-request-detail-modal'
        );
    }
}
