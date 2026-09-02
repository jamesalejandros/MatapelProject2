<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trxpabxassignment', function (Blueprint $table) {

            // Hapus field Sambungan lama
            $table->dropColumn('Sambungan');

            // Tambahkan field IDSambungan sebagai relasi
            $table->unsignedBigInteger('IDSambungan')
                ->nullable()
                ->after('Pin');

            // Tambahkan field Keterangan biasa
            $table->text('Keterangan')
                ->nullable()
                ->after('IDSambungan');

            // Foreign key ke mstsambungan
            $table->foreign('IDSambungan')
                ->references('IDSambungan')
                ->on('mstsambungan')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('trxpabxassignment', function (Blueprint $table) {

            $table->dropForeign(['IDSambungan']);

            $table->dropColumn([
                'IDSambungan',
                'Keterangan',
            ]);

            $table->string('Sambungan', 255)
                ->nullable()
                ->after('Pin');
        });
    }
};
