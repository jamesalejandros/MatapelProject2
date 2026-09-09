<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('it_requests', function (Blueprint $table) {

            $table->id('IDRequest');

            $table
                ->string('NoRequest', 50)
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | PEMOHON
            |--------------------------------------------------------------------------
            */

            $table
                ->unsignedBigInteger('UserPemohonID');

            /*
            |--------------------------------------------------------------------------
            | JENIS PERMINTAAN
            |--------------------------------------------------------------------------
            */

            $table
                ->string('JenisPermintaan', 30);

            /*
            |--------------------------------------------------------------------------
            | ISI REQUEST
            |--------------------------------------------------------------------------
            */

            $table
                ->text('Permintaan');

            $table
                ->text('Keterangan')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | ASSET
            |--------------------------------------------------------------------------
            |
            | Nullable karena request bisa dibuat sebelum Asset IT
            | diketahui / diinput.
            |
            */

            $table
                ->string('NoAssetIT', 255)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | PENYELESAI
            |--------------------------------------------------------------------------
            */

            $table
                ->unsignedBigInteger('UserPenyelesaiID')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table
                ->string('Status', 30)
                ->default('diajukan');

            /*
            |--------------------------------------------------------------------------
            | PENYELESAIAN
            |--------------------------------------------------------------------------
            */

            $table
                ->date('RencanaSelesai')
                ->nullable();

            $table
                ->dateTime('TanggalSelesai')
                ->nullable();

            $table
                ->text('CatatanPenyelesaian')
                ->nullable();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEYS
            |--------------------------------------------------------------------------
            */

            $table
                ->foreign('UserPemohonID')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table
                ->foreign('UserPenyelesaiID')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table
                ->foreign('NoAssetIT')
                ->references('NoAssetIT')
                ->on('mstasset')
                ->cascadeOnUpdate()
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('UserPemohonID');
            $table->index('UserPenyelesaiID');
            $table->index('NoAssetIT');
            $table->index('JenisPermintaan');
            $table->index('Status');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('it_requests');
    }
};
