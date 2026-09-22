<?php

namespace App\Livewire;

use App\Models\TrxCctvAssignment;
use Livewire\Attributes\On;
use Livewire\Component;

class CctvAssignmentModal extends Component
{
    public bool $show = false;


    /**
     * ==========================================================
     * FILTER LOKASI
     * ==========================================================
     */
    public ?string $location = 'all';


    /**
     * ==========================================================
     * NAMA LOKASI
     * ==========================================================
     */
    public ?string $locationName = 'Semua Lokasi';


    /**
     * ==========================================================
     * FILTER JENIS CCTV
     * ==========================================================
     */
    public ?string $jenis = null;


    /**
     * ==========================================================
     * SORT FIELD
     * ==========================================================
     *
     * Field default:
     *
     *     IDAssignment
     */
    public string $sortField = 'IDAssignment';


    /**
     * ==========================================================
     * SORT DIRECTION
     * ==========================================================
     *
     * Nilai:
     *
     *     asc
     *     desc
     */
    public string $sortDirection = 'asc';


    /**
     * ==========================================================
     * FIELD YANG BOLEH DI-SORT
     * ==========================================================
     *
     * Digunakan sebagai whitelist agar hanya field
     * yang memang disediakan oleh header yang dapat
     * digunakan untuk sorting.
     */
    protected array $sortableFields = [

        'IDAssignment',

        'NoAssetIT',

        'Jenis',

        'Channel',

        'TanggalPasang',

        'Tipe',

        'Kondisi',

        'Keterangan',

    ];


    /**
     * ==========================================================
     * BUKA MODAL
     * ==========================================================
     */
    #[On('open-cctv-assignment-detail-modal')]
    public function open(
        $location = 'all',
        $locationName = 'Semua Lokasi',
        $jenis = null
    ): void {

        $this->location =
            $location !== null &&
            $location !== ''
                ? (string) $location
                : 'all';


        $this->locationName =
            $locationName !== null &&
            $locationName !== ''
                ? (string) $locationName
                : 'Semua Lokasi';


        $this->jenis =
            $jenis !== null &&
            trim((string) $jenis) !== ''
                ? trim((string) $jenis)
                : null;


        /**
         * ======================================================
         * RESET SORT SAAT MODAL DIBUKA
         * ======================================================
         */
        $this->sortField = 'IDAssignment';

        $this->sortDirection = 'asc';


        $this->show = true;
    }


    /**
     * ==========================================================
     * SORT TABLE
     * ==========================================================
     *
     * Klik header:
     *
     *     pertama  = ASC
     *     kedua    = DESC
     *     ketiga   = ASC
     *
     * Jika pindah ke kolom lain:
     *
     *     langsung ASC
     */
    public function sortBy(string $field): void
    {
        /**
         * ======================================================
         * VALIDASI FIELD
         * ======================================================
         */
        if (!in_array($field, $this->sortableFields, true)) {

            return;
        }


        /**
         * ======================================================
         * TOGGLE DIRECTION
         * ======================================================
         */
        if ($this->sortField === $field) {

            $this->sortDirection =
                $this->sortDirection === 'asc'
                    ? 'desc'
                    : 'asc';

        } else {

            $this->sortField = $field;

            $this->sortDirection = 'asc';

        }
    }


    /**
     * ==========================================================
     * TUTUP MODAL
     * ==========================================================
     */
    public function close(): void
    {
        $this->show = false;

        $this->location = 'all';

        $this->locationName = 'Semua Lokasi';

        $this->jenis = null;

        $this->sortField = 'IDAssignment';

        $this->sortDirection = 'asc';
    }


    /**
     * ==========================================================
     * NAMA LOKASI
     * ==========================================================
     */
    public function getLocationNameProperty(): string
    {
        if (
            $this->location === null ||
            $this->location === '' ||
            $this->location === 'all'
        ) {

            return 'Semua Lokasi';
        }


        return $this->locationName ?? 'Lokasi';
    }


    /**
     * ==========================================================
     * DATA ASSIGNMENT CCTV
     * ==========================================================
     */
    public function getAssignmentsProperty()
    {
        return TrxCctvAssignment::query()

            /**
             * ==================================================
             * FILTER LOKASI
             * ==================================================
             */
            ->when(

                $this->location !== null &&
                $this->location !== '' &&
                $this->location !== 'all',

                function ($query) {

                    $query->whereHas(
                        'asset',
                        function ($assetQuery) {

                            $assetQuery->where(
                                'IDLokasi',
                                $this->location
                            );

                        }
                    );

                }

            )


            /**
             * ==================================================
             * FILTER JENIS CCTV
             * ==================================================
             */
            ->when(

                $this->jenis !== null &&
                trim((string) $this->jenis) !== '',

                function ($query) {

                    $query->where(
                        'Jenis',
                        $this->jenis
                    );

                }

            )


            /**
             * ==================================================
             * LOAD RELATIONSHIP
             * ==================================================
             */
            ->with([

                'asset',

                'asset.perusahaan',

                'asset.lokasi',

                'asset.karyawan',

            ])


            /**
             * ==================================================
             * SORT
             * ==================================================
             */
            ->orderBy(
                $this->sortField,
                $this->sortDirection
            )


            ->get();
    }


    /**
     * ==========================================================
     * TOTAL CCTV
     * ==========================================================
     */
    public function getTotalProperty(): int
    {
        return $this->assignments->count();
    }


    /**
     * ==========================================================
     * RENDER
     * ==========================================================
     */
    public function render()
    {
        return view(
            'livewire.cctv-assignment-modal'
        );
    }
}
