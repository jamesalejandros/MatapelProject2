<?php
namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
     * ROLE:
     *
     * 1. super_admin
     * 2. user
     * 3. staff_it
     *
     *
     * SUPER ADMIN:
     *
     * - Tidak membutuhkan permission satu per satu.
     * - Tidak memiliki permission melalui role_has_permissions.
     * - Akses penuh diberikan melalui Gate::before().
     *
     *
     * USER:
     *
     * - Tidak memiliki permission awal.
     * - Tidak memiliki permission melalui role.
     * - Permission diberikan secara individual oleh super_admin.
     * - Permission individual disimpan melalui
     * model_has_permissions.
     *
     *
     * STAFF IT:
     *
     * - Memiliki role staff_it.
     * - Memiliki permission Permintaan IT melalui role.
     * - Permission disimpan melalui role_has_permissions.
     *
     *
     * PERMISSION:
     *
     * - Seluruh permission Resource tetap dibuat di tabel
     * permissions.
     * - Tidak diberikan kepada super_admin.
     * - Tidak diberikan kepada user.
     * - Permission khusus staff_it diberikan melalui role.
     */
    public function run(): void
    {

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
                'name' =>
                    'super_admin',

                'guard_name' =>
                    $guard,
            ]
        );

        $userRole = Role::firstOrCreate(
            [
                'name' =>
                    'user',

                'guard_name' =>
                    $guard,
            ]
        );

        $staffItRole = Role::firstOrCreate(
            [
                'name' =>
                    'staff_it',

                'guard_name' =>
                    $guard,
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
         * Permission TIDAK diberikan kepada role super_admin.
         *
         * Permission user nantinya diberikan secara individual
         * melalui model_has_permissions.
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
         * IT REQUEST PERMISSIONS
         * ======================================================
         *
         * Permission khusus modul Permintaan IT.
         *
         * Permission ini hanya akan diberikan kepada
         * role staff_it.
         */

        $itRequestPermissions = [

            'itrequest.view',
            'itrequest.create',
            'itrequest.update',
            'itrequest.delete',

        ];

        /**
         * ======================================================
         * CREATE ALL PERMISSIONS
         * ======================================================
         *
         * Permission hanya dibuat di tabel permissions.
         *
         * Tidak diberikan kepada super_admin.
         *
         * Tidak diberikan kepada user.
         */

        foreach (
            [
                ...$permissions,
                ...$itRequestPermissions,
            ]
            as $permissionName
        ) {

            Permission::firstOrCreate(
                [
                    'name' =>
                        $permissionName,

                    'guard_name' =>
                        $guard,
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
         * role_has_permissions untuk user harus kosong.
         *
         * Permission user nantinya diberikan secara individual
         * melalui model_has_permissions.
         */

        $userRole->syncPermissions([]);

        /**
         * ======================================================
         * SUPER ADMIN
         * ======================================================
         *
         * super_admin sengaja tidak diberi daftar permission.
         *
         * Akses super_admin dilakukan melalui Gate::before().
         *
         * Dengan demikian role_has_permissions untuk
         * super_admin tetap kosong.
         */

        $superAdminRole->syncPermissions([]);

        /**
         * ======================================================
         * STAFF IT
         * ======================================================
         *
         * Staff IT mendapatkan permission Permintaan IT
         * melalui role.
         *
         * Permission masuk ke:
         *
         * role_has_permissions
         *
         * Bukan:
         *
         * model_has_permissions
         */

        $staffItRole->syncPermissions(
            $itRequestPermissions
        );

        /**
         * ======================================================
         * CREATE / UPDATE SUPER ADMIN
         * ======================================================
         *
         * Credential dapat diatur melalui .env:
         *
         * SEED_SUPER_ADMIN_NAME
         * SEED_SUPER_ADMIN_EMAIL
         * SEED_SUPER_ADMIN_PASSWORD
         */

        $superAdmin = User::updateOrCreate(

            [
                'email' =>
                    env(
                        'SEED_SUPER_ADMIN_EMAIL',
                        'superadmin@example.com'
                    ),
            ],

            [
                'name' =>
                    env(
                        'SEED_SUPER_ADMIN_NAME',
                        'Super Admin'
                    ),

                'password' =>
                    Hash::make(
                        env(
                            'SEED_SUPER_ADMIN_PASSWORD',
                            '12345678'
                        )
                    ),

                'email_verified_at' =>
                    now(),
            ]

        );

        /**
         * ======================================================
         * ASSIGN SUPER ADMIN ROLE
         * ======================================================
         */

        $superAdmin->syncRoles(
            [$superAdminRole]
        );

        /**
         * ======================================================
         * CREATE / UPDATE USER
         * ======================================================
         *
         * User tidak mendapatkan permission awal.
         */

        $user = User::updateOrCreate(

            [
                'email' =>
                    env(
                        'SEED_USER_EMAIL',
                        'user@example.com'
                    ),
            ],

            [
                'name' =>
                    env(
                        'SEED_USER_NAME',
                        'User'
                    ),

                'password' =>
                    Hash::make(
                        env(
                            'SEED_USER_PASSWORD',
                            '12345678'
                        )
                    ),

                'email_verified_at' =>
                    now(),
            ]

        );

        /**
         * ======================================================
         * ASSIGN USER ROLE
         * ======================================================
         */

        $user->syncRoles(
            [$userRole]
        );

        /**
         * ======================================================
         * CLEAR DIRECT PERMISSIONS
         * ======================================================
         *
         * User dan super_admin tidak boleh mendapatkan
         * permission langsung dari seeder ini.
         *
         * Permission individual user nantinya diberikan
         * melalui User Management.
         */

        $superAdmin->syncPermissions([]);

        $user->syncPermissions([]);

        /**
         * ======================================================
         * CLEAR CACHE
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
            'Role: staff_it'
        );

        $this->command?->info(
            'super_admin tidak memiliki permission melalui role.'
        );

        $this->command?->info(
            'user tidak memiliki permission awal.'
        );

        $this->command?->info(
            'staff_it memiliki permission Permintaan IT melalui role.'
        );

        $this->command?->info(
            'Super Admin berhasil dibuat/diperbarui: ' .
            $superAdmin->email
        );

        $this->command?->info(
            'User berhasil dibuat/diperbarui: ' .
            $user->email
        );
    }

}