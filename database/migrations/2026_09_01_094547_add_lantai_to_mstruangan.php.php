<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mstruangan', function (Blueprint $table) {

            $table->string('Lantai', 50)
                ->nullable()
                ->after('NamaRuangan');

        });
    }

    public function down(): void
    {
        Schema::table('mstruangan', function (Blueprint $table) {

            $table->dropColumn('Lantai');

        });
    }
};
