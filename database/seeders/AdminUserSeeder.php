<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class AdminUserSeeder extends Seeder
{

    public function run(): void
    {

        $user = User::create([
            'name'=>'Administrator',
            'email'=>'admin@itasset.com',
            'password'=>bcrypt('password')
        ]);


        $user->assignRole('Super Admin');

    }

}