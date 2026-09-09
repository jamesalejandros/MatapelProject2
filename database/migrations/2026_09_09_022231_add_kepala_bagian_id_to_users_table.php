<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table
                ->unsignedBigInteger('kepala_bagian_id')
                ->nullable()
                ->after('NIK');

            $table
                ->foreign('kepala_bagian_id')
                ->references('id')
                ->on('mstkepalabagian')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->index('kepala_bagian_id');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign([
                'kepala_bagian_id'
            ]);

            $table->dropIndex([
                'kepala_bagian_id'
            ]);

            $table->dropColumn(
                'kepala_bagian_id'
            );

        });
    }
};
