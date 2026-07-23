<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mstsoftwarelicense', function (Blueprint $table) {
            $table->text('Keterangan')
                ->nullable()
                ->after('TempatSimpan');
        });
    }

    public function down(): void
    {
        Schema::table('mstsoftwarelicense', function (Blueprint $table) {
            $table->dropColumn('Keterangan');
        });
    }
};