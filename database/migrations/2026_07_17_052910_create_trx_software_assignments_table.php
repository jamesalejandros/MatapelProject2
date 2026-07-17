<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('trxsoftwareassignment', function(Blueprint $table){

            $table->id('IDAssignment');



            $table->unsignedBigInteger('IDLicense');



            $table->unsignedBigInteger('IDAsset');



            $table->dateTime('TanggalAssign')
                  ->useCurrent();



            $table->dateTime('TanggalRevoke')
                  ->nullable();



            $table->string('StatusAssignment',50)
                  ->default('Installed');




            // FK License

            $table->foreign('IDLicense')
                ->references('IDLicense')
                ->on('mstsoftwarelicense')
                ->cascadeOnDelete();




            // FK Asset

            $table->foreign('IDAsset')
                ->references('IDAsset')
                ->on('mstasset')
                ->cascadeOnDelete();

        });

    }



    public function down(): void
    {
        Schema::dropIfExists('trxsoftwareassignment');
    }

};