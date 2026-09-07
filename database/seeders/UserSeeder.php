<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * ==========================================================
     * USER SEEDER
     * ==========================================================
     *
     * Membuat user awal:
     *
     * 1. super_admin
     * 2. user
     *
     * Credential diambil dari .env.
     */
    public function run(): void
    {
        /**
         * ======================================================
         * ROLE
         * ======================================================
         */
        $superAdminRole = Role::findByName(
            'super_admin',
            'web'
        );

        $userRole = Role::findByName(
            'user',
            'web'
        );


        /**
         * ======================================================
         * SUPER ADMIN
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
         * USER
         * ======================================================
         *
         * Credential dapat diatur melalui .env:
         *
         * SEED_USER_NAME
         * SEED_USER_EMAIL
         * SEED_USER_PASSWORD
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
         * OUTPUT
         * ======================================================
         */
        $this->command?->info(
            'User super_admin berhasil dibuat/diperbarui: ' .
            $superAdmin->email
        );

        $this->command?->info(
            'User user berhasil dibuat/diperbarui: ' .
            $user->email
        );
    }
}
