<?php

namespace App\Livewire;

use App\Exports\AssetDepartmentExport;
use App\Models\MstAsset;
use App\Models\MstKaryawan;
use App\Models\MstPerusahaan;
use Livewire\Component;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;

class AssetDepartmentModal extends Component
{
    public bool $show = false;

    public ?int $departmentId = null;

    public ?string $department = null;

    public string $statusAsset = 'all';

    public string $company = 'all';


    // =========================================================
    // SORTING
    // =========================================================

    public string $sortColumn = 'Nama';

    public string $sortDirection = 'asc';


    #[On('open-asset-department-modal')]
    public function open(
        $departmentId = null,
        $department = null
    ): void {

        $this->departmentId =
            $departmentId !== null
                ? (int) $departmentId
                : null;

        $this->department = $department;

        $this->statusAsset = 'all';

        $this->company = 'all';

        // Reset sorting setiap kali modal dibuka
        $this->sortColumn = 'Nama';

        $this->sortDirection = 'asc';

        $this->show = true;
    }


    public function close(): void
    {
        $this->show = false;

        $this->departmentId = null;

        $this->department = null;

        $this->statusAsset = 'all';

        $this->company = 'all';

        $this->sortColumn = 'Nama';

        $this->sortDirection = 'asc';
    }


    // =========================================================
    // SORT METHOD
    // =========================================================

    public function sortBy(string $column): void
    {
        /*
         * Daftar kolom yang diperbolehkan untuk sorting.
         *
         * Ini penting supaya user tidak bisa memasukkan
         * nama kolom SQL sembarangan.
         */
        $allowedColumns = [
            'NoAssetIT',
            'NoAssetSAP',
            'Nama',
            'Jenis',
            'Department',
            'Pemegang',
            'Perusahaan',
            'Lokasi',
            'StatusAsset',
        ];

        if (!in_array($column, $allowedColumns, true)) {
            return;
        }


        /*
         * Jika klik kolom yang sama,
         * ubah ASC <-> DESC.
         */
        if ($this->sortColumn === $column) {

            $this->sortDirection =
                $this->sortDirection === 'asc'
                    ? 'desc'
                    : 'asc';

            return;
        }


        /*
         * Jika klik kolom berbeda,
         * mulai dari ASC.
         */
        $this->sortColumn = $column;

        $this->sortDirection = 'asc';
    }


    // =========================================================
    // DATA ASSET
    // =========================================================

    public function getAssetsProperty()
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


            // =====================================================
            // SELECT ASSET
            // =====================================================

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
            // DEPARTMENT TIDAK DIKETAHUI
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
        // SORTING
        // =========================================================

        switch ($this->sortColumn) {

            case 'NoAssetIT':

                $query->orderBy(
                    'mstasset.NoAssetIT',
                    $this->sortDirection
                );

                break;


            case 'NoAssetSAP':

                $query->orderBy(
                    'mstasset.NoAssetSAP',
                    $this->sortDirection
                );

                break;


            case 'Nama':

                $query->orderBy(
                    'mstasset.Nama',
                    $this->sortDirection
                );

                break;


            case 'Jenis':

                $query->orderBy(
                    'mstasset.Jenis',
                    $this->sortDirection
                );

                break;


            case 'Department':

                $query->orderBy(
                    'mstdepartemen.NamaDept',
                    $this->sortDirection
                );

                break;


            case 'Pemegang':

                $query->orderBy(
                    'mstkaryawan.Nama',
                    $this->sortDirection
                );

                break;


            case 'Perusahaan':

                $query->orderBy(
                    'mstperusahaan.NamaPerusahaan',
                    $this->sortDirection
                );

                break;


            case 'Lokasi':

                $query->orderBy(
                    'mstlokasi.NamaLokasi',
                    $this->sortDirection
                );

                break;


            case 'StatusAsset':

                $query->orderBy(
                    'mstasset.StatusAsset',
                    $this->sortDirection
                );

                break;


            default:

                $query->orderBy(
                    'mstasset.Nama',
                    'asc'
                );

                break;
        }


        return $query

            ->with([
                'perusahaan',
                'karyawan',
                'lokasi',
            ])

            ->get();
    }


    // =========================================================
    // EXPORT EXCEL
    // =========================================================

    public function exportExcel()
    {
        $filename = 'Asset-Department';

        if ($this->department) {

            $filename .= '-'
                . preg_replace(
                    '/[^A-Za-z0-9\-]/',
                    '-',
                    $this->department
                );
        }

        $filename .= '-'
            . now()->format('Y-m-d-His')
            . '.xlsx';


        return Excel::download(
            new AssetDepartmentExport(
                departmentId: $this->departmentId,
                statusAsset: $this->statusAsset,
                company: $this->company,
            ),
            $filename
        );
    }


    public function render()
    {
        return view(
            'livewire.asset-department-modal'
        );
    }
}
