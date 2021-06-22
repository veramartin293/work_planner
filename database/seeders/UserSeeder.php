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
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'role' => 'admin',
                'password' => Hash::make('123')
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'role' => 'general',
                'password' => Hash::make('123')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
