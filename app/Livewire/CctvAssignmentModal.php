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
     * JENIS CCTV
     * ==========================================================
     *
     * Jenis berasal dari:
     *
     *     slice chart yang diklik
     *
     * Contoh:
     *
     *     IP
     *     Analog
     *
     * Modal hanya menggunakan Jenis sebagai filter.
     */
    public ?string $jenis = 'all';


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
     *     jenis
     */
    #[On('open-cctv-assignment-detail-modal')]
    public function open(
        $jenis = 'all'
    ): void {

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

        $this->jenis = 'all';
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
     * DATA ASSIGNMENT CCTV
     * ==========================================================
     *
     * Sumber:
     *
     *     trxcctvassignment
     *
     * Filter:
     *
     *     Jenis CCTV
     *
     * Relationship detail:
     *
     *     asset
     *     asset.perusahaan
     *     asset.lokasi
     *     asset.karyawan
     *
     * Catatan:
     *
     * Lokasi hanya ditampilkan sebagai informasi detail
     * dari asset.
     *
     * Lokasi BUKAN filter CCTV.
     */
    public function getAssignmentsProperty()
    {
        return TrxCctvAssignment::query()

            /**
             * ==================================================
             * FILTER JENIS
             * ==================================================
             *
             * Jika jenis = all:
             *
             *     Semua assignment CCTV.
             *
             * Jika jenis = IP:
             *
             *     Hanya assignment dengan Jenis = IP.
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
             * Relationship digunakan hanya untuk
             * menampilkan informasi asset pada modal.
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
