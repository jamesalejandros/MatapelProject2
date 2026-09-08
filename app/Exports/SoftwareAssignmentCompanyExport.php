<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SoftwareAssignmentCompanyExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    protected int $rowNumber = 1;


    public function __construct(
        protected ?string $software = null,

        protected string $company = 'all',

        protected string $statusAssignment = 'Installed',

        protected string $sortColumn = 'NamaPemakai',

        protected string $sortDirection = 'asc',
    ) {}


    // =========================================================
    // QUERY EXPORT
    // =========================================================

    public function collection()
    {
        $query = DB::table(
            'trxsoftwareassignment as tsa'
        )

            ->join(
                'mstsoftwarelicense as msl',
                'tsa.IDLicense',
                '=',
                'msl.IDLicense'
            )

            ->join(
                'mstsoftware as ms',
                'msl.IDSoftware',
                '=',
                'ms.IDSoftware'
            )

            ->join(
                'mstasset as ma',
                'tsa.NoAssetIT',
                '=',
                'ma.NoAssetIT'
            )

            ->leftJoin(
                'mstkaryawan as mk',
                'ma.NIK',
                '=',
                'mk.NIK'
            )

            ->leftJoin(
                'mstperusahaan as mp',
                'ma.IDPerusahaan',
                '=',
                'mp.IDPerusahaan'
            )

            ->where(
                'ms.NamaSoftware',
                $this->software
            )

            ->whereNull(
                'tsa.TanggalRevoke'
            );


        // =====================================================
        // FILTER STATUS ASSIGNMENT
        // =====================================================

        if (
            $this->statusAssignment !== 'all'
        ) {

            $query->where(
                'tsa.StatusAssignment',
                $this->statusAssignment
            );
        }


        // =====================================================
        // FILTER PERUSAHAAN
        // =====================================================

        if (
            $this->company !== 'all'
        ) {

            $query->where(
                'ma.IDPerusahaan',
                $this->company
            );
        }


        // =====================================================
        // VALIDASI SORT DIRECTION
        // =====================================================

        $sortDirection =
            in_array(
                strtolower(
                    $this->sortDirection
                ),
                [
                    'asc',
                    'desc',
                ],
                true
            )
                ? strtolower(
                    $this->sortDirection
                )
                : 'asc';


        // =====================================================
        // SORTING
        // =====================================================

        switch ($this->sortColumn) {

            // -------------------------------------------------
            // SOFTWARE
            // -------------------------------------------------

            case 'Software':

                $query->orderBy(
                    'ms.NamaSoftware',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // VERSION
            // -------------------------------------------------

            case 'Version':

                $query->orderBy(
                    'ms.Version',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // ID LICENSE
            // -------------------------------------------------

            case 'IDLicense':

                $query->orderBy(
                    'tsa.IDLicense',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // NIK
            // -------------------------------------------------

            case 'NIK':

                $query->orderBy(
                    'mk.NIK',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // NAMA PEMAKAI
            // -------------------------------------------------

            case 'NamaPemakai':

                $query->orderBy(
                    'mk.Nama',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // NO ASSET
            // -------------------------------------------------

            case 'NoAssetIT':

                $query->orderBy(
                    'ma.NoAssetIT',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // NAMA ASSET
            // -------------------------------------------------

            case 'NamaAsset':

                $query->orderBy(
                    'ma.Nama',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // COMPUTER NAME
            // -------------------------------------------------

            case 'ComputerName':

                $query->orderBy(
                    'ma.ComputerName',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // PERUSAHAAN
            // -------------------------------------------------

            case 'Perusahaan':

                $query->orderBy(
                    'mp.NamaPerusahaan',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // TANGGAL ASSIGN
            // -------------------------------------------------

            case 'TanggalAssign':

                $query->orderBy(
                    'tsa.TanggalAssign',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // STATUS
            // -------------------------------------------------

            case 'StatusAssignment':

                $query->orderBy(
                    'tsa.StatusAssignment',
                    $sortDirection
                );

                break;


            // -------------------------------------------------
            // DEFAULT
            // -------------------------------------------------

            default:

                $query->orderBy(
                    'mk.Nama',
                    'asc'
                );

                break;
        }


        return $query

            ->select([

                'tsa.IDAssignment',
                'tsa.IDLicense',
                'tsa.TanggalAssign',
                'tsa.StatusAssignment',

                'ms.NamaSoftware',
                'ms.Version',

                'ma.NoAssetIT',
                'ma.Nama as NamaAsset',
                'ma.ComputerName',

                'mk.NIK',
                'mk.Nama as NamaPemakai',

                'mp.NamaPerusahaan',

            ])

            ->get();
    }


    // =========================================================
    // EXCEL HEADINGS
    // =========================================================

    public function headings(): array
    {
        return [

            'No.',

            'Software',

            'Version',

            'ID License',

            'NIK',

            'Nama Pemakai',

            'No Asset IT',

            'Nama Asset',

            'Computer Name',

            'Perusahaan',

            'Tanggal Assign',

            'Status Assignment',

        ];
    }


    // =========================================================
    // MAPPING
    // =========================================================

    public function map($assignment): array
    {
        return [

            $this->rowNumber++,

            $assignment->NamaSoftware
                ?? '-',

            $assignment->Version
                ?? '-',

            $assignment->IDLicense
                ?? '-',

            $assignment->NIK
                ?? '-',

            $assignment->NamaPemakai
                ?? 'Belum Ada Pemakai',

            $assignment->NoAssetIT
                ?? '-',

            $assignment->NamaAsset
                ?? '-',

            $assignment->ComputerName
                ?? '-',

            $assignment->NamaPerusahaan
                ?? '-',

            $assignment->TanggalAssign
                ? \Carbon\Carbon::parse(
                    $assignment->TanggalAssign
                )->format('d/m/Y H:i')
                : '-',

            $assignment->StatusAssignment
                ?? '-',

        ];
    }


    // =========================================================
    // EXCEL STYLE
    // =========================================================

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
