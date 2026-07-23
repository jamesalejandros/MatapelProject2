<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::table('trxserviceasset', function (Blueprint $table) {

            $table->dropForeign([
                'NoAssetIT'
            ]);

        });


        Schema::table('trxserviceasset', function (Blueprint $table) {

            $table->foreign('NoAssetIT')
                ->references('NoAssetIT')
                ->on('mstasset')
                ->cascadeOnDelete();

        });

    }


    public function down(): void
    {

        Schema::table('trxserviceasset', function (Blueprint $table) {

            $table->dropForeign([
                'NoAssetIT'
            ]);

        });


        Schema::table('trxserviceasset', function (Blueprint $table) {

            $table->foreign('NoAssetIT')
                ->references('NoAssetIT')
                ->on('mstasset');

        });

    }

};
