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
     * LOKASI CCTV
     * ==========================================================
     *
     * Lokasi berasal dari:
     *
     *     mstasset.IDLokasi
     *
     * yang terhubung dengan:
     *
     *     trxcctvassignment.NoAssetIT
     *
     *     ->
     *
     *     mstasset.NoAssetIT
     *
     *     ->
     *
     *     mstasset.IDLokasi
     *
     *     ->
     *
     *     mstlokasi.IDLokasi
     */
    public ?string $locationId = 'all';


    /**
     * ==========================================================
     * NAMA LOKASI
     * ==========================================================
     *
     * Digunakan untuk ditampilkan pada header modal.
     */
    public ?string $locationName = 'Semua Lokasi';


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
     *     locationId
     *     locationName
     */
    #[On('open-cctv-assignment-detail-modal')]
    public function open(
        $locationId = 'all',
        $locationName = 'Semua Lokasi'
    ): void {

        $this->locationId =
            $locationId !== null
                ? (string) $locationId
                : 'all';


        $this->locationName =
            $locationName !== null &&
            $locationName !== ''
                ? (string) $locationName
                : 'Semua Lokasi';


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

        $this->locationId = 'all';

        $this->locationName = 'Semua Lokasi';
    }


    /**
     * ==========================================================
     * NAMA LOKASI
     * ==========================================================
     */
    public function getLocationNameProperty(): string
    {
        if (
            $this->locationId === null ||
            $this->locationId === 'all'
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
     * Sumber:
     *
     *     trxcctvassignment
     *
     * Relasi lokasi:
     *
     *     trxcctvassignment.NoAssetIT
     *         ->
     *     mstasset.NoAssetIT
     *         ->
     *     mstasset.IDLokasi
     *         ->
     *     mstlokasi.IDLokasi
     *
     * Filter:
     *
     *     Lokasi CCTV
     *
     * Relationship detail:
     *
     *     asset
     *     asset.perusahaan
     *     asset.lokasi
     *     asset.karyawan
     */
    public function getAssignmentsProperty()
    {
        return TrxCctvAssignment::query()

            /**
             * ==================================================
             * FILTER LOKASI
             * ==================================================
             *
             * Jika locationId = all:
             *
             *     Semua assignment CCTV.
             *
             * Jika locationId tertentu:
             *
             *     Hanya CCTV pada lokasi tersebut.
             */
            ->when(

                $this->locationId !== null &&
                $this->locationId !== 'all',

                function ($query) {

                    $query

                        ->whereHas(
                            'asset',
                            function ($assetQuery) {

                                $assetQuery->where(
                                    'IDLokasi',
                                    $this->locationId
                                );

                            }
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