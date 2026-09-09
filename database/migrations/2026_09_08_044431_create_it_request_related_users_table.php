<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('it_request_related_users', function (Blueprint $table) {

            $table->id();

            $table
                ->unsignedBigInteger('it_request_id');

            $table
                ->unsignedBigInteger('user_id');

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
                ->cascadeOnDelete();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            |
            | Satu user tidak boleh dipilih dua kali
            | pada request yang sama.
            |
            */

            $table->unique([
                'it_request_id',
                'user_id',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'it_request_related_users'
        );
    }
};
