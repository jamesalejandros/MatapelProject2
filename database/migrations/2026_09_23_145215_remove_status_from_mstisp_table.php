<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mstisp', function (Blueprint $table) {
            $table->dropColumn('Status');
        });
    }

    public function down(): void
    {
        Schema::table('mstisp', function (Blueprint $table) {
            $table->string('Status', 30)
                ->nullable()
                ->after('Keterangan');
        });
    }
};
