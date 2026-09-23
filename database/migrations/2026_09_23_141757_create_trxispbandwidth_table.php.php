<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trxispbandwidth', function (Blueprint $table) {
            $table->bigIncrements('IDBandwidth');

            $table->unsignedBigInteger('IDISP');

            $table->date('TanggalUpgrade');

            // Satuan bandwidth: Mbps
            $table->decimal('BandwidthInternasional', 15, 2);
            $table->decimal('BandwidthLokal', 15, 2);

            $table->decimal('Harga', 18, 2);

            $table->text('Keterangan')->nullable();
            $table->string('Status', 30);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('IDISP')
                ->references('IDISP')
                ->on('mstisp')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('IDISP');
            $table->index('TanggalUpgrade');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trxispbandwidth');
    }
};
