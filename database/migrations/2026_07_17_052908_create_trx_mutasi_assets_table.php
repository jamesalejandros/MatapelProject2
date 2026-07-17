<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('trxmutasiasset', function(Blueprint $table){

            $table->id('IDMutasi');


            $table->unsignedBigInteger('IDAsset');


            $table->string('NoTransferSAP',255)
                  ->nullable();


            $table->dateTime('TanggalMutasi')
                  ->useCurrent();



            // REVISI
            // Pengganti User + Dept + Perusahaan

            $table->string('NIK',30);



            $table->unsignedBigInteger('IDLokasi')
                  ->nullable();



            $table->string('AksesWebsite',50)
                  ->nullable();


            $table->char('AksesEmail',10)
                  ->nullable();



            $table->string('Lapor',50)
                  ->nullable();


            $table->string('Keterangan',255)
                  ->nullable();



            $table->boolean('IsActive')
                  ->default(true);



            // FK

            $table->foreign('IDAsset')
                ->references('IDAsset')
                ->on('mstasset')
                ->cascadeOnDelete();



            $table->foreign('NIK')
                ->references('NIK')
                ->on('mstkaryawan');



            $table->foreign('IDLokasi')
                ->references('IDLokasi')
                ->on('mstlokasi');

        });

    }



    public function down(): void
    {
        Schema::dropIfExists('trxmutasiasset');
    }

};