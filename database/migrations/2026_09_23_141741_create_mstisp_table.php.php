<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mstisp', function (Blueprint $table) {
            $table->bigIncrements('IDISP');

            $table->string('ISPCode', 50)->unique();
            $table->string('NamaISP', 150);

            $table->unsignedBigInteger('IDVendor');
            $table->unsignedBigInteger('IDLokasi');

            $table->string('MediaType', 50)->nullable();

            $table->date('ContractStart')->nullable();
            $table->date('ContractEnd')->nullable();
            $table->integer('ContractPeriodMonth')->nullable();

            // SLA dalam persen, contoh: 99.90
            $table->decimal('SLA', 5, 2)->nullable();

            $table->text('Keterangan')->nullable();
            $table->string('Status', 30);

            $table->boolean('IsActive')->default(true);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('IDVendor')
                ->references('IDVendor')
                ->on('mstvendor')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('IDLokasi')
                ->references('IDLokasi')
                ->on('mstlokasi')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('IDVendor');
            $table->index('IDLokasi');
            $table->index('Status');
            $table->index('IsActive');
            $table->index('ContractEnd');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mstisp');
    }
};
