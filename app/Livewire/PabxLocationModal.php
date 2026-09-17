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
     */
    public ?string $location = null;

    /**
     * ==========================================================
     * JENIS PABX
     * ==========================================================
     */
    public ?string $jenis = 'all';

    /**
     * ==========================================================
     * SORT
     * ==========================================================
     *
     * Field default:
     *     IDAssignment
     *
     * Arah default:
     *     ASC
     */
    public string $sortField = 'IDAssignment';

    public string $sortDirection = 'asc';


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

        /**
         * Reset sorting setiap kali modal dibuka.
         */
        $this->sortField = 'IDAssignment';

        $this->sortDirection = 'asc';

        $this->show = true;
    }


    /**
     * ==========================================================
     * SORT BY
     * ==========================================================
     */
    public function sortBy(string $field): void
    {
        $allowedFields = [
            'IDAssignment',
            'NoAssetIT',
            'Jenis',
            'NoExt',
            'Pin',
            'Keterangan',

            /**
             * Kolom dari tabel mstasset.
             */
            'asset.Nama',

            /**
             * Kolom dari tabel mstkaryawan.
             *
             * PENTING:
             * Karyawan diambil dari:
             *
             * trxpabxassignment.NIK
             *     ->
             * mstkaryawan.NIK
             */
            'karyawan.Nama',

            /**
             * Kolom dari mstruangan.
             */
            'ruangan.NamaRuangan',

            /**
             * Kolom dari mstsambungan.
             */
            'sambungan.Rule',
        ];

        if (! in_array($field, $allowedFields, true)) {
            return;
        }

        /**
         * Kalau klik header yang sama,
         * toggle ASC <-> DESC.
         */
        if ($this->sortField === $field) {

            $this->sortDirection =
                $this->sortDirection === 'asc'
                    ? 'desc'
                    : 'asc';

            return;
        }

        /**
         * Kalau klik header berbeda,
         * mulai dari ASC.
         */
        $this->sortField = $field;

        $this->sortDirection = 'asc';
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

        /**
         * Reset sorting.
         */
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
     * SUMBER UTAMA:
     *
     *     trxpabxassignment
     *
     *
     * RELATION:
     *
     *     NoAssetIT
     *         ->
     *     mstasset.NoAssetIT
     *
     *
     *     NIK
     *         ->
     *     mstkaryawan.NIK
     *
     *
     *     IDRuangan
     *         ->
     *     mstruangan.IDRuangan
     *
     *
     *     IDSambungan
     *         ->
     *     mstsambungan.IDSambungan
     *
     *
     * LOKASI:
     *
     *     mstasset.IDLokasi
     *
     *
     * SORT:
     *
     *     Dilakukan langsung oleh database
     *     menggunakan JOIN.
     */
    public function getAssignmentsProperty()
    {
        $query = TrxPabxAssignment::query()

            /**
             * ==================================================
             * JOIN ASSET
             * ==================================================
             *
             * Untuk:
             *
             * - Nama Asset
             * - Lokasi
             */
            ->leftJoin(
                'mstasset',
                'trxpabxassignment.NoAssetIT',
                '=',
                'mstasset.NoAssetIT'
            )

            /**
             * ==================================================
             * JOIN KARYAWAN
             * ==================================================
             *
             * PENTING:
             *
             * Karyawan diambil dari:
             *
             * trxpabxassignment.NIK
             *     ->
             * mstkaryawan.NIK
             *
             * BUKAN dari mstasset.NIK.
             */
            ->leftJoin(
                'mstkaryawan',
                'trxpabxassignment.NIK',
                '=',
                'mstkaryawan.NIK'
            )

            /**
             * ==================================================
             * JOIN RUANGAN
             * ==================================================
             */
            ->leftJoin(
                'mstruangan',
                'trxpabxassignment.IDRuangan',
                '=',
                'mstruangan.IDRuangan'
            )

            /**
             * ==================================================
             * JOIN SAMBUNGAN
             * ==================================================
             */
            ->leftJoin(
                'mstsambungan',
                'trxpabxassignment.IDSambungan',
                '=',
                'mstsambungan.IDSambungan'
            )

            /**
             * ==================================================
             * SELECT
             * ==================================================
             *
             * Karena menggunakan JOIN,
             * kita harus menentukan tabel utama.
             */
            ->select(
                'trxpabxassignment.*'
            );


        /**
         * ==========================================================
         * FILTER LOKASI
         * ==========================================================
         *
         * Lokasi berasal dari:
         *
         *     mstasset.IDLokasi
         *
         * BUKAN dari karyawan.
         */
        $query->when(
            $this->location !== null &&
            $this->location !== 'all',

            function ($query) {

                $query->where(
                    'mstasset.IDLokasi',
                    $this->location
                );
            }
        );


        /**
         * ==========================================================
         * FILTER JENIS
         * ==========================================================
         */
        $query->when(
            $this->jenis !== null &&
            $this->jenis !== 'all',

            function ($query) {

                $query->where(
                    'trxpabxassignment.Jenis',
                    $this->jenis
                );
            }
        );


        /**
         * ==========================================================
         * MAPPING SORT FIELD
         * ==========================================================
         *
         * Property Livewire:
         *
         *     asset.Nama
         *
         * diubah menjadi:
         *
         *     mstasset.Nama
         */
        $sortColumns = [

            'IDAssignment' =>
                'trxpabxassignment.IDAssignment',

            'NoAssetIT' =>
                'trxpabxassignment.NoAssetIT',

            'Jenis' =>
                'trxpabxassignment.Jenis',

            'NoExt' =>
                'trxpabxassignment.NoExt',

            'Pin' =>
                'trxpabxassignment.Pin',

            'Keterangan' =>
                'trxpabxassignment.Keterangan',

            'asset.Nama' =>
                'mstasset.Nama',

            /**
             * KARYAWAN DARI TRXPABXASSIGNMENT.NIK
             */
            'karyawan.Nama' =>
                'mstkaryawan.Nama',

            'ruangan.NamaRuangan' =>
                'mstruangan.NamaRuangan',

            'sambungan.Rule' =>
                'mstsambungan.Rule',
        ];


        /**
         * ==========================================================
         * SORT DATABASE
         * ==========================================================
         */
        $sortColumn =
            $sortColumns[$this->sortField]
            ?? 'trxpabxassignment.IDAssignment';


        $sortDirection =
            $this->sortDirection === 'desc'
                ? 'desc'
                : 'asc';


        $query->orderBy(
            $sortColumn,
            $sortDirection
        );


        /**
         * ==========================================================
         * SECONDARY SORT
         * ==========================================================
         *
         * Kalau ada nilai yang sama,
         * tetap gunakan IDAssignment sebagai urutan kedua.
         */
        if ($sortColumn !== 'trxpabxassignment.IDAssignment') {

            $query->orderBy(
                'trxpabxassignment.IDAssignment',
                'asc'
            );
        }


        /**
         * ==========================================================
         * LOAD RELATIONSHIP
         * ==========================================================
         *
         * Relationship tetap di-load untuk digunakan Blade.
         */
        return $query
            ->with([

                /**
                 * Asset
                 */
                'asset',

                /**
                 * Perusahaan asset
                 */
                'asset.perusahaan',

                /**
                 * Lokasi asset
                 */
                'asset.lokasi',

                /**
                 * ==================================================
                 * KARYAWAN
                 * ==================================================
                 *
                 * Ini menggunakan:
                 *
                 * trxpabxassignment.NIK
                 * ->
                 * mstkaryawan.NIK
                 */
                'karyawan',

                /**
                 * Ruangan
                 */
                'ruangan',

                /**
                 * Sambungan
                 */
                'sambungan',

            ])
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
