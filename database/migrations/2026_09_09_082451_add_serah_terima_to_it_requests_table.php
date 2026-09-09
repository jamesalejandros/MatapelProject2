<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('it_requests', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | SERAH TERIMA
            |--------------------------------------------------------------------------
            |
            | NULL = belum dikonfirmasi
            | 1    = sudah dikonfirmasi
            |
            */

            $table
                ->boolean('SerahTerima')
                ->nullable()
                ->default(null)
                ->after('CatatanPenyelesaian');

            /*
            |--------------------------------------------------------------------------
            | TANGGAL SERAH TERIMA
            |--------------------------------------------------------------------------
            |
            | Akan tetap NULL sampai pemohon melakukan konfirmasi.
            | Nilai akan diisi otomatis menggunakan now() dari controller.
            |
            */

            $table
                ->dateTime('TanggalSerahTerima')
                ->nullable()
                ->default(null)
                ->after('SerahTerima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('it_requests', function (Blueprint $table) {
            $table->dropColumn([
                'SerahTerima',
                'TanggalSerahTerima',
            ]);
        });
    }
};
