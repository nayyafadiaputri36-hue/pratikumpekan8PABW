<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sipustaka.com'],
            [
                'name' => 'Admin SiPustaka',
                'password' => 'admin123',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@sipustaka.com'],
            [
                'name' => 'User SiPustaka',
                'password' => 'user123',
                'role' => 'user',
            ]
        );
    }
}