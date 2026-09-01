<?php

namespace App\Exports;

use App\Models\MstAsset;
use App\Models\MstKaryawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetDepartmentExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    protected int $rowNumber = 1;


    public function __construct(
        protected ?int $departmentId = null,
        protected string $statusAsset = 'all',
        protected string $company = 'all',

        // =====================================================
        // SORTING
        // =====================================================

        protected string $sortColumn = 'Nama',

        protected string $sortDirection = 'asc',
    ) {}


    /**
     * Query data yang akan diexport.
     *
     * Filter dan sorting dibuat mengikuti
     * data yang ditampilkan pada modal.
     */
    public function collection()
    {
        $query = MstAsset::query()

            // =====================================================
            // JOIN UNTUK SORTING
            // =====================================================

            ->leftJoin(
                'mstkaryawan',
                'mstasset.NIK',
                '=',
                'mstkaryawan.NIK'
            )

            ->leftJoin(
                'mstdepartemen',
                'mstkaryawan.IDDept',
                '=',
                'mstdepartemen.IDDept'
            )

            ->leftJoin(
                'mstperusahaan',
                'mstasset.IDPerusahaan',
                '=',
                'mstperusahaan.IDPerusahaan'
            )

            ->select(
                'mstasset.*'
            )


            // =====================================================
            // FILTER DEPARTMENT
            // =====================================================

            ->when(
                $this->departmentId !== null,
                function ($query) {

                    $query->where(
                        'mstkaryawan.IDDept',
                        $this->departmentId
                    );
                }
            )


            // =====================================================
            // DEPARTMENT "TIDAK DIKETAHUI"
            // =====================================================

            ->when(
                $this->departmentId === null,
                function ($query) {

                    $query->where(function ($query) {

                        $query
                            ->whereNull(
                                'mstasset.NIK'
                            )

                            ->orWhereNull(
                                'mstkaryawan.IDDept'
                            );
                    });
                }
            )


            // =====================================================
            // FILTER STATUS ASSET
            // =====================================================

            ->when(
                $this->statusAsset !== 'all',
                function ($query) {

                    $query->where(
                        'mstasset.StatusAsset',
                        $this->statusAsset
                    );
                }
            )


            // =====================================================
            // FILTER PERUSAHAAN
            // =====================================================

            ->when(
                $this->company !== 'all',
                function ($query) {

                    $query->where(
                        'mstasset.IDPerusahaan',
                        $this->company
                    );
                }
            );


        // =========================================================
        // VALIDASI SORT DIRECTION
        // =========================================================

        $sortDirection =
            in_array(
                strtolower($this->sortDirection),
                ['asc', 'desc'],
                true
            )
                ? strtolower($this->sortDirection)
                : 'asc';


        // =========================================================
        // SORTING
        // =========================================================

        switch ($this->sortColumn) {

            // -----------------------------------------------------
            // NO ASSET IT
            // -----------------------------------------------------

            case 'NoAssetIT':

                $query->orderBy(
                    'mstasset.NoAssetIT',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // NO ASSET SAP
            // -----------------------------------------------------

            case 'NoAssetSAP':

                $query->orderBy(
                    'mstasset.NoAssetSAP',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // NAMA ASSET
            // -----------------------------------------------------

            case 'Nama':

                $query->orderBy(
                    'mstasset.Nama',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // JENIS
            // -----------------------------------------------------

            case 'Jenis':

                $query->orderBy(
                    'mstasset.Jenis',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // DEPARTMENT
            // -----------------------------------------------------

            case 'Department':

                $query->orderBy(
                    'mstdepartemen.NamaDept',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // PEMEGANG
            // -----------------------------------------------------

            case 'Pemegang':

                $query->orderBy(
                    'mstkaryawan.Nama',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // PERUSAHAAN
            // -----------------------------------------------------

            case 'Perusahaan':

                $query->orderBy(
                    'mstperusahaan.NamaPerusahaan',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // STATUS ASSET
            // -----------------------------------------------------

            case 'StatusAsset':

                $query->orderBy(
                    'mstasset.StatusAsset',
                    $sortDirection
                );

                break;


            // -----------------------------------------------------
            // DEFAULT
            // -----------------------------------------------------

            default:

                $query->orderBy(
                    'mstasset.Nama',
                    'asc'
                );

                break;
        }


        // =========================================================
        // LOAD RELATIONSHIP
        // =========================================================

        return $query

            ->with([
                'perusahaan',
                'karyawan',
                'lokasi',
            ])

            ->get();
    }


    /**
     * Header Excel.
     */
    public function headings(): array
    {
        return [

            'No.',

            'No Asset IT',

            'No Asset SAP',

            'Nama Asset',

            'Jenis',

            'Department',

            'Pemegang',

            'Perusahaan',

            'Lokasi',

            'Status Asset',

        ];
    }


    /**
     * Mapping setiap record menjadi baris Excel.
     */
    public function map($asset): array
    {
        return [

            $this->rowNumber++,

            $asset->NoAssetIT ?? '-',

            $asset->NoAssetSAP ?? '-',

            $asset->Nama ?? '-',

            $asset->Jenis ?? '-',

            $asset->karyawan?->departemen?->NamaDept
                ?? 'Tidak Diketahui',

            $asset->karyawan?->Nama
                ?? '-',

            $asset->perusahaan?->NamaPerusahaan
                ?? '-',

            $asset->lokasi?->NamaLokasi
                ?? '-',

            $asset->StatusAsset
                ?? '-',

        ];
    }


    /**
     * Styling header Excel.
     */
    public function styles(Worksheet $sheet)
    {
        return [

            1 => [

                'font' => [

                    'bold' => true,

                    'color' => [

                        'rgb' => 'FFFFFF',

                    ],

                ],

                'fill' => [

                    'fillType' => 'solid',

                    'startColor' => [

                        'rgb' => '6D28D9',

                    ],

                ],

            ],

        ];
    }
}
