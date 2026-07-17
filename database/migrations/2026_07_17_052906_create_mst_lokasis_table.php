<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('mstlokasi', function(Blueprint $table){

            $table->id('IDLokasi');

            $table->string('NamaLokasi',100);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('mstlokasi');
    }

};