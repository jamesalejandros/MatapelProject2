<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('it_requests', function (Blueprint $table) {

            if (
                Schema::hasColumn(
                    'it_requests',
                    'JenisPermintaan'
                )
            ) {
                $table->dropColumn(
                    'JenisPermintaan'
                );
            }

            if (
                Schema::hasColumn(
                    'it_requests',
                    'NoAssetIT'
                )
            ) {
                $table->dropForeign([
                    'NoAssetIT'
                ]);

                $table->dropIndex([
                    'NoAssetIT'
                ]);

                $table->dropColumn(
                    'NoAssetIT'
                );
            }

        });
    }

    public function down(): void
    {
        Schema::table('it_requests', function (Blueprint $table) {

            $table
                ->string(
                    'JenisPermintaan',
                    30
                )
                ->nullable();

            $table
                ->string(
                    'NoAssetIT',
                    255
                )
                ->nullable();

            $table
                ->index(
                    'JenisPermintaan'
                );

            $table
                ->index(
                    'NoAssetIT'
                );

            $table
                ->foreign('NoAssetIT')
                ->references('NoAssetIT')
                ->on('mstasset')
                ->cascadeOnUpdate()
                ->nullOnDelete();

        });
    }
};
