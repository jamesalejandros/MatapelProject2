<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * ============================================================
         * 1. MSTKARYAWAN
         * ============================================================
         *
         * Tambahkan:
         *
         * NIKKepalaBagian
         *      ↓
         * mstkaryawan.NIK
         *
         * Tidak ada perubahan data.
         */


        if (!Schema::hasColumn('mstkaryawan', 'NIKKepalaBagian')) {

            Schema::table('mstkaryawan', function (Blueprint $table) {

                $table->string('NIKKepalaBagian', 30)
                    ->nullable()
                    ->after('IDLokasi');
            });
        }


        /*
         * Tambahkan index jika belum ada.
         */

        if (!$this->indexExists(
            'mstkaryawan',
            'idx_mstkaryawan_kepala_bagian'
        )) {

            Schema::table('mstkaryawan', function (Blueprint $table) {

                $table->index(
                    'NIKKepalaBagian',
                    'idx_mstkaryawan_kepala_bagian'
                );
            });
        }


        /*
         * Tambahkan foreign key jika belum ada.
         */

        if (!$this->foreignKeyExists(
            'mstkaryawan',
            'fk_mstkaryawan_kepala_bagian'
        )) {

            Schema::table('mstkaryawan', function (Blueprint $table) {

                $table->foreign(
                    'NIKKepalaBagian',
                    'fk_mstkaryawan_kepala_bagian'
                )
                    ->references('NIK')
                    ->on('mstkaryawan')
                    ->nullOnDelete();
            });
        }


        /*
         * ============================================================
         * 2. USERS.NIK → MSTKARYAWAN.NIK
         * ============================================================
         *
         * Hanya perubahan schema.
         *
         * Tidak ada data users yang diubah.
         */


        /*
         * Index users.NIK
         */

        if (!$this->indexExists(
            'users',
            'idx_users_nik'
        )) {

            Schema::table('users', function (Blueprint $table) {

                $table->index(
                    'NIK',
                    'idx_users_nik'
                );
            });
        }


        /*
         * Foreign key users.NIK
         */

        if (!$this->foreignKeyExists(
            'users',
            'fk_users_karyawan'
        )) {

            Schema::table('users', function (Blueprint $table) {

                $table->foreign(
                    'NIK',
                    'fk_users_karyawan'
                )
                    ->references('NIK')
                    ->on('mstkaryawan')
                    ->nullOnDelete();
            });
        }


        /*
         * ============================================================
         * 3. USERS
         * ============================================================
         *
         * Hapus:
         *
         * users.kepala_bagian_id
         *
         * Tidak ada data yang dipindahkan.
         */


        if (Schema::hasColumn('users', 'kepala_bagian_id')) {

            /*
             * Cari dan hapus FK yang menggunakan
             * kepala_bagian_id.
             *
             * Tidak mengasumsikan nama FK tertentu.
             */

            $foreignKeys = DB::select("
                SELECT
                    CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'users'
                  AND COLUMN_NAME = 'kepala_bagian_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            foreach ($foreignKeys as $foreignKey) {

                Schema::table('users', function (Blueprint $table) use ($foreignKey) {

                    $table->dropForeign(
                        $foreignKey->CONSTRAINT_NAME
                    );
                });
            }


            /*
             * Cari index yang menggunakan
             * kepala_bagian_id.
             */

            $indexes = DB::select("
                SELECT DISTINCT
                    INDEX_NAME
                FROM information_schema.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'users'
                  AND COLUMN_NAME = 'kepala_bagian_id'
                  AND INDEX_NAME != 'PRIMARY'
            ");

            foreach ($indexes as $index) {

                Schema::table('users', function (Blueprint $table) use ($index) {

                    $table->dropIndex(
                        $index->INDEX_NAME
                    );
                });
            }


            /*
             * Baru hapus kolom.
             */

            Schema::table('users', function (Blueprint $table) {

                $table->dropColumn('kepala_bagian_id');
            });
        }


        /*
         * ============================================================
         * 4. IT_REQUEST_APPROVALS
         * ============================================================
         *
         * Tambahkan:
         *
         * approver_id
         *
         * Tidak memindahkan data lama.
         */


        if (!Schema::hasColumn(
            'it_request_approvals',
            'approver_id'
        )) {

            Schema::table('it_request_approvals', function (Blueprint $table) {

                $table->unsignedBigInteger('approver_id')
                    ->nullable()
                    ->after('it_request_id');
            });
        }


        /*
         * Index approver_id.
         */

        if (!$this->indexExists(
            'it_request_approvals',
            'idx_it_request_approvals_approver'
        )) {

            Schema::table('it_request_approvals', function (Blueprint $table) {

                $table->index(
                    'approver_id',
                    'idx_it_request_approvals_approver'
                );
            });
        }


        /*
         * Foreign key approver_id → users.id
         */

        if (!$this->foreignKeyExists(
            'it_request_approvals',
            'fk_it_request_approvals_approver'
        )) {

            Schema::table('it_request_approvals', function (Blueprint $table) {

                $table->foreign(
                    'approver_id',
                    'fk_it_request_approvals_approver'
                )
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        }


        /*
         * ============================================================
         * 5. IT_REQUEST_APPROVALS
         * ============================================================
         *
         * Hapus:
         *
         * kepala_bagian_id
         *
         * Jika kolom sudah terhapus dari percobaan sebelumnya,
         * jangan melakukan apa-apa.
         */


        if (Schema::hasColumn(
            'it_request_approvals',
            'kepala_bagian_id'
        )) {

            /*
             * Hapus FK lama berdasarkan metadata database.
             */

            $foreignKeys = DB::select("
                SELECT
                    CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'it_request_approvals'
                  AND COLUMN_NAME = 'kepala_bagian_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            foreach ($foreignKeys as $foreignKey) {

                Schema::table(
                    'it_request_approvals',
                    function (Blueprint $table) use ($foreignKey) {

                        $table->dropForeign(
                            $foreignKey->CONSTRAINT_NAME
                        );
                    }
                );
            }


            /*
             * Hapus index lama.
             */

            $indexes = DB::select("
                SELECT DISTINCT
                    INDEX_NAME
                FROM information_schema.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'it_request_approvals'
                  AND COLUMN_NAME = 'kepala_bagian_id'
                  AND INDEX_NAME != 'PRIMARY'
            ");

            foreach ($indexes as $index) {

                Schema::table(
                    'it_request_approvals',
                    function (Blueprint $table) use ($index) {

                        $table->dropIndex(
                            $index->INDEX_NAME
                        );
                    }
                );
            }


            /*
             * Hapus kolom hanya jika masih ada.
             */

            if (Schema::hasColumn(
                'it_request_approvals',
                'kepala_bagian_id'
            )) {

                Schema::table(
                    'it_request_approvals',
                    function (Blueprint $table) {

                        $table->dropColumn('kepala_bagian_id');
                    }
                );
            }
        }


        /*
         * ============================================================
         * 6. HAPUS MSTKEPALABAGIAN
         * ============================================================
         *
         * Tidak ada migrasi data.
         *
         * Jika tabel sudah dihapus pada percobaan sebelumnya,
         * tidak terjadi error.
         */

        if (Schema::hasTable('mstkepalabagian')) {

            Schema::drop('mstkepalabagian');
        }
    }


    /*
     * ================================================================
     * HELPER: CEK INDEX
     * ================================================================
     */

    private function indexExists(
        string $table,
        string $index
    ): bool {
        $result = DB::select(
            "
            SELECT COUNT(*) AS count
            FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND INDEX_NAME = ?
            ",
            [
                $table,
                $index,
            ]
        );

        return ((int) $result[0]->count) > 0;
    }


    /*
     * ================================================================
     * HELPER: CEK FOREIGN KEY
     * ================================================================
     */

    private function foreignKeyExists(
        string $table,
        string $foreignKey
    ): bool {
        $result = DB::select(
            "
            SELECT COUNT(*) AS count
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND CONSTRAINT_NAME = ?
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
            ",
            [
                $table,
                $foreignKey,
            ]
        );

        return ((int) $result[0]->count) > 0;
    }


    /*
     * ================================================================
     * DOWN
     * ================================================================
     */

    public function down(): void
    {
        throw new RuntimeException(
            'Rollback migration ini harus dilakukan secara manual.'
        );
    }
};
