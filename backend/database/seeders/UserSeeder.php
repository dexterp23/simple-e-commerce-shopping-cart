<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //add admin
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            User::factory()->make([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'role' => config("users.role.admin"),
                'password' => 'admin'
            ])->getAttributes()
        );

        //add user
        User::firstOrCreate(
            ['email' => 'user@user.com'],
            User::factory()->make([
                'name' => 'User',
                'email' => 'user@user.com',
                'role' => config("users.role.user"),
                'password' => 'user'
            ])->getAttributes()
        );
    }
}
