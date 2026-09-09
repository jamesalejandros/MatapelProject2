<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MIGRATE JENIS PERMINTAAN LAMA
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                'it_requests',
                'JenisPermintaan'
            )
        ) {

            $requests = DB::table('it_requests')
                ->select(
                    'IDRequest',
                    'JenisPermintaan'
                )
                ->whereNotNull('JenisPermintaan')
                ->where(
                    'JenisPermintaan',
                    '!=',
                    ''
                )
                ->get();

            foreach ($requests as $request) {

                /*
                |--------------------------------------------------------------------------
                | Cari master berdasarkan nama
                |--------------------------------------------------------------------------
                */

                $jenisPermintaan =
                    DB::table('mstjenispermintaan')
                        ->where(
                            'name',
                            $request->JenisPermintaan
                        )
                        ->first();

                /*
                |--------------------------------------------------------------------------
                | Jika belum ada, buat master
                |--------------------------------------------------------------------------
                */

                if (!$jenisPermintaan) {

                    $jenisPermintaanId =
                        DB::table(
                            'mstjenispermintaan'
                        )->insertGetId([

                            'name' =>
                                $request->JenisPermintaan,

                            'is_active' =>
                                true,

                            'created_at' =>
                                now(),

                            'updated_at' =>
                                now(),

                        ]);

                } else {

                    $jenisPermintaanId =
                        $jenisPermintaan->id;

                }

                /*
                |--------------------------------------------------------------------------
                | Insert pivot
                |--------------------------------------------------------------------------
                */

                DB::table(
                    'it_request_jenis_permintaan'
                )->updateOrInsert(

                    [
                        'it_request_id' =>
                            $request->IDRequest,

                        'jenis_permintaan_id' =>
                            $jenisPermintaanId,
                    ],

                    [
                        'created_at' =>
                            now(),

                        'updated_at' =>
                            now(),
                    ]

                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | MIGRATE ASSET LAMA
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                'it_requests',
                'NoAssetIT'
            )
        ) {

            $requests = DB::table('it_requests')
                ->select(
                    'IDRequest',
                    'NoAssetIT'
                )
                ->whereNotNull('NoAssetIT')
                ->where(
                    'NoAssetIT',
                    '!=',
                    ''
                )
                ->get();

            foreach ($requests as $request) {

                /*
                |--------------------------------------------------------------------------
                | Pastikan asset masih ada
                |--------------------------------------------------------------------------
                */

                $assetExists =
                    DB::table('mstasset')
                        ->where(
                            'NoAssetIT',
                            $request->NoAssetIT
                        )
                        ->exists();

                if (!$assetExists) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Insert pivot
                |--------------------------------------------------------------------------
                */

                DB::table(
                    'it_request_assets'
                )->updateOrInsert(

                    [
                        'it_request_id' =>
                            $request->IDRequest,

                        'NoAssetIT' =>
                            $request->NoAssetIT,
                    ],

                    [
                        'created_at' =>
                            now(),

                        'updated_at' =>
                            now(),
                    ]

                );
            }
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS RELASI HASIL MIGRASI
        |--------------------------------------------------------------------------
        |
        | Jangan menghapus master mstjenispermintaan karena
        | master tersebut mungkin sudah digunakan oleh data baru.
        |
        */

        // Sengaja tidak melakukan rollback data secara otomatis.
        //
        // Alasannya:
        // data pada pivot mungkin sudah digunakan oleh request
        // baru setelah migration ini dijalankan.
    }
};
