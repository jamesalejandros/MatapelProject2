<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * ==========================================================
     * ROLE & PERMISSION SEEDER
     * ==========================================================
     *
     * Role:
     *
     * 1. super_admin
     * 2. user
     *
     * super_admin:
     * - Tidak membutuhkan permission satu per satu.
     * - Akan dibypass melalui Gate::before().
     * - Otomatis memiliki akses penuh.
     *
     * user:
     * - Tidak memiliki permission awal.
     * - Permission diberikan secara individual oleh super_admin.
     * - Permission user disimpan melalui model_has_permissions.
     *
     * Permission:
     * - Seluruh permission Resource tetap dibuat di tabel
     *   permissions.
     * - Tidak ada permission yang diberikan ke role user.
     */
    public function run(): void
    {
        /**
         * ======================================================
         * RESET PERMISSION CACHE
         * ======================================================
         */
        app(
            PermissionRegistrar::class
        )->forgetCachedPermissions();


        /**
         * ======================================================
         * GUARD
         * ======================================================
         */
        $guard = 'web';


        /**
         * ======================================================
         * CREATE ROLES
         * ======================================================
         */

        $superAdminRole = Role::firstOrCreate(
            [
                'name' => 'super_admin',
                'guard_name' => $guard,
            ]
        );

        $userRole = Role::firstOrCreate(
            [
                'name' => 'user',
                'guard_name' => $guard,
            ]
        );


        /**
         * ======================================================
         * PERMISSION LIST
         * ======================================================
         *
         * Seluruh permission Resource dibuat di tabel
         * permissions.
         *
         * Permission TIDAK diberikan kepada role user.
         *
         * Permission user nantinya diberikan oleh super_admin
         * secara individual melalui model_has_permissions.
         */
        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | MST ASSET
            |--------------------------------------------------------------------------
            */

            'mstasset.view',
            'mstasset.create',
            'mstasset.update',
            'mstasset.delete',


            /*
            |--------------------------------------------------------------------------
            | MST DEPARTEMEN
            |--------------------------------------------------------------------------
            */

            'mstdepartemen.view',
            'mstdepartemen.create',
            'mstdepartemen.update',
            'mstdepartemen.delete',


            /*
            |--------------------------------------------------------------------------
            | MST KARYAWAN
            |--------------------------------------------------------------------------
            */

            'mstkaryawan.view',
            'mstkaryawan.create',
            'mstkaryawan.update',
            'mstkaryawan.delete',


            /*
            |--------------------------------------------------------------------------
            | MST LOKASI
            |--------------------------------------------------------------------------
            */

            'mstlokasi.view',
            'mstlokasi.create',
            'mstlokasi.update',
            'mstlokasi.delete',


            /*
            |--------------------------------------------------------------------------
            | MST PERUSAHAAN
            |--------------------------------------------------------------------------
            */

            'mstperusahaan.view',
            'mstperusahaan.create',
            'mstperusahaan.update',
            'mstperusahaan.delete',


            /*
            |--------------------------------------------------------------------------
            | MST RUANGAN
            |--------------------------------------------------------------------------
            */

            'mstruangan.view',
            'mstruangan.create',
            'mstruangan.update',
            'mstruangan.delete',


            /*
            |--------------------------------------------------------------------------
            | MST SAMBUNGAN
            |--------------------------------------------------------------------------
            */

            'mstsambungan.view',
            'mstsambungan.create',
            'mstsambungan.update',
            'mstsambungan.delete',


            /*
            |--------------------------------------------------------------------------
            | MST SOFTWARE
            |--------------------------------------------------------------------------
            */

            'mstsoftware.view',
            'mstsoftware.create',
            'mstsoftware.update',
            'mstsoftware.delete',


            /*
            |--------------------------------------------------------------------------
            | MST SOFTWARE LICENSE
            |--------------------------------------------------------------------------
            */

            'mstsoftwarelicense.view',
            'mstsoftwarelicense.create',
            'mstsoftwarelicense.update',
            'mstsoftwarelicense.delete',


            /*
            |--------------------------------------------------------------------------
            | MST VENDOR
            |--------------------------------------------------------------------------
            */

            'mstvendor.view',
            'mstvendor.create',
            'mstvendor.update',
            'mstvendor.delete',


            /*
            |--------------------------------------------------------------------------
            | TRX CCTV ASSIGNMENT
            |--------------------------------------------------------------------------
            */

            'trxcctvassignment.view',
            'trxcctvassignment.create',
            'trxcctvassignment.update',
            'trxcctvassignment.delete',


            /*
            |--------------------------------------------------------------------------
            | TRX MUTASI ASSET
            |--------------------------------------------------------------------------
            */

            'trxmutasiasset.view',
            'trxmutasiasset.create',
            'trxmutasiasset.update',
            'trxmutasiasset.delete',


            /*
            |--------------------------------------------------------------------------
            | TRX PABX ASSIGNMENT
            |--------------------------------------------------------------------------
            */

            'trxpabxassignment.view',
            'trxpabxassignment.create',
            'trxpabxassignment.update',
            'trxpabxassignment.delete',


            /*
            |--------------------------------------------------------------------------
            | TRX RETIRE ASSET
            |--------------------------------------------------------------------------
            */

            'trxretireasset.view',
            'trxretireasset.create',
            'trxretireasset.update',
            'trxretireasset.delete',


            /*
            |--------------------------------------------------------------------------
            | TRX SERVICE ASSET
            |--------------------------------------------------------------------------
            */

            'trxserviceasset.view',
            'trxserviceasset.create',
            'trxserviceasset.update',
            'trxserviceasset.delete',


            /*
            |--------------------------------------------------------------------------
            | TRX SOFTWARE ASSIGNMENT
            |--------------------------------------------------------------------------
            */

            'trxsoftwareassignment.view',
            'trxsoftwareassignment.create',
            'trxsoftwareassignment.update',
            'trxsoftwareassignment.delete',

        ];


        /**
         * ======================================================
         * CREATE PERMISSIONS
         * ======================================================
         *
         * Permission hanya dibuat di tabel permissions.
         *
         * Tidak diberikan kepada role user.
         */
        foreach ($permissions as $permissionName) {

            Permission::firstOrCreate(
                [
                    'name' => $permissionName,
                    'guard_name' => $guard,
                ]
            );
        }


        /**
         * ======================================================
         * USER ROLE
         * ======================================================
         *
         * User TIDAK memiliki permission melalui role.
         *
         * Dengan demikian:
         *
         * role_has_permissions
         *
         * untuk role "user" tetap kosong.
         *
         * Permission user nantinya diberikan secara individual
         * melalui model_has_permissions oleh super_admin.
         */
        $userRole->syncPermissions([]);


        /**
         * ======================================================
         * SUPER ADMIN
         * ======================================================
         *
         * super_admin sengaja tidak diberi daftar permission.
         *
         * Akses super_admin akan dilakukan melalui:
         *
         * Gate::before()
         *
         * sehingga:
         *
         * $user->can(...)
         *
         * akan selalu TRUE untuk super_admin.
         */
        $superAdminRole->syncPermissions([]);


        /**
         * ======================================================
         * CLEAR CACHE LAGI
         * ======================================================
         */
        app(
            PermissionRegistrar::class
        )->forgetCachedPermissions();


        /**
         * ======================================================
         * OUTPUT
         * ======================================================
         */
        $this->command?->info(
            'Role dan permission berhasil dibuat.'
        );

        $this->command?->info(
            'Role: super_admin'
        );

        $this->command?->info(
            'Role: user'
        );

        $this->command?->info(
            'User tidak memiliki permission awal.'
        );

        $this->command?->info(
            'Permission user diberikan secara individual oleh super_admin.'
        );
    }
}
