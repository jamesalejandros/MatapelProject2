<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('trxretireasset', function(Blueprint $table){

            $table->id('IDRetire');


            $table->unsignedBigInteger('IDAsset');


            $table->string('NoRetireSAP',255)
                  ->nullable();


            $table->dateTime('TanggalRetire')
                  ->useCurrent();



            $table->string('AlasanRetire',100);



            $table->text('KeteranganDetail')
                  ->nullable();



            $table->string('EksekutorIT',255)
                  ->nullable();



            $table->decimal('NilaiSisa',18,2)
                  ->default(0);



            $table->foreign('IDAsset')
                ->references('IDAsset')
                ->on('mstasset');

        });

    }



    public function down(): void
    {
        Schema::dropIfExists('trxretireasset');
    }

};