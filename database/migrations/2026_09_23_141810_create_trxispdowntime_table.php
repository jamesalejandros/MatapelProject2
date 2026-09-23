<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trxispdowntime', function (Blueprint $table) {
            $table->bigIncrements('IDDowntime');

            $table->unsignedBigInteger('IDISP');

            $table->string('NoTiket', 100)->nullable();

            $table->dateTime('TanggalMulai');
            $table->dateTime('TanggalSelesai')->nullable();

            // Total downtime dalam jam
            $table->decimal('TotalJam', 10, 2)->nullable();

            $table->text('LokasiPutus')->nullable();
            $table->text('Penyebab')->nullable();
            $table->text('Dampak')->nullable();
            $table->text('Keterangan')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('IDISP')
                ->references('IDISP')
                ->on('mstisp')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('IDISP');
            $table->index('NoTiket');
            $table->index('TanggalMulai');
            $table->index('TanggalSelesai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trxispdowntime');
    }
};
