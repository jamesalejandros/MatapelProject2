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
     * ==========================================================
     * LOKASI
     * ==========================================================
     *
     * Lokasi berasal dari filter chart.
     */
    public ?string $location = null;

    /**
     * ==========================================================
     * JENIS PABX
     * ==========================================================
     *
     * Jenis berasal dari potongan chart yang diklik.
     */
    public ?string $jenis = 'all';

    /**
     * ==========================================================
     * BUKA MODAL
     * ==========================================================
     */
    #[On('open-pabx-location-detail-modal')]
    public function open(
        $location = null,
        $jenis = 'all'
    ): void {

        $this->location =
            $location !== null
                ? (string) $location
                : null;

        $this->jenis =
            $jenis !== null
                ? (string) $jenis
                : 'all';

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
     * DATA ASSIGNMENT PABX
     * ==========================================================
     *
     * Sumber:
     *
     *     trxpabxassignment
     *
     * Filter:
     *
     *     1. Lokasi asset
     *     2. Jenis PABX
     *
     * Yang ditampilkan:
     *
     *     Setiap assignment PABX.
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
             * FILTER JENIS
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
             *
             * Sambungan WAJIB di-load dari relationship.
             */
            ->with([

                /**
                 * Asset
                 */
                'asset',

                'asset.perusahaan',

                'asset.lokasi',

                'asset.karyawan',

                /**
                 * Karyawan assignment
                 */
                'karyawan',

                /**
                 * Ruangan
                 */
                'ruangan',

                /**
                 * Sambungan
                 *
                 * TrxPabxAssignment
                 *     -> MstSambungan
                 */
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
     * TOTAL
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
