<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('mstkaryawan', function(Blueprint $table){

            $table->string('NIK',30);

            $table->string('Nama',255);


            $table->unsignedBigInteger('IDDept');

            $table->unsignedBigInteger('IDPerusahaan');


            $table->primary('NIK');


            $table->foreign('IDDept')
                ->references('IDDept')
                ->on('mstdepartemen')
                ->cascadeOnDelete();


            $table->foreign('IDPerusahaan')
                ->references('IDPerusahaan')
                ->on('mstperusahaan')
                ->cascadeOnDelete();

        });

    }


    public function down(): void
    {
        Schema::dropIfExists('mstkaryawan');
    }

};