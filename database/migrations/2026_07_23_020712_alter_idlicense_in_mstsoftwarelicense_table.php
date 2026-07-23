<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mstsoftwarelicense', function (Blueprint $table) {

            // drop foreign key jika ada yang mengarah ke IDLicense
            // (kalau tidak ada, abaikan)

        });

        DB::statement("
        ALTER TABLE mstsoftwarelicense
        MODIFY IDLicense BIGINT UNSIGNED NOT NULL
    ");

        DB::statement("
        ALTER TABLE mstsoftwarelicense
        MODIFY IDLicense BIGINT UNSIGNED NOT NULL
    ");

        DB::statement("
        ALTER TABLE mstsoftwarelicense
        ALTER COLUMN IDLicense DROP DEFAULT
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mstsoftwarelicense', function (Blueprint $table) {
            //
        });
    }
};
