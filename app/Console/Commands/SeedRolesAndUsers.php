<?php

namespace App\Console\Commands;

use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;

class SeedRolesAndUsers extends Command
{
    /**
     * ==========================================================
     * COMMAND
     * ==========================================================
     */
    protected $signature = 'db:seed-roles-users';


    /**
     * ==========================================================
     * DESCRIPTION
     * ==========================================================
     */
    protected $description =
        'Seed role, permission, dan user awal aplikasi';


    /**
     * ==========================================================
     * HANDLE
     * ==========================================================
     */
    public function handle(): int
    {
        $this->info(
            '=========================================='
        );

        $this->info(
            ' ROLE & USER SEEDER'
        );

        $this->info(
            '=========================================='
        );


        /**
         * ======================================================
         * STEP 1
         * ======================================================
         */
        $this->newLine();

        $this->info(
            '[1/2] Menjalankan RolePermissionSeeder...'
        );

        $this->call(
            RolePermissionSeeder::class
        );


        /**
         * ======================================================
         * STEP 2
         * ======================================================
         */
        $this->newLine();

        $this->info(
            '[2/2] Menjalankan UserSeeder...'
        );

        $this->call(
            UserSeeder::class
        );


        /**
         * ======================================================
         * DONE
         * ======================================================
         */
        $this->newLine();

        $this->info(
            '=========================================='
        );

        $this->info(
            ' Role dan User berhasil di-seed.'
        );

        $this->info(
            '=========================================='
        );


        return self::SUCCESS;
    }
}