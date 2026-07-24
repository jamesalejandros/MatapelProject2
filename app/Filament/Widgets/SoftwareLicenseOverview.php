<?php

namespace App\Filament\Widgets;


use App\Models\MstSoftware;
use App\Models\MstSoftwareLicense;


use Filament\Widgets\Widget;

use Livewire\Attributes\On;



class SoftwareLicenseOverview extends Widget
{


    protected string $view =
        'filament.widgets.software-license-overview';



    public ?string $selectedCompany = null;


    public ?string $selectedCategory = null;



    public array $summary = [];



    public array $categorySummary = [];



    public array $companyOptions = [];



    public array $categoryOptions = [];





    public function mount(): void
    {

        $this->loadFilterOptions();

        $this->loadSummary();

    }







    public function updatedSelectedCompany(): void
    {
        $this->loadSummary();
    }





    public function updatedSelectedCategory(): void
    {
        $this->loadSummary();
    }







    public function resetFilter(): void
    {

        $this->selectedCompany = null;

        $this->selectedCategory = null;


        $this->loadSummary();

    }








    public function loadFilterOptions(): void
    {


        $this->companyOptions = MstSoftwareLicense::query()

            ->with('perusahaan')

            ->get()

            ->pluck(
                'perusahaan.NamaPerusahaan',
                'IDPerusahaan'
            )

            ->filter()

            ->unique()

            ->toArray();






        $this->categoryOptions = MstSoftware::query()

            ->whereNotNull('SoftCategory')

            ->where(
                'SoftCategory',
                '!=',
                ''
            )

            ->distinct()

            ->orderBy('SoftCategory')

            ->pluck(
                'SoftCategory',
                'SoftCategory'
            )

            ->toArray();



    }









    public function loadSummary(): void
    {



        $query = MstSoftwareLicense::query()

            ->with([
                'software',
                'perusahaan'
            ]);






        /*
        |--------------------------------------------------------------------------
        | FILTER PERUSAHAAN
        |--------------------------------------------------------------------------
        */


        if ($this->selectedCompany) {


            $query->where(
                'IDPerusahaan',
                $this->selectedCompany
            );


        }







        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */


        if ($this->selectedCategory) {


            $query->whereHas(

                'software',

                function($q){

                    $q->where(
                        'SoftCategory',
                        $this->selectedCategory
                    );

                }

            );


        }









        $licenses = $query->get();









        /*
        |--------------------------------------------------------------------------
        | SUMMARY PER SOFTWARE
        |--------------------------------------------------------------------------
        */


        $this->summary = $licenses

            ->groupBy(function($license){

                return $license->software?->NamaSoftware
                    ??
                    'Tidak diketahui';

            })


            ->map(function($items,$software){


                return [

                    'software'=>$software,


                    'total_license'=>

                        $items->sum('JumlahLisensi'),



                    'company'=>

                        $items

                        ->pluck('perusahaan.NamaPerusahaan')

                        ->filter()

                        ->unique()

                        ->values()

                        ->toArray(),



                    'category'=>

                        $items

                        ->pluck('software.SoftCategory')

                        ->filter()

                        ->unique()

                        ->values()

                        ->toArray(),



                ];


            })

            ->values()

            ->toArray();









        /*
        |--------------------------------------------------------------------------
        | HITUNG KATEGORI
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | Perusahaan A
        |   Office 10
        |   Antivirus 20
        |
        */


        $this->categorySummary = $licenses


            ->groupBy(function($license){


                return $license->software?->SoftCategory
                    ??
                    'Tidak diketahui';


            })


            ->map(function($items,$category){


                return [

                    'category'=>$category,


                    'total'=>

                        $items->sum('JumlahLisensi'),



                    'company'=>

                        $items

                        ->groupBy(
                            'perusahaan.NamaPerusahaan'
                        )

                        ->map(function($companyItems){

                            return $companyItems
                                ->sum('JumlahLisensi');

                        })

                        ->toArray(),

                ];


            })

            ->values()

            ->toArray();



    }









    public function getTotalLicense(): int
    {

        return collect($this->summary)

            ->sum('total_license');

    }








    public function getTotalSoftware(): int
    {

        return count($this->summary);

    }








    public function getTotalCategory(): int
    {

        return count($this->categorySummary);

    }









    #[On('refreshSoftware')]

    public function refreshWidget(): void
    {

        $this->loadFilterOptions();

        $this->loadSummary();

    }



}