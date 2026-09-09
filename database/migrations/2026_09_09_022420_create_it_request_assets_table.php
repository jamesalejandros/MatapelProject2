<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('it_request_assets', function (Blueprint $table) {

            $table->id();

            $table
                ->unsignedBigInteger('it_request_id');

            $table
                ->string('NoAssetIT', 255);

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
                ->foreign('NoAssetIT')
                ->references('NoAssetIT')
                ->on('mstasset')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'it_request_id',
                'NoAssetIT',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'it_request_assets'
        );
    }
};
