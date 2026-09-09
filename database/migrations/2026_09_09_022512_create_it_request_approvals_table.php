<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('it_request_approvals', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | REQUEST
            |--------------------------------------------------------------------------
            */

            $table
                ->unsignedBigInteger('it_request_id');

            /*
            |--------------------------------------------------------------------------
            | KEPALA BAGIAN
            |--------------------------------------------------------------------------
            */

            $table
                ->unsignedBigInteger('kepala_bagian_id');

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table
                ->string('status', 20)
                ->default('pending');

            /*
            |--------------------------------------------------------------------------
            | CATATAN
            |--------------------------------------------------------------------------
            */

            $table
                ->text('catatan')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | APPROVAL TIME
            |--------------------------------------------------------------------------
            */

            $table
                ->dateTime('approved_at')
                ->nullable();

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
                ->foreign('kepala_bagian_id')
                ->references('id')
                ->on('mstkepalabagian')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('it_request_id');

            $table->index('kepala_bagian_id');

            $table->index('status');

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            |
            | Satu request hanya mempunyai satu approval
            | dari satu Kepala Bagian.
            |
            */

            $table->unique([
                'it_request_id',
                'kepala_bagian_id',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'it_request_approvals'
        );
    }
};
