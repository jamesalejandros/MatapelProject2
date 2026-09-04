<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mstsoftwarelicense', function (Blueprint $table) {
            $table->date('ExpiredDate')
                ->nullable()
                ->after('StatusLisensi');
        });
    }

    public function down(): void
    {
        Schema::table('mstsoftwarelicense', function (Blueprint $table) {
            $table->dropColumn('ExpiredDate');
        });
    }
};
