<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('mstasset', function (Blueprint $table) {

    $table->string('NoAssetIT',255)->primary();

    $table->string('NoAssetSAP',255)->nullable();

    $table->string('Jenis',255)->nullable();

    $table->string('Nama',255)->nullable();

    $table->string('PN',255)->nullable();

    $table->string('SN',255)->nullable();

    $table->string('PN_LCD',255)->nullable();

    $table->string('SN_LCD',255)->nullable();

    $table->string('RAM',50)->nullable();

    $table->text('JenisOS')->nullable();

    $table->string('ComputerName',255)->nullable();

    $table->string('IPAddress',50)->nullable();

    $table->string('StatusBeli',50)
          ->default('Baru')
          ->nullable();

    $table->dateTime('TanggalBeli')
          ->nullable();

    $table->decimal('Harga',18,2)
          ->nullable();

    $table->unsignedBigInteger('IDVendor')
          ->nullable();

    $table->string('Garansi',255)
          ->nullable();

    $table->dateTime('DateWarranty')
          ->nullable();

    $table->unsignedBigInteger('IDPerusahaan');

    $table->string('StatusAsset',50)
          ->default('Available');

    $table->foreign('IDVendor')
        ->references('IDVendor')
        ->on('mstvendor');

    $table->foreign('IDPerusahaan')
        ->references('IDPerusahaan')
        ->on('mstperusahaan');

});

    }



    public function down(): void
    {
        Schema::dropIfExists('mstasset');
    }

};