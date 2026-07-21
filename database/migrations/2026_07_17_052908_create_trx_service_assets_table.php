<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('trxserviceasset', function(Blueprint $table){

            $table->id('IDService');


            $table->string('NoAssetIT',255);


            $table->dateTime('TanggalMasuk')
                  ->useCurrent();


            $table->dateTime('TanggalSelesai')
                  ->nullable();


            $table->string('JenisService',100)
                  ->nullable();


            $table->text('Kerusakan');


            $table->text('Tindakan')
                  ->nullable();


            $table->decimal('Biaya',18,2)
                  ->default(0);


            $table->unsignedBigInteger('IDVendor')
                  ->nullable();



            $table->string('StatusService',50)
                  ->default('Proses');


            $table->string('Oleh',100)
                  ->nullable();



            $table->foreign('NoAssetIT')
    ->references('NoAssetIT')
    ->on('mstasset');



            $table->foreign('IDVendor')
                ->references('IDVendor')
                ->on('mstvendor');

        });

    }



    public function down(): void
    {
        Schema::dropIfExists('trxserviceasset');
    }

};