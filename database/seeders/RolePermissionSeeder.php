<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{

    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Asset
            'view asset',
            'create asset',
            'edit asset',
            'delete asset',

            // Mutasi
            'view mutasi',
            'create mutasi',
            'edit mutasi',

            // Service
            'view service',
            'create service',
            'edit service',

            // Retire
            'view retire',
            'create retire',

            // Software
            'manage software',

            // Master
            'manage master',

            // User
            'manage user',

            // Report
            'view report',

        ];


        foreach($permissions as $permission){

            Permission::firstOrCreate([
                'name'=>$permission,
                'guard_name'=>'web'
            ]);

        }



        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */


        $superAdmin = Role::firstOrCreate([
            'name'=>'Super Admin'
        ]);


        $manager = Role::firstOrCreate([
            'name'=>'IT Manager'
        ]);


        $support = Role::firstOrCreate([
            'name'=>'IT Support'
        ]);


        $viewer = Role::firstOrCreate([
            'name'=>'Viewer'
        ]);



        /*
        |--------------------------------------------------------------------------
        | Role Permission
        |--------------------------------------------------------------------------
        */


        $superAdmin
            ->syncPermissions(
                Permission::all()
            );



        $manager
            ->syncPermissions([
                'view asset',
                'create asset',
                'edit asset',
                'view mutasi',
                'create mutasi',
                'view service',
                'view retire',
                'manage software',
                'view report'
            ]);



        $support
            ->syncPermissions([
                'view asset',
                'create mutasi',
                'edit mutasi',
                'create service',
                'edit service',
            ]);



        $viewer
            ->syncPermissions([
                'view asset',
                'view report'
            ]);

    }

}