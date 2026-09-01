<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mstruangan', function (Blueprint $table) {

            $table->id('IDRuangan');

            $table->string('NamaRuangan', 100);

            $table->unsignedBigInteger('IDLokasi')
                ->nullable();

            $table->foreign('IDLokasi')
                ->references('IDLokasi')
                ->on('mstlokasi')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mstruangan');
    }
};
