<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * ==========================================================
     * RUN MIGRATION
     * ==========================================================
     */

    public function up(): void
    {
        Schema::table(
            'activity_log',
            function (Blueprint $table) {

                $table->string('subject_id')
                    ->nullable()
                    ->change();

            }
        );
    }


    /**
     * ==========================================================
     * REVERSE MIGRATION
     * ==========================================================
     */

    public function down(): void
    {
        Schema::table(
            'activity_log',
            function (Blueprint $table) {

                $table->unsignedBigInteger('subject_id')
                    ->nullable()
                    ->change();

            }
        );
    }
};
