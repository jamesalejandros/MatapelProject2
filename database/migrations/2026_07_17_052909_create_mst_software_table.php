<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('mstsoftware', function(Blueprint $table){

            $table->id('IDSoftware');


            $table->string('KodeSoftwareCustom',255)
                  ->unique();



            $table->string('NamaSoftware',255);



            $table->string('SoftCategory',255)
                  ->nullable();



            $table->string('Jenis',255)
                  ->nullable();



            $table->string('Version',255)
                  ->nullable();



            $table->boolean('Is32Bit')
                  ->default(false);



            $table->boolean('Is64Bit')
                  ->default(false);



            $table->text('Keterangan')
                  ->nullable();

        });

    }



    public function down(): void
    {
        Schema::dropIfExists('mstsoftware');
    }

};