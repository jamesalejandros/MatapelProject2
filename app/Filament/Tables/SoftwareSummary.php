<?php

namespace App\Filament\Tables;

use Illuminate\Database\Eloquent\Builder;


class SoftwareSummary
{


    public static function generate(Builder $query): array
    {


        $software = $query

            ->with([
                'license.perusahaan'
            ])

            ->get();





        /*
        |--------------------------------------------------------------------------
        | TOTAL SOFTWARE
        |--------------------------------------------------------------------------
        */

        $totalSoftware = $software->count();





        /*
        |--------------------------------------------------------------------------
        | TOTAL LICENSE / PRODUCT KEY
        |--------------------------------------------------------------------------
        */

        $totalLicense = $software

            ->sum(function ($item) {


                return $item->license

                    ->sum('JumlahLisensi');


            });








        /*
        |--------------------------------------------------------------------------
        | BREAKDOWN KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori = $software

            ->groupBy(function ($item) {


                return $item->SoftCategory
                    ?? 'Tidak ada kategori';


            })


            ->map(function ($items) {


                return [

                    'software' =>
                        $items->count(),


                    'license' =>
                        $items->sum(function ($software) {


                            return $software->license

                                ->sum('JumlahLisensi');


                        }),

                ];


            })

            ->toArray();









        /*
        |--------------------------------------------------------------------------
        | BREAKDOWN PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        $perusahaan = $software


            ->flatMap(function ($item) {


                return $item->license;


            })


            ->groupBy(function ($license) {


                return $license->perusahaan?->NamaPerusahaan

                    ?? 'Tidak diketahui';


            })


            ->map(function ($licenses) {


                return [

                    'software' =>

                        $licenses

                            ->pluck('IDSoftware')

                            ->unique()

                            ->count(),



                    'license' =>

                        $licenses

                            ->sum('JumlahLisensi'),

                ];


            })


            ->toArray();








        return [


            'total_software' => $totalSoftware,


            'total_license' => $totalLicense,


            'kategori' => $kategori,


            'perusahaan' => $perusahaan,


        ];


    }


}