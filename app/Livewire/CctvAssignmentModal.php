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
     *
     * Nilai:
     *
     *     all
     *     atau IDLokasi tertentu.
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
     *
     * Jenis berasal dari potongan pie chart
     * yang diklik.
     */
    public ?string $jenis = null;


    /**
     * ==========================================================
     * BUKA MODAL
     * ==========================================================
     *
     * Event:
     *
     *     open-cctv-assignment-detail-modal
     *
     * Parameter:
     *
     *     location
     *     locationName
     *     jenis
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


        $this->show = true;
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
     *
     * Filter:
     *
     *     1. Lokasi
     *     2. Jenis CCTV
     *
     * Relasi:
     *
     *     trxcctvassignment.NoAssetIT
     *         ->
     *     mstasset.NoAssetIT
     *         ->
     *     mstasset.IDLokasi
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
             *
             * Jenis berasal dari slice pie chart.
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
                'IDAssignment'
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
