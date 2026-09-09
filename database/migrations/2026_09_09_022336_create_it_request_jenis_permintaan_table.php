<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('it_request_jenis_permintaan', function (Blueprint $table) {

            $table->id();

            $table
                ->unsignedBigInteger('it_request_id');

            $table
                ->unsignedBigInteger('jenis_permintaan_id');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEYS
            |--------------------------------------------------------------------------
            */

            $table
                ->foreign('it_request_id')
                ->references('IDRequest')
                ->on('it_requests')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('jenis_permintaan_id')
                ->references('id')
                ->on('mstjenispermintaan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            */

            $table->unique(
    ['it_request_id', 'jenis_permintaan_id'],
    'req_jenis_unique'
);


        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'it_request_jenis_permintaan'
        );
    }
};
