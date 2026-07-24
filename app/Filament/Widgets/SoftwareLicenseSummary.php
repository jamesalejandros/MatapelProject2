<?php

namespace App\Filament\Widgets;

use App\Models\MstSoftware;
use App\Models\MstSoftwareLicense;

use Filament\Widgets\Widget;
use Livewire\Attributes\On;


class SoftwareLicenseSummary extends Widget
{

    protected string $view =
        'filament.resources.mst-software-licenses.widgets.software-license-summary';



    public ?MstSoftware $record = null;



    public ?string $selectedCompany = null;



    public array $summary = [];





    /*
    |--------------------------------------------------------------------------
    | COLLAPSE STATE
    |--------------------------------------------------------------------------
    */

    public bool $collapsed = false;



    public function toggleCollapse(): void
    {
        $this->collapsed = ! $this->collapsed;
    }







    public function mount(): void
    {
        $this->loadSummary();
    }








    public function updatedSelectedCompany(): void
    {
        $this->loadSummary();
    }








    public function resetFilter(): void
    {
        $this->selectedCompany = null;

        $this->loadSummary();
    }










    #[On('refreshSoftware')]

    public function refreshWidget(): void
    {
        $this->record?->refresh();

        $this->loadSummary();
    }









    public function getCompanyOptions(): array
    {

        if (! $this->record) {

            return [];

        }



        return MstSoftwareLicense::query()

            ->where(
                'IDSoftware',
                $this->record->IDSoftware
            )

            ->with('perusahaan')

            ->get()

            ->mapWithKeys(function ($license) {


                return [

                    $license->IDPerusahaan =>
                        $license->perusahaan?->NamaPerusahaan

                ];


            })

            ->filter()

            ->unique()

            ->toArray();

    }












    public function loadSummary(): void
    {


        if (! $this->record) {

            $this->summary = [];

            return;

        }





        $query = MstSoftwareLicense::query()

            ->where(
                'IDSoftware',
                $this->record->IDSoftware
            )

            ->with('perusahaan');







        if ($this->selectedCompany) {


            $query->where(
                'IDPerusahaan',
                $this->selectedCompany
            );


        }








        $this->summary = $query

            ->get()

            ->groupBy(function ($license) {


                return $license->perusahaan?->NamaPerusahaan
                    ??
                    'Tidak diketahui';


            })


            ->map(function ($licenses,$company){



                return [



                    'company' => $company,



                    'total_data' => $licenses->count(),




                    'total_license' =>

                        $licenses->sum('JumlahLisensi'),





                    /*
                     |--------------------------------------------------------------------------
                     | Breakdown berdasarkan TipeLisensi
                     |--------------------------------------------------------------------------
                     */

                    'categories' =>

                        $licenses

                        ->groupBy('TipeLisensi')

                        ->map(function($item){

                            return $item->sum('JumlahLisensi');

                        })

                        ->toArray(),



                ];



            })


            ->values()

            ->toArray();



    }












    public function getTotalData(): int
    {

        return collect($this->summary)

            ->sum('total_data');

    }











    public function getTotalLicense(): int
    {

        return collect($this->summary)

            ->sum('total_license');

    }












    /*
    |--------------------------------------------------------------------------
    | Total kategori license
    |--------------------------------------------------------------------------
    */

    public function getLicenseCategories(): array
    {


        return collect($this->summary)

            ->pluck('categories')

            ->collapse()

            ->groupBy(function($value,$key){

                return $key;

            })

            ->map(function($item){

                return $item->sum();

            })

            ->toArray();



    }



}