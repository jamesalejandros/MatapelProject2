<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('mstsoftwarelicense', function(Blueprint $table){

            $table->id('IDLicense');



            $table->unsignedBigInteger('IDSoftware');



            $table->unsignedBigInteger('IDPerusahaan');



            $table->text('ProductKey')
                  ->nullable();



            $table->string('TipeLisensi',255)
                  ->nullable();



            $table->integer('JumlahLisensi')
                  ->default(1);



            $table->boolean('HasDVD')
                  ->default(false);



            $table->string('Barcode',255)
                  ->nullable();



            $table->string('LokasiSimpan',255)
                  ->nullable();



            $table->string('TempatSimpan',255)
                  ->nullable();



            $table->string('StatusLisensi',50)
                  ->default('Active');




            // FK Software

            $table->foreign('IDSoftware')
                ->references('IDSoftware')
                ->on('mstsoftware')
                ->cascadeOnDelete();




            // FK Perusahaan

            $table->foreign('IDPerusahaan')
                ->references('IDPerusahaan')
                ->on('mstperusahaan');

        });

    }



    public function down(): void
    {
        Schema::dropIfExists('mstsoftwarelicense');
    }

};