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
     * - Awalnya hanya CRUD:
     *      mstruangan
     *      trxsoftwareassignment
     *
     * Permission dapat ditambahkan kemudian.
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
         * Permission awal untuk role user.
         */
        $permissions = [

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
            | TRX SOFTWARE ASSIGNMENT
            |--------------------------------------------------------------------------
            */

            'trxsoftwareassignment.view',
            'trxsoftwareassignment.create',
            'trxsoftwareassignment.update',
            'trxsoftwareassignment.delete',

            /*
    |--------------------------------------------------------------------------
    | TRX PABX ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    'trxpabxassignment.view',
    'trxpabxassignment.create',
    'trxpabxassignment.update',
    'trxpabxassignment.delete',

        ];


        /**
         * ======================================================
         * CREATE PERMISSIONS
         * ======================================================
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
         * ASSIGN PERMISSIONS TO USER ROLE
         * ======================================================
         *
         * syncPermissions() memastikan role user hanya
         * mendapatkan permission yang didefinisikan di sini.
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
            'Permission awal user: mstruangan + trxsoftwareassignment'
        );
    }
}
