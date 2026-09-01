<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trxpabxassignment', function (Blueprint $table) {

            $table->string('Pin', 100)
                ->nullable()
                ->after('Jenis');

            $table->string('Sambungan', 255)
                ->nullable()
                ->after('Pin');

        });
    }

    public function down(): void
    {
        Schema::table('trxpabxassignment', function (Blueprint $table) {

            $table->dropColumn([
                'Pin',
                'Sambungan',
            ]);

        });
    }
};
