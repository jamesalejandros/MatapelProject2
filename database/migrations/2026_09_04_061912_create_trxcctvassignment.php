<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trxcctvassignment', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('IDAssignment');


            /*
            |--------------------------------------------------------------------------
            | ASSET CCTV
            |--------------------------------------------------------------------------
            |
            | Relasi:
            |
            | trxcctvassignment.NoAssetIT
            |              ↓
            | mstasset.NoAssetIT
            |
            */

            $table->string('NoAssetIT', 255);


            /*
            |--------------------------------------------------------------------------
            | CHANNEL
            |--------------------------------------------------------------------------
            |
            | Nomor channel kamera.
            |
            */

            $table->string('Channel', 50);


            /*
            |--------------------------------------------------------------------------
            | JENIS CCTV
            |--------------------------------------------------------------------------
            |
            | Disimpan sebagai string.
            |
            | Nilai dari Form:
            |
            | IP
            | Analog
            |
            */

            $table->string('Jenis', 50);


            /*
            |--------------------------------------------------------------------------
            | TANGGAL PASANG
            |--------------------------------------------------------------------------
            */

            $table->date('TanggalPasang')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | TIPE CCTV
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | Dome
            | Bullet
            | PTZ
            | Turret
            | dll.
            |
            */

            $table->string('Tipe', 100)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | KONDISI
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | Baik
            | Rusak
            | Maintenance
            | dll.
            |
            */

            $table->string('Kondisi', 50)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | KETERANGAN
            |--------------------------------------------------------------------------
            */

            $table->text('Keterangan')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY ASSET
            |--------------------------------------------------------------------------
            */

            $table->foreign('NoAssetIT')
                ->references('NoAssetIT')
                ->on('mstasset')
                ->cascadeOnDelete();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('trxcctvassignment');
    }
};