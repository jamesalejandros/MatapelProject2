<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class ItRequestPermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | RESET PERMISSION CACHE
        |--------------------------------------------------------------------------
        */

        app(
            PermissionRegistrar::class
        )->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | GUARD
        |--------------------------------------------------------------------------
        */

        $guard = 'web';


        /*
        |--------------------------------------------------------------------------
        | PERMISSION
        |--------------------------------------------------------------------------
        */

        $permissions = [

            'itrequest.view',

            'itrequest.create',

            'itrequest.update',

            'itrequest.delete',

        ];


        /*
        |--------------------------------------------------------------------------
        | CREATE PERMISSION
        |--------------------------------------------------------------------------
        |
        | Permission hanya dibuat di tabel "permissions".
        |
        | Permission tidak diberikan kepada super_admin.
        |
        */

        foreach ($permissions as $permissionName) {

            Permission::firstOrCreate(
                [
                    'name' =>
                        $permissionName,

                    'guard_name' =>
                        $guard,
                ]
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        |
        | SUPER ADMIN SENGAJA TIDAK MEMILIKI PERMISSION.
        |
        | Akses super_admin diberikan melalui Gate::before().
        |
        */

        $superAdmin =
            Role::firstOrCreate(
                [
                    'name' =>
                        'super_admin',

                    'guard_name' =>
                        $guard,
                ]
            );


        $superAdmin->syncPermissions([]);


        /*
        |--------------------------------------------------------------------------
        | STAFF IT
        |--------------------------------------------------------------------------
        |
        | Staff IT mendapatkan permission Permintaan IT
        | melalui role.
        |
        */

        $staffIt =
            Role::firstOrCreate(
                [
                    'name' =>
                        'staff_it',

                    'guard_name' =>
                        $guard,
                ]
            );


        $staffIt->givePermissionTo(
            $permissions
        );


        /*
        |--------------------------------------------------------------------------
        | RESET PERMISSION CACHE
        |--------------------------------------------------------------------------
        */

        app(
            PermissionRegistrar::class
        )->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | OUTPUT
        |--------------------------------------------------------------------------
        */

        $this->command?->info(
            'Permission Permintaan IT berhasil dibuat.'
        );

        $this->command?->info(
            'super_admin tidak diberikan permission.'
        );

        $this->command?->info(
            'staff_it diberikan permission Permintaan IT.'
        );
    }
}
