<?php

namespace App\Filament\Resources\UserPermissions\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Spatie\Permission\Models\Permission;


class UserPermissionForm
{
    public static function configure(
        Schema $schema
    ): Schema {

        return $schema->components([

            /**
             * ==================================================
             * INFORMASI USER
             * ==================================================
             */

            Section::make(
                'Informasi User'
            )
                ->description(
                    'Informasi akun yang sedang diatur hak aksesnya.'
                )
                ->schema([

                    TextInput::make('name')
                        ->label('Nama')
                        ->disabled(),

                    TextInput::make('email')
                        ->label('Email')
                        ->disabled(),

                ])
                ->columns(2)

                /**
                 * ==================================================
                 * FULL WIDTH
                 * ==================================================
                 *
                 * Section mengambil seluruh lebar container.
                 *
                 * Dengan columnSpanFull(), section tidak akan
                 * berada berdampingan dengan Section Hak Akses.
                 */
                ->columnSpanFull(),


            /**
             * ==================================================
             * HAK AKSES
             * ==================================================
             */

            Section::make(
                'Hak Akses'
            )
                ->description(
                    'Tentukan fitur dan tindakan yang dapat dilakukan oleh user ini.'
                )
                ->schema([

                    CheckboxList::make(
                        'permissions'
                    )
                        ->label('Daftar Hak Akses')

                        /**
                         * ======================================
                         * OPTIONS
                         * ======================================
                         *
                         * Permission tetap menggunakan nama
                         * teknis di database.
                         *
                         * Label yang ditampilkan dibuat lebih
                         * mudah dipahami oleh admin.
                         */

                        ->options([

                            /*
                            |--------------------------------------------------------------------------
                            | MST ASSET
                            |--------------------------------------------------------------------------
                            */

                            'mstasset.view' =>
                                'Asset — Lihat',

                            'mstasset.create' =>
                                'Asset — Tambah',

                            'mstasset.update' =>
                                'Asset — Edit',

                            'mstasset.delete' =>
                                'Asset — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST DEPARTEMEN
                            |--------------------------------------------------------------------------
                            */

                            'mstdepartemen.view' =>
                                'Departemen — Lihat',

                            'mstdepartemen.create' =>
                                'Departemen — Tambah',

                            'mstdepartemen.update' =>
                                'Departemen — Edit',

                            'mstdepartemen.delete' =>
                                'Departemen — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST KARYAWAN
                            |--------------------------------------------------------------------------
                            */

                            'mstkaryawan.view' =>
                                'Karyawan — Lihat',

                            'mstkaryawan.create' =>
                                'Karyawan — Tambah',

                            'mstkaryawan.update' =>
                                'Karyawan — Edit',

                            'mstkaryawan.delete' =>
                                'Karyawan — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST LOKASI
                            |--------------------------------------------------------------------------
                            */

                            'mstlokasi.view' =>
                                'Lokasi — Lihat',

                            'mstlokasi.create' =>
                                'Lokasi — Tambah',

                            'mstlokasi.update' =>
                                'Lokasi — Edit',

                            'mstlokasi.delete' =>
                                'Lokasi — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST PERUSAHAAN
                            |--------------------------------------------------------------------------
                            */

                            'mstperusahaan.view' =>
                                'Perusahaan — Lihat',

                            'mstperusahaan.create' =>
                                'Perusahaan — Tambah',

                            'mstperusahaan.update' =>
                                'Perusahaan — Edit',

                            'mstperusahaan.delete' =>
                                'Perusahaan — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST RUANGAN
                            |--------------------------------------------------------------------------
                            */

                            'mstruangan.view' =>
                                'Ruangan — Lihat',

                            'mstruangan.create' =>
                                'Ruangan — Tambah',

                            'mstruangan.update' =>
                                'Ruangan — Edit',

                            'mstruangan.delete' =>
                                'Ruangan — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST SAMBUNGAN
                            |--------------------------------------------------------------------------
                            */

                            'mstsambungan.view' =>
                                'Sambungan — Lihat',

                            'mstsambungan.create' =>
                                'Sambungan — Tambah',

                            'mstsambungan.update' =>
                                'Sambungan — Edit',

                            'mstsambungan.delete' =>
                                'Sambungan — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST SOFTWARE
                            |--------------------------------------------------------------------------
                            */

                            'mstsoftware.view' =>
                                'Software — Lihat',

                            'mstsoftware.create' =>
                                'Software — Tambah',

                            'mstsoftware.update' =>
                                'Software — Edit',

                            'mstsoftware.delete' =>
                                'Software — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST SOFTWARE LICENSE
                            |--------------------------------------------------------------------------
                            */

                            'mstsoftwarelicense.view' =>
                                'Software License — Lihat',

                            'mstsoftwarelicense.create' =>
                                'Software License — Tambah',

                            'mstsoftwarelicense.update' =>
                                'Software License — Edit',

                            'mstsoftwarelicense.delete' =>
                                'Software License — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | MST VENDOR
                            |--------------------------------------------------------------------------
                            */

                            'mstvendor.view' =>
                                'Vendor — Lihat',

                            'mstvendor.create' =>
                                'Vendor — Tambah',

                            'mstvendor.update' =>
                                'Vendor — Edit',

                            'mstvendor.delete' =>
                                'Vendor — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | TRX CCTV ASSIGNMENT
                            |--------------------------------------------------------------------------
                            */

                            'trxcctvassignment.view' =>
                                'CCTV Assignment — Lihat',

                            'trxcctvassignment.create' =>
                                'CCTV Assignment — Tambah',

                            'trxcctvassignment.update' =>
                                'CCTV Assignment — Edit',

                            'trxcctvassignment.delete' =>
                                'CCTV Assignment — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | TRX MUTASI ASSET
                            |--------------------------------------------------------------------------
                            */

                            'trxmutasiasset.view' =>
                                'Mutasi Asset — Lihat',

                            'trxmutasiasset.create' =>
                                'Mutasi Asset — Tambah',

                            'trxmutasiasset.update' =>
                                'Mutasi Asset — Edit',

                            'trxmutasiasset.delete' =>
                                'Mutasi Asset — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | TRX PABX ASSIGNMENT
                            |--------------------------------------------------------------------------
                            */

                            'trxpabxassignment.view' =>
                                'PABX Assignment — Lihat',

                            'trxpabxassignment.create' =>
                                'PABX Assignment — Tambah',

                            'trxpabxassignment.update' =>
                                'PABX Assignment — Edit',

                            'trxpabxassignment.delete' =>
                                'PABX Assignment — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | TRX RETIRE ASSET
                            |--------------------------------------------------------------------------
                            */

                            'trxretireasset.view' =>
                                'Retire Asset — Lihat',

                            'trxretireasset.create' =>
                                'Retire Asset — Tambah',

                            'trxretireasset.update' =>
                                'Retire Asset — Edit',

                            'trxretireasset.delete' =>
                                'Retire Asset — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | TRX SERVICE ASSET
                            |--------------------------------------------------------------------------
                            */

                            'trxserviceasset.view' =>
                                'Service Asset — Lihat',

                            'trxserviceasset.create' =>
                                'Service Asset — Tambah',

                            'trxserviceasset.update' =>
                                'Service Asset — Edit',

                            'trxserviceasset.delete' =>
                                'Service Asset — Hapus',


                            /*
                            |--------------------------------------------------------------------------
                            | TRX SOFTWARE ASSIGNMENT
                            |--------------------------------------------------------------------------
                            */

                            'trxsoftwareassignment.view' =>
                                'Software Assignment — Lihat',

                            'trxsoftwareassignment.create' =>
                                'Software Assignment — Tambah',

                            'trxsoftwareassignment.update' =>
                                'Software Assignment — Edit',

                            'trxsoftwareassignment.delete' =>
                                'Software Assignment — Hapus',

                        ])

                        /**
                         * ======================================
                         * LAYOUT
                         * ======================================
                         *
                         * 4 permission per baris:
                         *
                         * Lihat | Tambah | Edit | Hapus
                         */

                        ->columns(4)

                        ->gridDirection('row')

                        /**
                         * ======================================
                         * SEARCH
                         * ======================================
                         */

                        ->searchable()

                        /**
                         * ======================================
                         * BULK TOGGLE
                         * ======================================
                         */

                        ->bulkToggleable()

                        /**
                         * ======================================
                         * HELPER
                         * ======================================
                         */

                        ->helperText(
                            'Centang hak akses yang ingin diberikan. Permission yang tidak dicentang tidak dapat digunakan oleh user.'
                        ),

                ])

                /**
                 * ==================================================
                 * FULL WIDTH
                 * ==================================================
                 *
                 * Section Hak Akses juga mengambil seluruh
                 * lebar container.
                 */
                ->columnSpanFull(),

        ]);
    }
}
