<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trxpabxassignment', function (Blueprint $table) {

            $table->id('IDAssignment');

            // Asset PABX
            $table->string('NoAssetIT', 255);

            // Nomor Extension
            $table->string('NoExt', 50);

            // Assignment ke Karyawan / Ruangan
            $table->string('NIK', 30)
                ->nullable();

            $table->unsignedBigInteger('IDRuangan')
                ->nullable();

            // Lantai
            $table->string('Lantai', 50)
                ->nullable();

            // Jenis PABX
            $table->enum('Jenis', [
                'Digital',
                'Analog',
                'IP',
            ]);

            // FK Asset
            $table->foreign('NoAssetIT')
                ->references('NoAssetIT')
                ->on('mstasset')
                ->cascadeOnDelete();

            // FK Karyawan
            $table->foreign('NIK')
                ->references('NIK')
                ->on('mstkaryawan')
                ->nullOnDelete();

            // FK Ruangan
            $table->foreign('IDRuangan')
                ->references('IDRuangan')
                ->on('mstruangan')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trxpabxassignment');
    }
};
