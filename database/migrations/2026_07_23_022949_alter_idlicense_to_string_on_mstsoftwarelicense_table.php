<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');


        /*
        |--------------------------------------------------------------------------
        | Drop foreign key dari tabel transaksi
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE trxsoftwareassignment
            DROP FOREIGN KEY trxsoftwareassignment_idlicense_foreign
        ");


        /*
        |--------------------------------------------------------------------------
        | Ubah kolom FK di tabel transaksi
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE trxsoftwareassignment
            MODIFY COLUMN IDLicense VARCHAR(100) NOT NULL
        ");


        /*
        |--------------------------------------------------------------------------
        | Ubah primary key IDLicense
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE mstsoftwarelicense
            MODIFY COLUMN IDLicense VARCHAR(100) NOT NULL
        ");


        /*
        |--------------------------------------------------------------------------
        | Buat ulang foreign key
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE trxsoftwareassignment
            ADD CONSTRAINT trxsoftwareassignment_idlicense_foreign
            FOREIGN KEY (IDLicense)
            REFERENCES mstsoftwarelicense(IDLicense)
            ON DELETE CASCADE
        ");


        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }


    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');


        DB::statement("
            ALTER TABLE trxsoftwareassignment
            DROP FOREIGN KEY trxsoftwareassignment_idlicense_foreign
        ");


        DB::statement("
            ALTER TABLE trxsoftwareassignment
            MODIFY COLUMN IDLicense BIGINT UNSIGNED NOT NULL
        ");


        DB::statement("
            ALTER TABLE mstsoftwarelicense
            MODIFY COLUMN IDLicense BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
        ");


        DB::statement("
            ALTER TABLE trxsoftwareassignment
            ADD CONSTRAINT trxsoftwareassignment_idlicense_foreign
            FOREIGN KEY (IDLicense)
            REFERENCES mstsoftwarelicense(IDLicense)
            ON DELETE CASCADE
        ");


        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
