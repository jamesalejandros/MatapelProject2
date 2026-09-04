<?php

namespace App\Livewire;

use App\Models\MstLokasi;
use App\Models\TrxPabxAssignment;
use Livewire\Attributes\On;
use Livewire\Component;

class PabxLocationModal extends Component
{
    public bool $show = false;

    /**
     * Lokasi yang diklik dari chart.
     */
    public ?string $location = null;

    /**
     * Jenis PABX yang sedang difilter.
     *
     * all = semua jenis
     */
    public ?string $jenis = 'all';

    /**
     * ==========================================================
     * BUKA MODAL
     * ==========================================================
     */
    #[On('open-pabx-location-detail-modal')]
    public function open(
        $location,
        $jenis = 'all'
    ): void {

        $this->location = $location;

        $this->jenis = $jenis;

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

        $this->location = null;

        $this->jenis = 'all';
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
            $this->location === 'all'
        ) {
            return 'Semua Lokasi';
        }

        return MstLokasi::query()
            ->where(
                'IDLokasi',
                $this->location
            )
            ->value('NamaLokasi') ?? '-';
    }

    /**
     * ==========================================================
     * NAMA JENIS
     * ==========================================================
     */
    public function getJenisNameProperty(): string
    {
        if (
            $this->jenis === null ||
            $this->jenis === 'all'
        ) {
            return 'Semua Jenis';
        }

        return $this->jenis;
    }

    /**
     * ==========================================================
     * DATA PABX ASSIGNMENT
     * ==========================================================
     *
     * Sumber utama:
     *
     *     trxpabxassignment
     *
     * Filter:
     *
     *     1. Lokasi asset
     *     2. Jenis PABX
     *
     * Yang ditampilkan adalah setiap assignment PABX,
     * bukan setiap asset.
     */
    public function getAssignmentsProperty()
    {
        return TrxPabxAssignment::query()

            /**
             * ==================================================
             * FILTER LOKASI
             * ==================================================
             *
             * Lokasi berada di mstasset.
             */
            ->whereHas(
                'asset',
                function ($query) {

                    if (
                        $this->location !== null &&
                        $this->location !== 'all'
                    ) {
                        $query->where(
                            'IDLokasi',
                            $this->location
                        );
                    }
                }
            )

            /**
             * ==================================================
             * FILTER JENIS PABX
             * ==================================================
             */
            ->when(
                $this->jenis !== null &&
                $this->jenis !== 'all',
                fn ($query) =>
                    $query->where(
                        'Jenis',
                        $this->jenis
                    )
            )

            /**
             * ==================================================
             * LOAD RELATIONSHIP
             * ==================================================
             */
            ->with([
                'asset.perusahaan',
                'asset.lokasi',
                'asset.karyawan',
                'karyawan',
                'ruangan',
                'sambungan',
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
     * TOTAL ASSIGNMENT
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
            'livewire.pabx-location-modal'
        );
    }
}
